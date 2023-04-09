// Gestion des intéractions avec la navbar
function clickEvent(element) {
	if(element == "accueilLink") {
		updateElementClass("accueilLink");
	}
	else if(element == "cvLink") {
		updateElementClass("cvLink");
	}
	else if(element == "competencesLink") {
		updateElementClass("competencesLink");
	}
	else if(element == "projetLink") {
		updateElementClass("projetLink");
	}
	else if(element == "licenceLink") {
		updateElementClass("licenceLink");
	}
	else if(element == "contactLink") {
		updateElementClass("contactLink");
	}
}

// Gestion de l'affichage des sections
function updateElementClass(element) {
// Gestion de la navbar
const elementList = ["accueilLink", "cvLink", "competencesLink", "projetLink", "licenceLink", "contactLink"];
elementList.forEach((el) => {
	const elClass = (el === element) ? "c-clicked" : "c-default";
	document.getElementById(el).setAttribute("class", elClass);
});

// Gestion des sections
const sectionList = ["accueil", "cv", "competences", "projet", "licence", "contact"];
sectionList.forEach((el) => {
	if (el === element.replace("Link", "")) {
		document.getElementById(el).style.display = "block";
	}
	else {
		document.getElementById(el).style.display = "none";
	}
});
}

// Chargement des events quand la page est chargée
window.onload = function() {
	updateElementClass("accueilLink");
	document.getElementById("accueil").style.display = "block";
}