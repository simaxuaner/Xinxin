function startSlider(){
	var totalSlides = 3;
	var slideIndex = 0;
	setInterval(function(){slideIndex = slide(slideIndex);},5000);

	function slide(i){
		if(i >= 3){
			i = 0;
		}
		sliderImg.setAttribute("src", "images/slider/"+i+".jpg");
		console.log(i);
		i++;
		return i;
	};
}

function highlightCurrentPage(){
}
function highlightCurrentSubpage(){
	
}