<?php

class mxYouTuberData{
	
	private $_oauth_key = '';
	private $_browser_key = '';
	private $_cache_lifetime = 360;
    const YOUTUBE_API_HOST = 'https://www.googleapis.com/youtube/v3/';
    const CACHE_KEY = 'mxYouTubeR';
	
	public function __construct(){
		$this->_oauth_key = mxYoutubeR_getConfig('googleOAuthKey');
		$this->_browser_key = mxYoutubeR_getConfig('googleBrowserKey');
		$this->_cache_lifetime = mxYoutubeR_getConfig('cache_lifetime');
	}
	
	public function getVideo($id){
		$response = $this->getData( 'videos' , array(
            'part'          => 'snippet,statistics,contentDetails',
            'maxResults'    => (is_array($id)?count($id):1),
            'id'            => (is_array($id)?implode(',',$id):$id)
        ));

        if( !isset($response->items[0]) ) {
            if(is_array($id)){
				throw new Exception('Videos IDs:'.implode(' ,',$id).' not found');
			}
			else{
				throw new Exception('Video ID:'.$id.' not found');
			}
        }
        
        return (is_array($id)?$response->items:$response->items[0]);
	}
	
	public function getChannel($id){
        $response = $this->getData( 'channels' , array(
            'part' => 'snippet,contentDetails,brandingSettings,statistics',
            'id' => $id
        ));

        if( !isset($response->items[0]) ) {
            throw new Exception('Channel ID:'.$channelId.' not found');
        }

        return $response->items[0];
	}
	
	private function buildRequestURI($type,$data){
		
	}
		
    private function getRequestURI( $type,$data ){
        $data['key'] = $this->_browser_key;
        return self::YOUTUBE_API_HOST.$type.'?'.http_build_query( $data );
    }

	private function getData($type,$data){
		if( !class_exists( 'WP_Http' ) ) include_once( ABSPATH . WPINC. '/class-http.php' ); 
		
		$qID = md5($this->getRequestURI( $type,$data ));
		$cached = get_transient( $qID );

		if($cached!==false){
			return json_decode(base64_decode($cached));
		}
		
		$request = new WP_Http;
		$result = $request->request( 
			$this->getRequestURI( $type,$data ), 
			array( 
				'method' => 'GET',
				'headers' => array('Accept' => 'application/json' )
			) 
		);
	
		if ( is_wp_error( $result ) ) {
		   $error_string = $result->get_error_message();
		   throw new Exception('WP Error: '.$error_string);
		}
		
		if( $result['response']['code'] != 200 ) {
			throw new Exception('YouTube server responce error.');
		}
	
		set_transient($qID, base64_encode($result['body']), (int)$this->_cache_lifetime);
	
		return json_decode($result['body']);
	}

}