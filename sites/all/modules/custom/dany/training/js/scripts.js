function startSlider() {
	var totalSlides = 3;
	var slideIndex = 0;
	setInterval(function() {
		slideIndex = slide(slideIndex);
	}, 5000);

	function slide(i) {
		if (i >= 3) {
			i = 0;
		}
		sliderImg.setAttribute("src", "images/slider/" + i + ".jpg");
		console.log(i);
		i++;
		return i;
	};
}

function getSideNavItem(i) {
	sideNavItem = document.getElementById("sideNavItem" + i);
	return sideNavItem;
}

function getSubPage(i) {
	var subPage = document.getElementById("subPage" + i);
	return subPage;
}

function showSubPage(i) {
	getSubPage(i).className = "";
	highlightCurrentSubPage(i);
}

function hideSubPage(i) {
	getSubPage(i).className = "hidden";
}
function countNavItems(nav){
	var i = 0;
	var itemCount = 0;
	while(nav.getElementsByTagName('li') [i++]) itemCount++;
	return itemCount;
}
function loadSubPage(i) {
	showSubPage(i);
	highlightCurrentPage(i);
	for (j = 0; j < countNavItems(sideNav); j++) {
		if (j != i) {
			getSubPage(j).className = "hidden";
		} else {}
	}
}

function highlightCurrentSubPage(i) {
	getSideNavItem(i).className = "currentSubPage";
	console.log("hightlighting subpage #" + i);
	resetHighlights(i);
}

function resetHighlights(i) {
	for (j = 0; j < countNavItems(sideNav); j++) {
		if (j != i) {
			getSideNavItem(j).className = "";
		} else {}
	}
}

function highlightCurrentPage(i) {
	getSideNavItem(i).className = "currentSubPage";
}

function expandParent(div){
	console.log(div.style.maxHeight);
	if(div.style.maxHeight == "256px" || div.style.maxHeight == ""){
		div.style.maxHeight = "initial";
	}
	else{
		div.style.maxHeight = "256px";
	}
}
function testJs(){
    alert("Hello");
}