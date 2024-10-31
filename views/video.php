<?php

class mxYouTuberView_video extends mxYouTuberView_base{
	
	public function __construct($attribs){
		$this->setTemplate('video');
		$dataModel = mxYoutubeR_getDataModel();
        
		$this->video = $dataModel->getVideo( $attribs['id'] );
        $this->channel = $dataModel->getChannel( $this->video->snippet->channelId );
		
		if($attribs['size']==''){
			$attribs['size'] = 'default';
			if(isset($this->video->snippet->thumbnails->medium)) $attribs['size'] = 'medium';
			else if(isset($this->video->snippet->thumbnails->maxres)) $attribs['size'] = 'maxres';
			else if(isset($this->video->snippet->thumbnails->high)) $attribs['size'] = 'high';
			else if(isset($this->video->snippet->thumbnails->standard)) $attribs['size'] = 'standard';
		}
		$this->showTitle = strpos($attribs['display'],'title')!==false;
		$this->showChannel = strpos($attribs['display'],'channel')!==false;
		$this->showDescription = strpos($attribs['display'],'description')!==false;
		$this->showMeta = strpos($attribs['display'],'meta')!==false;
		$this->showDate = strpos($attribs['display'],'date')!==false;
		
		$this->attribs = $attribs;
	}
	
}