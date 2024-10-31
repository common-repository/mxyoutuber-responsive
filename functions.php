<?php

function mxYoutubeR_renderSettingsPage(){
	
	echo '<div class="wrap">';
	echo '<h1>YouTubeR Free '.__('configuration','mx_youtuber').'</h1>';
	
	if(isset($_POST['mx-youtuber'])) {
		$cfg = array_merge( mxYoutubeR_getConfig(), $_POST['mx-youtuber'] );
		foreach($cfg as $k=>$v){
			$cfg[$k] = trim($v);
		}
		update_option( 'mx_youtuber', $cfg );
		mxYoutubeR_getConfig('',true);
		echo '<div class="updated"><p><strong>'.__('Configuration saved','mx_youtuber').'</strong></p></div>';
	}
	
	echo '<form method="post" action="'.site_url().'/wp-admin/options-general.php?page=mx-youtuber"> ';
	?>
    	<p><a href="http://youtuber.maxiolab.com" target="_blank"><img src="<?php echo MXYOUTUBER_URL;?>/mxassets/images/pro.png" alt="Get the paid version"></a></p>
        
        <table class="form-table">
            <tr> 
                <th scope="row"><?php _e('Google OAuth client ID','mx_youtuber'); ?></th>
                <td>
                    <input class="regular-text code" type="text" name="mx-youtuber[googleOAuthKey]" value="<?php echo mxYoutubeR_getConfig('googleOAuthKey'); ?>"  />
                    <p class="description">
                        <?php _e('How to create Google OAuth client ID you can see in the documentation','mx_youtuber'); ?>
                    </p>
                </td>
            </tr>
            <tr> 
                <th scope="row"><?php _e('Google Browser key','mx_youtuber'); ?></th>
                <td>
                    <input class="regular-text code" type="text" name="mx-youtuber[googleBrowserKey]" value="<?php echo mxYoutubeR_getConfig('googleBrowserKey'); ?>"  />
                    <p class="description">
                        <?php _e('How to create Google Browser key you can see in the documentation','mx_youtuber'); ?>
                    </p>
                </td>
            </tr>
        </table>
        <h3 class="title"><?php _e('Advanced configuration','mx_youtuber'); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('Cache lifetime','mx_youtuber'); ?></th>
                <td>  
                    <input class="small-text" type="number" name="mx-youtuber[cache_lifetime]" value="<?php echo mxYoutubeR_getConfig('cache_lifetime'); ?>"  />
                    <p class="description">
                        <?php _e('Cache lifetime in seconds','mx_youtuber'); ?>
                    </p>
                </td>
            </tr>
        </table> 

        <p class="submit">
            <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save configuration','mx_youtuber'); ?>" />  
        </p>
	<?php
	echo '</form>';
	echo '</div>';
}

function mxYoutubeR_getSettingsOptions($name){
	static $settings;
	if(!is_array($settings)){
		$settings = array(
			'themes' => array(
				'default' => 'default',
				'dark' => 'dark'
			),
			'modes' => array(
				'lightbox' => 'Lightbox',
				'embed' => 'Embed',
				'link' => 'Link'
			),
			'bool' => array(
				'true' => __('On','mx_youtuber'),
				'false' => __('Off','mx_youtuber'),
			),
		);
	}
	if(isset($settings[$name])){
		return $settings[$name];
	}
	else{
		return array();
	}
}

function mxYoutubeR_getConfig($option='',$update=false){
	static $cfg;
	if(!is_array($cfg) || $update){
		$cfg = get_option('mx_youtuber', array(), true);
		if(!is_array($cfg)){
			$cfg = array();
		}
		$cfg = array_merge(array(
			'googleOAuthKey' => '',
			'googleBrowserKey' => '',
			
			'theme' => 'default',
			'cols' => 3,
			'rows' => 4,
			'responsive_limit' => 'sm',
			'mode' => 'lightbox',
			'max_words' => 20,
			
			'cache_lifetime' => 3600,
			), $cfg );
	}
	if($option!=''){
		return $cfg[$option];
	}
	return $cfg;
}

function mxYoutubeR_shortcode_attribs($atts){
	$attribs = shortcode_atts( array(
		'type' => 'video',
		'id' => '',
		'display' => 'title,date,description,meta',
		'mode' => mxYoutubeR_getConfig('mode'),
		'theme' => mxYoutubeR_getConfig('theme'),
		'size' => '',
		'width' => '100%',
		'height' => '300',
		'cols' => ($atts['type']=='channel'?1:(int)mxYoutubeR_getConfig('cols')),
		'rows' => (int)mxYoutubeR_getConfig('rows'),
		'responsive_limit' => mxYoutubeR_getConfig('responsive_limit'),
		'max_words' => (int)mxYoutubeR_getConfig('max_words'),
		'infinite_scroll' => 'false',
		'load_more' => 'true',
		'pageToken' => '',
		'suggested_videos' => 'false'
	), $atts );
	
	$attribs['limit'] =  $attribs['cols']*$attribs['rows'];
	
	return $attribs;
}

function mxYoutubeR_renderShortCode( $atts ) {
	$attribs = mxYoutubeR_shortcode_attribs($atts);
	
	$viewName = 'mxYouTuberView_'.$attribs['type'];
	$classFile = MXYOUTUBER_PATH.'views/'.$attribs['type'].'.php';
	try{
		if(is_file($classFile)){
			require_once($classFile);
			$view = new $viewName($attribs);
			return $view->render();
		}
		else{
			throw new Exception('Incorrect shortcode attribute type "'.$attribs['type'].'".');
		}
	}
	catch( Exception $e){
		return '<p><strong>YouTubeR '.__('error','mx_youtuber').':</strong> '.$e->getMessage().'</p>';
	}
}

function mxYoutubeR_button(){
    echo '<button id="insert-mxyoutube-shortcode" class="button" type="button" data-editor="content" title="YouTubeR"><i class="icon-fl icon-youtube-squared"></i> YouTubeR</button>';
}

function mxYoutubeR_frontend(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('mxyoutuber_js', plugins_url( '/mxassets/js/frontend.js', __FILE__ ), array( 'jquery' ), MXYOUTUBER_VERSION);
	wp_enqueue_style('mxyoutuber_css', plugins_url( '/mxassets/css/frontend.css',__FILE__), array(), MXYOUTUBER_VERSION );
	wp_enqueue_style('google_font_roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic&subset=latin,cyrillic');
	wp_enqueue_script('lightcase_js', plugins_url( '/mxassets/lightcase/lightcase.js', __FILE__ ), array( 'jquery' ), MXYOUTUBER_VERSION);
	wp_enqueue_style('lightcase_css', plugins_url( '/mxassets/lightcase/css/lightcase.css',__FILE__), array(), MXYOUTUBER_VERSION );
}

function mxYoutubeR_backend(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('mxyoutuber_gapi', plugins_url( '/mxassets/js/media-uploader.js', __FILE__ ), array(), MXYOUTUBER_VERSION);
	wp_enqueue_script('mxyoutuber_js', plugins_url( '/mxassets/js/mxyoutube.js', __FILE__ ), array( 'jquery' ), MXYOUTUBER_VERSION);
	wp_enqueue_script('mxyoutuber_gapi_client', 'https://apis.google.com/js/client.js');
	wp_enqueue_style('mxyoutuber_css', plugins_url( '/mxassets/css/backend.css',__FILE__), array(), MXYOUTUBER_VERSION );
}

function mxYoutubeR_backendInline(){
	echo '
	<script type="text/javascript">
		jQuery(document).ready(function(){
			if(!jQuery("#insert-mxyoutube-shortcode").length){
				return;
			}
			if("'.mxYoutubeR_getConfig('googleOAuthKey').'"==""){
				alert("'.__('Please set Google OAuth client ID in the configuration','mx_youtuber').'");
			}
			else{
				wzYoutube.lang.authorize_account = "'.__('Authorize YouTube account','mx_youtuber').'";
				wzYoutube.lang.upload_video = "'.__('Upload video','mx_youtuber').'";
				wzYoutube.lang.list_videos = "'.__('Videos list','mx_youtuber').'";
				wzYoutube.lang.more_videos = "'.__('More videos','mx_youtuber').'";
				wzYoutube.lang.title = "'.__('Title','mx_youtuber').'";
				wzYoutube.lang.video_title = "'.__('Video title','mx_youtuber').'";
				wzYoutube.lang.description = "'.__('Description','mx_youtuber').'";
				wzYoutube.lang.video_description = "'.__('Video description','mx_youtuber').'";
				wzYoutube.lang.tags = "'.__('Tags','mx_youtuber').'";
				wzYoutube.lang.video_tags = "'.__('Tags, separated by comma','mx_youtuber').'";
				wzYoutube.lang.privacy_status = "'.__('Privacy Status','mx_youtuber').'";
				wzYoutube.lang.upload = "'.__('Upload','mx_youtuber').'";
				wzYoutube.lang.privacy_public = "'.__('Public','mx_youtuber').'";
				wzYoutube.lang.privacy_ulnisted = "'.__('Unlisted','mx_youtuber').'";
				wzYoutube.lang.privacy_private = "'.__('Private','mx_youtuber').'";
				wzYoutube.lang.enter_video_title = "'.__('Please enter video title','mx_youtuber').'";
				wzYoutube.lang.choose_video_file = "'.__('Please choose video file','mx_youtuber').'";
				wzYoutube.lang.pro = "'.__('check out paid version','mx_youtuber').'";
				jQuery("#insert-mxyoutube-shortcode").on("click",function(e){
					wzYoutube.init("'.mxYoutubeR_getConfig('googleOAuthKey').'",function(_videoID){
						wp.media.editor.insert(\'[mx_youtuber id="\' + _videoID + \'" display="title,date,channel,description,meta"]\');
						wzYoutube.close();
					});
					return false;
				});
			}
		});
	</script>';
}

function mxYoutubeR_getTemplatePaths($theme=''){
	$theme = ($theme!=''?$theme:mxYoutubeR_getConfig('theme'));
	$paths = array();
	$paths[] = get_template_directory().'/mxyoutuber/'.$theme;
	$paths[] = get_template_directory().'/mxyoutuber/default';
	$paths[] = MXYOUTUBER_PATH.'themes/'.$theme;
	$paths[] = MXYOUTUBER_PATH.'themes/default';
	return $paths;
}

function mxYoutubeR_getDataModel(){
	static $model;
	if(!is_object($model)){
		$model = new mxYouTuberData();
	}
	return $model;
}

function mxYoutubeR_getYouTubeTime($str){
	$int = new DateInterval($str);

	if($int->h != 0){
		$duration = $int->format('%h:%I:%S');
	}
	else{
		$duration = $int->format('%i:%S');
	}

	return $duration;
}

function mxYoutubeR_getSelectHTML($values, $selectedValue, $attribs=array()) {
	$attribsHTML = array();
	foreach($attribs as $k=>$v){
		$attribsHTML[] = $k.'="'.$v.'"';
	}
	$result = '';
	$result.= '<select '.implode(' ',$attribsHTML).'>';
		foreach ($values as $k=>$v) { 
			$selected = ($k==$selectedValue?' selected="selected"':'');
			$result.= '<option'.$selected.' value="'.$k.'">'.$v.'</option>';
		}
	$result.= '</select>';
	return $result;
}

function mxYoutubeR_pluginsLoaded(){
	load_plugin_textdomain( 'mx_youtuber', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}



