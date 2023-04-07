<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" 
		rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
	<link rel="stylesheet" href="css/basics.css">
	<link rel="stylesheet" href="css/position.css">
	<link rel="stylesheet" href="css/compte.css">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

	<title>Visualisation du portfolio</title>
</head>
<body>
<div class="container-fluid px-0">

	<!-- Barre de navigation -->
	<nav class="navbar navbar-expand-lg bg-dark">
		<div class="navbar-collapse offcanvas-collapse py-2 justify-content-center">
			<ul class="nav mb-2 mb-lg-0 align-items-center">

				<!-- Accueil-->
				<li class="nav-item mx-5 fs-5">
					<a class="" id="accueilLink" href="#" onclick="clickEvent('accueilLink')">Accueil</a>
				</li>

				<!-- CV -->
				<li class="nav-item mx-5 fs-5">
					<a class="" id="cvLink" href="#" onclick="clickEvent('cvLink')">CV</a>
				</li>

				<!-- Compétences -->
				<li class="nav-item mx-5 fs-5">
					<a class="" id="competencesLink" href="#" onclick="clickEvent('competencesLink')">Compétences</a>
				</li>

				<!-- Projet -->
				<li class="nav-item mx-5 fs-5">
					<a class="" id="projetLink" href="#" onclick="clickEvent('projetLink')">Projet</a>
				</li>

				<!-- License -->
				<li class="nav-item mx-5 fs-5">
					<a class="" id="licenseLink" href="#" onclick="clickEvent('licenseLink')">License</a>
				</li>

				<!-- Contact -->
				<li class="nav-item mx-5 fs-5">
					<a class="" id="contactLink" href="#" onclick="clickEvent('contactLink')">Contact</a>
				</li>

				<!-- Bouton visualisation -->
				<li class="nav-item mx-5 fs-5">
					<a class="" href="Compte.php">
						<button class="btn btn-primary">Compte</button>
					</a>
				</li>
			</ul>
		</div>
	</nav>

	<section id="accueil" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<h3>Accueil</h3>
				<div class="">

				</div>
			</div>
			<!--
			<div id="divAccueilArticle" class="row">
			</div>
			<button id="ajouterArticleAccueil" class="btn btn-primary">Ajouter article</button>
			-->
	</section>
</div>
<script>
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
		else if(element == "licenseLink") {
			updateElementClass("licenseLink");
		}
		else if(element == "contactLink") {
			updateElementClass("contactLink");
		}
	}

	// Gestion de l'affichage des sections
	function updateElementClass(element) {
		const elementList = ["accueilLink", "cvLink", "competencesLink", "projetLink", "licenseLink", "contactLink"];
		elementList.forEach((el) => {
			const elClass = (el === element) ? "c-clicked" : "c-default";
			document.getElementById(el).setAttribute("class", elClass);
		});
		
		/*
		const sectionList = ["accueil", "cv", "competences", "projet", "license", "contact", "creationCv"];
		sectionList.forEach((el) => {
			const elClass = (el === element.replace("Link", "")) ? "c-expand" : "c-none";
			document.getElementById(el).setAttribute("class", elClass);
		});*/
	}

	// Chargement des events quand la page est chargée
	window.onload = function() {
		updateElementClass("accueilLink");
	}
</script>
</body>
</html>