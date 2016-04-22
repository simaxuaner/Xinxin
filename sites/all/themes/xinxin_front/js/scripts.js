(function ($) {
	Drupal.news = Drupal.news || {};
	/**
	 * Attach toggling behavior and notify the overlay of the toolbar.
 	*/
	Drupal.behaviors.news = {
	attach: function(context) {
		$('.newsItem', context).click(function(e) {
			if($(this).css('maxHeight') == '256px' || $(this).css('maxHeight') == ""){
				$(this).css('maxHeight', 'initial');
			}
			else{
				$(this).css('maxHeight', '256px');
			}
			return false;
		});
	}
	};
})(jQuery);
