// Permet de récupérer les simplemde de l'accueil
// var simplemdeAccueilArticle = [];
// Permetrat de récupérer les simplemde de compétences
var simplemdeComp = [];
// Permetrat de récupérer les simplemde du CV
var simplemdeCv = [];
// Permetrat de récupérer les simplemde des projets
var simplemdeProjet = [];


// Gestion de l'ouverture de fichiers
async function ouvrirFichier() {
	var input = document.createElement('input');
	input.type = 'file';
	input.accept = 'application/pdf';
	input.onchange = function() {
		var file = input.files[0];
		// Affiche les infos et l'URL
		//console.log(file + " " + file.name + " ");
		var fileReader = new FileReader();
		fileReader.onload = function() {
			var pdfUrl = fileReader.result;
			showPdf(pdfUrl);
		};
		fileReader.readAsDataURL(file);

		// Envoie le fichier au serveur
		fetch('./php/ajax/cvImport.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/pdf'
			},
			body: new Blob([file], { type: 'application/pdf' })
		})
		.then(response => response.text())
		.then(data => {
			console.log(data);
		})
	};
	input.click();
}

function showPdf(pdfUrl) {
	var pdfEmbed = document.getElementById('pdfEmbed');
	pdfEmbed.src = pdfUrl;
	pdfEmbed.type = 'application/pdf';

	var dragNdropDiv = document.getElementById("dragNdropDiv");
	dragNdropDiv.style.display = "none";

	var btnFichier = document.getElementById("btnFichier");
	btnFichier.style.display = "none";
	var btnRetirerCv = document.getElementById("btnRetirerCv");
	btnRetirerCv.style.display = "block";
}

// Affichage de la partie création du cv
function creerCV() {
	document.getElementById("creationCv").style.display = "block";
	document.getElementById("cv").style.display = "none";
}

// Retirer le pdf de l'embed
function supprimerCV() {
	var pdfEmbed = document.getElementById('pdfEmbed');
	pdfEmbed.src = "";

	var dragNdropDiv = document.getElementById("dragNdropDiv");
	dragNdropDiv.style.display = "block";

	var btnFichier = document.getElementById("btnFichier");
	btnFichier.style.display = "block";
	var btnRetirerCv = document.getElementById("btnRetirerCv");
	btnRetirerCv.style.display = "none";

	// Supprime le fichier du serveur
	fetch('./php/ajax/cvSuppr.php', {
		method: 'POST'
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
	})
	.catch(error => console.log(error));
}

// Affichage de la partie importation du cv
function retourCV() {
	document.getElementById("creationCv").style.display = "none";
	document.getElementById("cv").style.display = "block";
}

function collapseLicence(){
	console.log(document.getElementById("selectLicence").value);
	if(document.getElementById("selectLicence").value != "custom"){
		document.getElementById("div-licence").style.display = "none";
	}
	else{
		document.getElementById("div-licence").style.display = "block";
	}
}

function hexToRgb(hex) {
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r: parseInt(result[1], 16),
		g: parseInt(result[2], 16),
		b: parseInt(result[3], 16)
	} : null;
}

function couleurProjet(nb) {
	var couleur = document.getElementById("couleurProjet" + nb).value;
	
	document.getElementById("btnProjet" + nb).style.backgroundColor = couleur;
	// convertir la couleur de #???? en rgb
	var rgb = hexToRgb(couleur);
	// Si le texte est trop sombre par rapport au fond, le mettre en blanc
	if(rgb.r < 100 && rgb.g < 100 && rgb.b < 100){
		document.getElementById("btnProjet" + nb).style.color = "white";
	}
	else{
		document.getElementById("btnProjet" + nb).style.color = "black";
	}
}

function couleurCompetence(nb) {
	var couleur = document.getElementById("couleurComp" + nb).value;
	
	document.getElementById("btnComp" + nb).style.backgroundColor = couleur;

	// convertir la couleur de #???? en rgb
	var rgb = hexToRgb(couleur);
	// Si le texte est trop sombre par rapport au fond, le mettre en blanc
	if(rgb.r < 100 && rgb.g < 100 && rgb.b < 100){
		document.getElementById("btnComp" + nb).style.color = "white";
	}
	else{
		document.getElementById("btnComp" + nb).style.color = "black";
	}
}

// Supprime le dernier projet ajouté, c'est la div-projet
function supprimerProjet() {
	var nbProjet = document.getElementById("accordionProjet").childElementCount;
	console.log(nbProjet);
	if(nbProjet >= 0){
		var divProjet = document.getElementById("accordionProjet");
		console.log(divProjet);
		divProjet.removeChild(divProjet.lastChild);
	}
}



// Gestion de la création des compétences
function creerArticleAccueil() {

	//Creation de card autoincrementé quand on clique sur le bouton ajouterArticleAccueil, id autoincrementé pour la div et le textarea
	var nbAccueil = document.getElementById("divAccueilArticle").childElementCount;

	var divAccueil = document.getElementById("divAccueilArticle");

	var div = document.createElement("div");
	div.setAttribute("class", "card col-sm-3 m-2");
	div.setAttribute("style", "width: 18rem;");
	div.setAttribute("id", "divArticleAccueil" + nbAccueil);

	var img = document.createElement("img");
	img.setAttribute("class", "card-img-top");
	img.setAttribute("src", "./images/minion.png");
	img.setAttribute("alt", "...");

	var divCardBody = document.createElement("div");
	divCardBody.setAttribute("class", "card-body");

	var inputTitre = document.createElement("input");
	inputTitre.setAttribute("type", "card-title");
	inputTitre.setAttribute("class", "form-control");
	inputTitre.setAttribute("id", "titreAccueilArticle" + nbAccueil);
	inputTitre.setAttribute("placeholder", "Titre de l'article");
	inputTitre.setAttribute("required", "");

	

	var textArea = document.createElement("textarea");
	textArea.setAttribute("id", "textAccueilArticle" + nbAccueil);
	textArea.setAttribute("name", "Accueil");
	textArea.setAttribute("required", "");

	var script = document.createElement("script");
	script.textContent = "simplemdeAccueilArticle["+nbAccueil+"] = new SimpleMDE({ element: document.getElementById('textAccueilArticle" + nbAccueil + "') });";

	divCardBody.appendChild(inputTitre);
	divCardBody.appendChild(textArea);
	divCardBody.appendChild(script);

	div.appendChild(img);
	div.appendChild(divCardBody);

	divAccueil.appendChild(div);
}

// Gestion de la création des rubriques de projet
function creerRubriqueProjet() {
	var nbProjet = document.getElementById("accordionProjet").childElementCount;

	var accordionProjet = document.getElementById("accordionProjet");

	var div = document.createElement("div");
	div.setAttribute("class", "accordion-item");
	div.setAttribute("id", "divProjet");

	var h2 = document.createElement("h2");
	h2.setAttribute("class", "accordion-header");
	h2.setAttribute("id", "heading"+nbProjet);

	var button = document.createElement("button");
	button.setAttribute("id", "btnProjet"+nbProjet);
	button.setAttribute("class", "accordion-button collapsed fs-5");
	button.setAttribute("type", "button");
	button.setAttribute("data-bs-toggle", "collapse");
	button.setAttribute("data-bs-target", "#collapse"+nbProjet);
	button.setAttribute("aria-expanded", "false");
	button.setAttribute("aria-controls", "collapse"+nbProjet);
	button.innerHTML = "Projet n°"+(nbProjet + 1)+" : " + "<input class=\"mx-2\" type=\"text\" id=\"titreProjet"+nbProjet+"\" required><input class=\"mx-2\" type=\"color\" id=\"couleurProjet" + nbProjet + "\">";

	var div2 = document.createElement("div");
	div2.setAttribute("id", "collapse"+nbProjet);
	div2.setAttribute("class", "accordion-collapse collapse");
	div2.setAttribute("aria-labelledby", "heading"+nbProjet);
	div2.setAttribute("data-bs-parent", "#accordionProjet");

	var div3 = document.createElement("div");
	div3.setAttribute("class", "accordion-body");

	var textArea = document.createElement("textarea");
	textArea.setAttribute("id", "projet"+nbProjet+"");
	textArea.setAttribute("name", "projet"+nbProjet+"");
	textArea.setAttribute("required", "");
	
	var script = document.createElement("script");
	script.innerHTML = "simplemdeProjet["+nbProjet+"] = new SimpleMDE({ element: document.getElementById(\"projet"+nbProjet+"\") });";
	
	div3.appendChild(textArea);
	div3.appendChild(script);
	div2.appendChild(div3);
	h2.appendChild(button);
	div.appendChild(h2);
	div.appendChild(div2);
	accordionProjet.appendChild(div);

	// Ajout listener sur l'input couleur qui appelle la fonction couleurProjet
	document.getElementById("couleurProjet" + nbProjet).addEventListener("change", function() {
		couleurProjet(nbProjet);
	});
}

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
	const sectionList = ["accueil", "cv", "competences", "projet", "licence", "contact", "creationCv"];
	sectionList.forEach((el) => {
		if (el === element.replace("Link", "")) {
			document.getElementById(el).style.display = "block";
		}
		else {
			document.getElementById(el).style.display = "none";
		}
	});
}

// Bouton enregistrer
function envoieDonner() {
	const monLien = document.getElementById("enregistrer");

	event.preventDefault();

	// Récupération des données

	// Accueil
	var texteAccueil = simplemdeAccueil.value();

	// Accueil article
/* 	var nbAccueilArticle = document.getElementById("divAccueilArticle").childElementCount;
	var titreAccueilArticle = [];
	var textAccueilArticle = [];
	for (var i = 0; i < nbAccueilArticle; i++) {
		titreAccueilArticle[i] = document.getElementById("titreAccueilArticle"+i).value;
		textAccueilArticle[i] = simplemdeAccueilArticle[i].value();
	} */

	// CV
	var cv = [];
	for (var i = 1; i <= 6; i++) {
		cv[i] = simplemdeCv[i].value();
	}

	// Compétences
	var titreCompetence = [];
	var textCompetence = [];
	var couleurCompetence = [];
	for (var i = 1; i <= 6; i++) {
		titreCompetence[i] = document.getElementById("titreCompetence"+i).value;
		textCompetence[i] = simplemdeComp[i].value();
		couleurCompetence[i] = document.getElementById("couleurComp"+i).value;
	}

	// Projets
	var nbProjet = document.getElementById("accordionProjet").childElementCount;
	var titreProjet = [];
	var textProjet = [];
	var couleurProjet = [];
	for (var i = 0; i < nbProjet; i++) {
		titreProjet[i] = document.getElementById("titreProjet"+i).value;
		textProjet[i] = simplemdeProjet[i].value();
		couleurProjet[i] = document.getElementById("couleurProjet"+i).value;
	}

	// Licences
	var select = document.getElementById("selectLicence").value;
	if (select == "custom") {
		var licence = "custom";
		var licenceText = document.getElementById("textLicence").value;
	}
	else {
		var licence = select;
		var licenceText = "";
	}

	// Contact
	var contact = []
	var idContact = ["mail", "tel", "github", "instagram", "facebook", "twitter", "linkedin"]
	for (var i = 0; i < idContact.length; i++) {
		contact[i] = document.getElementById(idContact[i]).value;
	}

	/* Résumé des variables récupérées avec leur types (Array, String, Number, etc.)
     * textAccueil : String
     * cv : Array
     * titreCompetence : Array
     * textCompetence : Array
     * couleurCompetence : Array
     * titreProjet : Array
     * texteProjet : Array
     * couleurProjet : Array
     * licence : String
     * contact : Array
	 */

	// Concaténation des données en un string pour l'envoyer en POST
	var string = "";

	// Accueil
	string == "ACCUEIL\n"
	string += "&textAccueil=" + textAccueil + "\n";
	string += "==================\n";
	
	/* 
	// Accueil article
	string += "ACCUEIL ARTICLE\n";
	for (var i = 0; i < nbAccueilArticle; i++) {
		string += "&titreAccueilArticle" + i + "=" + titreAccueilArticle[i] + "\n";
		string += "&textAccueilArticle" + i + "=" + textAccueilArticle[i] + "\n\n";
	}
	string += "==================\n"; */

	// CV
	string += "CV\n";
	for (var i = 1; i <= 6; i++) {
		string += "&textCv" + i + "=" + cv[i] + "\n";
	}
	string += "==================\n";

	// Compétences
	string += "COMPETENCES\n";
	for (var i = 1; i <= 6; i++) {
		string += "&titreCompetence" + i + "=" + titreCompetence[i] + "\n";
		string += "&textCompetence" + i + "=" + textCompetence[i] + "\n";
		string += "&couleurComp" + i + "=" + couleurCompetence[i] + "\n\n";
	}
	string += "==================\n";

	// Projets
	string += "PROJETS\n";
	for (var i = 0; i < nbProjet; i++) {
		string += "&titreProjet" + i + "=" + titreProjet[i] + "\n";
		string += "&textProjet" + i + "=" + textProjet[i] + "\n";
		string += "&couleurProjet" + i + "=" + couleurProjet[i] + "\n\n";
	}
	string += "==================\n";

	// Licences
	string += "LICENCES\n";
	string += "&licence=" + licence + "\n";
	string += "==================\n";	

	// Contact
	string += "CONTACT\n";
	for (var i = 0; i < idContact.length; i++) {
		string += "&" + idContact[i] + "=" + contact[i] + "\n";
	}
	
	console.log(string);

	var tableauAccueil = new FormData();
	tableauAccueil.append("texteAccueil", texteAccueil);
	//tableauAccueil.append("titreAccueilArticle", titreAccueilArticle);
	//tableauAccueil.append("textAccueilArticle", textAccueilArticle);
	
	var tableauCv = new FormData();
	tableauCv.append("textCv", cv);
	
	var tableauCompetence = new FormData();
	tableauCompetence.append("titreCompetence", titreCompetence);
	tableauCompetence.append("texteCompetence", textCompetence);
	tableauCompetence.append("couleurCompetence", couleurCompetence);
	
	var tableauProjet = new FormData();
	tableauProjet.append("titreProjet", titreProjet);
	tableauProjet.append("texteProjet", textProjet);
	tableauProjet.append("couleurProjet", couleurProjet);
	
	var tableauLicence = new FormData();
	tableauLicence.append("licence", licence);
	tableauLicence.append("licenceText", licenceText);
	
	var tableauContact = new FormData();
	tableauContact.append("contact", contact);

	// Accueil
	fetch("php/ajax/accueil.php", {
		method: "POST",
		body: tableauAccueil
		
	})
	.then(response => response.text())
	.then(data => { 
		console.log(data);
	})
	.catch(error => console.error(error));

	// CV
	fetch("php/ajax/cvCreer.php", {
		method: "POST",
		body: tableauCv
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
	})
	.catch(error => console.error(error));

	// Compétences
	fetch("php/ajax/competence.php", {
		method: "POST",
		body: tableauCompetence
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
	})
	.catch(error => console.error(error));

	// Projets
	fetch("php/ajax/projet.php", {
		method: "POST",
		body: tableauProjet
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
	})
	.catch(error => console.error(error));

	// Licence
	fetch("php/ajax/licence.php", {
		method: "POST",
		body: tableauLicence
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
	})
	.catch(error => console.error(error));

	// Contact
	fetch("php/ajax/contact.php", {
		method: "POST",
		body: tableauContact
	})
	.then(response => response.text())
	.then(data => {
		console.log(data);
	})
	.catch(error => console.error(error));

	
			

	//window.location.href = monLien.href;
}

// Chargement des events quand la page est chargée
window.onload = function() {
	updateElementClass("accueilLink");
	document.getElementById("accueil").style.display = "block";

	// Pour la licence, ajout d'un listener quand il y a un changement dans le select qui appelle la fonction collapseLicence
	document.getElementById("selectLicence").addEventListener("change", collapseLicence);
	document.getElementById("div-licence").style.display = "none";

	// Pour tout les inputs color de classe inputCouleur, ajout d'un listener quand il y a un changement dans le select qui appelle la fonction couleurCompetence
	document.querySelectorAll(".inputCouleur").forEach(item => {
		item.addEventListener("change", function(){
			// récupérer l'id de l'input et retirer couleurCompetence pour avoir l'id de la div
			var idDiv = item.id.replace("couleurComp", "");
			couleurCompetence(idDiv);
		});
	});

	// Pour le drag and drop de CV
	var dropZone = document.getElementById('dragNdropDiv');
	// Gestion du dragover pour indiquer que l\'on peut drop
	dropZone.addEventListener('dragover', (event) => {
		// Empêche le navigateur de faire son comportement par défaut (ouvrir le fichier)
		event.stopPropagation();
		event.preventDefault(); 
		// Permet de montrer que l\'on peut drop dans la zone
		event.dataTransfer.dropEffect = 'copy';
	});

	// Gestion du drop de l\'image
	dropZone.addEventListener('drop', (event) => {
		// Empêche le navigateur de faire son comportement par défaut (ouvrir le fichier)
		event.stopPropagation();
		event.preventDefault();
		let fichier = event.dataTransfer.files[0]; // Récupération du PDF
		console.log(fichier);
		// On vérifie que le fichier est bien un PDF
		if (fichier.type == "application/pdf") {
			var reader = new FileReader();
			reader.onload = function(event) {
				// On récupère le fichier
				var url = event.target.result;
				// On envoie le fichier au serveur
				showPdf(url);
			}
			reader.readAsDataURL(fichier);
		}

		// Envoie le fichier au serveur
		fetch('./php/ajax/cvImport.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/pdf'
			},
			body: new Blob([fichier], { type: 'application/pdf' })
		})
		.then(response => response.text())
		.then(data => {
			console.log(data);
		})
	});

	// Ajout d'un listener sur le bouton enregistrer qui appelle envoieDonner()
	document.getElementById("enregistrer").addEventListener("click", envoieDonner);

	// Ajout d'un listener sur le bouton ajouterArticleAccueil qui appelle la fonction creerArticleAccueil()
	//document.getElementById("ajouterArticleAccueil").addEventListener("click", creerArticleAccueil);

	// Btn btnRetirerCv invisible
	document.getElementById("btnRetirerCv").style.display = "none";
}