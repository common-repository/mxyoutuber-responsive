(function($){
    "use strict";
	
	var dummyTip;
    
	function reBindScripts(){
		$('a.mxyt-lightbox').lightcase({
			iframe: {'allowfullscreen':true}
		});
		
		$('.mxyt-tip').each(function(index, element) {
            var $this = $(this);
			var mainContainer = $this.closest('.mxYouTubeR');
			var _class = '';
			var matches = mainContainer.attr('class').match(/(mxYouTubeR_theme_[a-z0-9\-_]+)/);
			if(matches && matches.length>0){
				_class = matches[0];
			}
			
			$this.off('mouseenter');
			$this.on('mouseenter',function(){
				if(!dummyTip.hasClass(_class)){
					dummyTip.addClass(_class);
				}
				dummyTip.children('span').html($this.attr('title'));
				var pos = $this.offset();
				dummyTip.css('left',pos.left+$this.innerWidth()/2-dummyTip.width()/2);
				dummyTip.css('top',pos.top);
				
				dummyTip.addClass('active');
				dummyTip.stop().css('opacity',0).animate({
					'opacity': 0.9,
					'margin-top': -25
				},200,'swing',function(){
					//console.info(tip,this);
				});
			});
			$this.off('mouseleave');
			$this.on('mouseleave',function(){
				dummyTip.removeClass(_class);
				dummyTip.removeClass('active');
				dummyTip.css('margin-top',-15);
			});
        });
	}
	
	
    $(document).ready(function(e) {
        
		dummyTip = $('<div id="mxyt-tooltip" class="mxyt-tooltip"><span></span><div></div></div>');
		$('body').append(dummyTip);
		
		reBindScripts();
				
		
    });
	
})(jQuery);







