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

(function($){
	Drupal.behaviors.mainSlider = {
		attach: function(context) {
			$("body").ready(function(e) {
				startSliders()
			})
			$("div.controls div.arrowNav div.arrowLeft").click(function(e){
				slide(this.parentNode.parentNode.parentNode, parseInt(this.parentNode.parentNode.parentNode.dataset.i)-1)
			})
			$("div.controls div.arrowNav div.arrowRight").click(function(e){
				slide(this.parentNode.parentNode.parentNode, parseInt(this.parentNode.parentNode.parentNode.dataset.i)+1)
			})
			$("div.controls div.bulletNav div.bullet").click(function(e){
				slide(this.parentNode.parentNode.parentNode, this.dataset.i)
			})
		}
	}
	
	function slide(slider, i){
		clearTimeout(slideDelay);
		if (i === undefined) { 
			i = parseInt(slider.dataset.i) + 1;
		}
		if(i >= getSlides(slider).length){
			i = 0;
		}
		else if(i < 0){
			i = getSlides(slider).length - 1;
		}
		setSlide(slider, i);
		setBullet(slider, i);
		resetSlides(slider, i);
		resetBullets(slider, i);
		slideDelay = setTimeout(function(){slide(slider);},3000);
	}
	function setSlide(slider, i){
		slider.dataset.i = i;
		getSlides(slider)[i].style.removeProperty('display');
		
	}
	function resetSlides(slider, i){
		for(var j=0; j < getSlides(slider).length; j++){
			if(j != i){
				getSlides(slider)[j].style.display = "none";
			}
		}
	}
	function getSlides(slider){
		var children = slider.children;
		var slides = [];
		for(var i=0; i < children.length; i++){
			if(children[i].className == "slide"){
				slides.push(children[i]);
			}
		}
		return slides;
	}
	function getSliders(){
		var sliders = document.getElementsByClassName("slider");
		return sliders;
	}
	function getBullets(slider){
		var allBullets = document.getElementsByName("bullet");
		var bullets = [];
		for(i=0; i < allBullets.length; i++){
			if(allBullets[i].parentNode.parentNode.parentNode == slider){
				bullets.push(allBullets[i]);
			}
		}
		return bullets;
	}
	function setBullet(slider, i){
		var bullets = getBullets(slider);
		bullets[i].style.backgroundColor = "#68b7fd";
	}
	function resetBullets(slider, i){
		var bullets = getBullets(slider);
		for(j=0; j < bullets.length; j++){
			if(j != i){
				bullets[j].style.removeProperty("background-Color")
			}
		}
	}
	function startSliders(){
		var sliders = getSliders();
		for(i=0; i < sliders.length; i++){
			var slider = sliders[i];
			slideDelay = setTimeout(function(){slide(slider);},3000);
		}		
	}	
})(jQuery);
