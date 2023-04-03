
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

	<title>Création du portfolio</title>
</head>
<body>
	
<div class="c-container">

	<!-- Contenu principal, regroupe toute la page -->

	<div class="c-main">
		
		<!-- Barre de navigation -->
		<nav class="navbar navbar-expand-lg c-4em c-bg-navbar">
			<div class="navbar-collapse offcanvas-collapse c-3em">
				<ul class="nav c-navbar mb-2 mb-lg-0 align-items-center">

					<!-- Accueil-->
					<li class="nav-item">
						<a class="nav-link" id="accueilLink" href="#" onclick="clickEvent('accueilLink')">Accueil</a>
					</li>

					<!-- CV -->
					<li class="nav-item">
						<a class="nav-link" id="cvLink" href="#" onclick="clickEvent('cvLink')">CV</a>
					</li>

					<!-- Compétences -->
					<li class="nav-item">
						<a class="nav-link" id="competencesLink" href="#" onclick="clickEvent('competencesLink')">Compétences</a>
					</li>

					<!-- Projet -->
					<li class="nav-item">
						<a class="nav-link" id="projetLink" href="#" onclick="clickEvent('projetLink')">Projet</a>
					</li>

					<!-- License -->
					<li class="nav-item">
						<a class="nav-link" id="licenseLink" href="#" onclick="clickEvent('licenseLink')">License</a>
					</li>

					<!-- Contact -->
					<li class="nav-item">
						<a class="nav-link" id="contactLink" href="#" onclick="clickEvent('contactLink')">Contact</a>
					</li>

					<!-- Bouton visualisation -->
					<li class="nav-item">
						<a class="nav-link" href="">
							<button class="btn btn-primary">Visualisation</button>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		

		<!-- Accueil -->
		<section class="c-section" id="accueil">
			<div style="width: 100%; height: 100%;">
				<h3>Accueils</h3>
			</div>
		</section>

		<!-- CV -->
		<section class="c-section" id="cv">
			<div style="width: 100%; height: 100%; ">
				<h3 class="c-section-h4">CV</h3>
				<div class="c-div-dragNdrop c-large-dragNdrop centerH" onclick="ouvrirFichier()" id="dragNdropDiv">
					<p class="text-muted centerH italic">glisser - déposer</p>
				</div>

				<div class="c-section-btn-box centerH my-4">
					<div></div>
					<button class="btn btn-lg btn-secondary" onclick="creerCV()" id="btnCreation">Création</button>
					<div></div>
					<button class="btn btn-lg btn-secondary" onclick="ouvrirFichier()" id="btnFichier">Importer</button>
					<div></div>
				</div>
			</div>
		</section>

		<section class="c-section none" id="creationCv" >
				<ul class="list-group">
					<li class="list-group-item">
						<h3 class="c-competence-title">Titre et Bio</h3>
						<div class="c-content">
						<input type="text" id="name" name="name" required size="100">
						</div>
					</li>
					<li class="list-group-item">
						<h3 class="c-competence-title">Compétence</h3>
						<div class="c-content">
							Contenu de la rubrique 2
						</div>
					</li>
					<li class="list-group-item">
						<h3 class="c-competence-title">Projets</h3>
						<div class="c-content">
							Contenu de la rubrique 1
						</div>
					</li>
					<li class="list-group-item">
						<h3 class="c-competence-title">Expériences</h3>
						<div class="c-content">
							Contenu de la rubrique 2
						</div>
					</li>
					<li class="list-group-item">
						<h3 class="c-competence-title">Diplomes</h3>
						<div class="c-content">
							Contenu de la rubrique 1
						</div>
					</li>
					<li class="list-group-item">
						<h3 class="c-competence-title">Loisir</h3>
						<div class="c-content">
							Contenu de la rubrique 2
						</div>
					</li>
				</ul>
		</section>
			
			

		<!-- Compétences -->
		<section class="c-section" id="competences">
			<div style="width: 100%; height: 100%;">
				<ul class="list-group">
					<li class="list-group-item">
						<h3 class="c-competence-title">Titre de la rubrique 1</h3>
						<div class="c-content">
							Contenu de la rubrique 1
						</div>
					</li>
					<li class="list-group-item">
						<h3 class="c-competence-title">Titre de la rubrique 2</h3>
						<div class="c-content">
							Contenu de la rubrique 2
						</div>
					</li>
				</ul>
			</div>
		</section>

		<!-- Projet -->
		<section class="c-section" id="projet">
			<div style="width: 100%; height: 100%;">
				<h3>Projet</h3>
			</div>
		</section>

		<!-- License -->
		<section class="c-section" id="license">
			<div style="width: 100%; height: 100%;">
				<h3>License</h3>
			</div>
		</section>

		<!-- Contact -->
		<section class="c-section" id="contact">
			<div style="width: 100%; height: 100%;">
				<h3>Contact</h3>
			</div>
		</section>
	</div> <!-- Main closure -->

</div> <!-- Container closure -->



<script>

	// Gestion de l'ouverture de fichiers

	async function ouvrirFichier() {
		var dragNdropDiv = document.getElementById("dragNdropDiv");
		let files = await selectFile("Pictures/*");
		dragNdropDiv.innerHTML = files.map(file => `<img src="${URL.createObjectURL(file)}" style="width: 100px; height: auto;">`).join('');
	}

	function selectFile (contentType) {
		return new Promise(resolve => {
		let input = document.createElement('input');
			input.type = 'file';
			input.multiple = false;
			input.accept = contentType;

			input.onchange = _ => { let files = resolve(files[0]); };

			input.click();
		});
	}

	function creerCV(){
		let div = document.getElementById("creationCv");
		let 
		if(div.style.display == "block"){
			div.style.display = "none";
		}
		else{
			div.style.display = "block";
		}
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
		
		const sectionList = ["accueil", "cv", "competences", "projet", "license", "contact"];
		sectionList.forEach((el) => {
			const elClass = (el === element.replace("Link", "")) ? "c-expand" : "c-none";
			document.getElementById(el).setAttribute("class", elClass);
		});
	}

	// Gestion de l'affichage des compétences
	const titles = document.querySelectorAll('.c-competence-title');

	titles.forEach((title) => {
		title.addEventListener('click', (event) => {
	 		const content = event.target.nextElementSibling;
			content.classList.toggle('c-content-active');
			titles.forEach((otherTitle) => {
				if (otherTitle !== title) {
					otherTitle.nextElementSibling.classList.remove('c-content-active');
				}
			})
		});
	});

	// Chargement des events quand la page est chargée
	window.onload = function() {
		updateElementClass("accueilLink");
	}

</script>

</body>
</html>