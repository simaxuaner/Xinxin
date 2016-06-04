(function ($) {
	Drupal.news = Drupal.news || {};
	/**
	 * Attach toggling behavior and notify the overlay of the toolbar.
 	*/
	Drupal.behaviors.about = {
        attach: function(context) {
            $('.jobItem').click(function(){
            var index = $('.jobItem').index($(this));
            $('.hideModal:eq('+index+')').slideToggle('slow',function(){
                var rotateValue = 180;
                if ($(this).is(':hidden')) {
                    rotateValue = 0;
                }
                $('.jobItem:eq('+index+')').find('img').css('transition','transform .5s');
                $('.jobItem:eq('+index+')').find('img').css('transform','rotate('+rotateValue+'deg)');  
            });
            });
        }
	};
})(jQuery);	