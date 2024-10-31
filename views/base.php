<?php

class mxYouTuberView_base{
	
	private $_tmpl = '';	
	
	
	
	
	public function render(){
		$theme = $this->attribs['theme'];
		$template = $this->getTemplate();
		$path = '';
		foreach(mxYoutubeR_getTemplatePaths($theme) as $tp){
			if(is_file($tp.'/'.$template.'.php')){
				$path = $tp.'/'.$template.'.php';
				break;
			}
		}
		if($path==''){
			throw new Exception('Template "'.$template.'" for the theme "'.$theme.'" not found.');
		}
		ob_start();
		include($path);
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}
	
	public function getVideoHTML($video,$attribs){
		$size = $attribs['size'];
		$htmlAttribs = array('autoplay=1');
		if($attribs['suggested_videos']=='false'){
			$htmlAttribs[] = 'rel=0';
		}
		switch($attribs['mode']){
			case 'embed':
				$html = '<iframe width="'.$attribs['width'].'" height="'.$attribs['height'].'" src="https://www.youtube.com/embed/'.$video->id.'?showinfo=0" frameborder="0" allowfullscreen></iframe>';
			break;
			case 'lightbox':
			case 'link':
			default:
				$html = '<a href="'.($attribs['mode']=='lightbox'?'https://www.youtube.com/embed/'.$video->id.'?'.implode('&',$htmlAttribs):'https://youtu.be/'.$video->id).'" class="mxyt-videolink '.($attribs['mode']=='lightbox'?' mxyt-lightbox':'').'" '.(isset($attribs['rel'])?'data-rel="'.$attribs['rel'].'"':'').' target="_blank">
					<span class="mxyt-play">
						<i class="mxyt-icon mxyt-icon-play"></i>
					</span>
					'.(isset($video->contentDetails->duration)?'<span class="mxyt-time">'.mxYoutubeR_getYouTubeTime($video->contentDetails->duration).'</span>':'').'
					<img src="'.$this->getThumbURL($video,$size).'" alt="'.htmlentities($video->snippet->title).'" />
				</a>';
			break;
		}
		return $html;
	}
	
	public function getThumbURL($video,$size){
		return (isset($video->snippet->thumbnails->$size)?$video->snippet->thumbnails->{$size}->url:$video->snippet->thumbnails->default->url);
	}
	
	public function setTemplate($tmpl){
		$this->_tmpl = $tmpl;
	}
	
	public function getTemplate(){
		return $this->_tmpl;
	}

}