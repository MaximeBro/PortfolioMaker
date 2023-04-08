<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'php/DB.inc.php';
	include("php/fctAux.inc.php");

	validerVisu();
	$idp = $_SESSION['visu-idP'];

	$db = DB::getInstance();
	if ($db == null) {
		echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {

			$ida = $db->getAuteurOf($idp);
			$auteur = $db->getAuteur($ida);
			$nom = $auteur[0]->getNom();
			$prenom = $auteur[0]->getPrenom();
			$image = $db->getImageById($ida);

		} catch (Exception $e) { echo $e->getMessage(); }
	}

	function getTexteAccueil($idport) {
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$texteAccueil = $db->getTexteAccueil($idport);

				$texteAccueil = strtr($texteAccueil, array(
							"\r\n" => '\n',
							"\r" => '\n',
							"\n" => '\n',
							"\t" => '	',
							"'" => "\'"));

				return $texteAccueil;
			} catch (Exception $e) { echo $e->getMessage(); }
		}
	}

	function getCV () {
		
	}

	function creerCompetence($numero) {
		
		$html = '
			<div class="accordion-item">
				<h3 class="accordion-header" id="hComp'.$numero.'">
					<button id="btnComp'.$numero.'" class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComp'.$numero.'" 
							aria-expanded="false" aria-controls="collapseComp'.$numero.'">
						Compétence n°'.$numero.' :
					</button>
				</h3>
				<div id="collapseComp'.$numero.'" class="accordion-collapse collapse" data-bs-parent="#accordionCompetences">
					<div class="accordion-body">
						<textarea id="textCompetence'.$numero.'" name="textCompetence'.$numero.'"></textarea>
						<script>
							var simplemdeComp'.$numero.' = new SimpleMDE({ element: document.getElementById("textCompetence'.$numero.'"), spellChecker: false, toolbar: false, status: false });
							simplemdeComp'.$numero.'.togglePreview(true);
							simplemdeComp'.$numero.'.codemirror.options.readOnly = true;
						</script>
					</div>
				</div>
			</div>
		';
		return $html;
	}

	function getLicenceTitre($idport) {
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {

				$licenceTitre = $db->getLicenceTitre($idport);

				return $licenceTitre;
			} catch (Exception $e) { echo $e->getMessage(); }
		}
	}

	function getLicenceTexte($idport) {
	
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$licenceTexte = $db->getLicenceTexte($idport);

				
			/* 	<script>
				var simplemdeLicence = new SimpleMDE({ element: document.getElementById("textLicence"), spellChecker: false, toolbar: false, status: false });
				simplemdeLicence.value("'.getLicenceTexte($idp).'");
				simplemdeLicence.togglePreview(true);
				simplemdeLicence.codemirror.options.readOnly = true;
			</script> */

				return $licenceTexte;
			} catch (Exception $e) { echo $e->getMessage(); }
		}
	}

print('
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" 
		rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
	<link rel="stylesheet" href="css/basics.css">
	<link rel="stylesheet" href="css/position.css">
	<link rel="stylesheet" href="css/compte.css">
	
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>

	<script src="js/visualisation.js"></script>

	<title>Visualisation du portfolio</title>
</head>
<body>

<body>
	
<!-- Contenu principal, regroupe toute la page -->
<div class="container-fluid px-0">
	<!-- Barre de navigation -->
	<nav class="navbar navbar-expand-lg bg-dark">
		<div class="navbar-collapse offcanvas-collapse py-2 justify-content-center">
			<ul class="nav mb-2 mb-lg-0 align-items-center">

				<!-- Retour -->
				<a class="static left top c-back" href="Consultation.php">←</a>

				<!-- Accueil-->
				<li class="nav-item mx-5 fs-5">
					<a id="accueilLink" href="#" onclick="clickEvent(\'accueilLink\')">Accueil</a>
				</li>

				<!-- CV -->
				<li class="nav-item mx-5 fs-5">
					<a id="cvLink" href="#" onclick="clickEvent(\'cvLink\')">CV</a>
				</li>

				<!-- Compétences -->
				<li class="nav-item mx-5 fs-5">
					<a id="competencesLink" href="#" onclick="clickEvent(\'competencesLink\')">Compétences</a>
				</li>

				<!-- Projet -->
				<li class="nav-item mx-5 fs-5">
					<a id="projetLink" href="#" onclick="clickEvent(\'projetLink\')">Projets</a>
				</li>

				<!-- Licence -->
				<li class="nav-item mx-5 fs-5">
					<a id="licenceLink" href="#" onclick="clickEvent(\'licenceLink\')">Licence</a>
				</li>

				<!-- Contact -->
				<li class="nav-item mx-5 fs-5">
					<a id="contactLink" href="#" onclick="clickEvent(\'contactLink\')">Contact</a>
				</li>

				<!-- Bouton visualisation -->
				<li class="nav-item mx-5 fs-5">
					<a href="Compte.php" id="enregistrer">
						<button class="btn btn-primary">Enregistrer</button>
					</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<!-- CV -->
		<section id="cv" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<h3 class="c-section-h4">CV</h3>
				
			</div>
		</section>

		<!-- Création CV -->
		<section id="creationCv" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<div class="accordion" id="accordionCreaCv">
				</div>
				<div class="c-section-btn-box centerH my-4">
					<div></div>
					<button class="btn btn-lg btn-secondary" onclick="retourCV()" id="btnCv">Retour</button>
					<div></div>
				</div>
			</div>
		</section>		

		<!-- Compétences -->
		<section id="competences" class="position-relative my-5 p-5 border rounded-5">
		<div class="accordion" id="accordionCompetences">
			'.
			creerCompetence(1).''.
			creerCompetence(2).''.
			creerCompetence(3).''.
			creerCompetence(4).''.
			creerCompetence(5).''.
			creerCompetence(6).''.
			'
		</div>
		</section>

		<!-- Projet -->
		<section id="projet" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<div class="accordion" id="accordionProjet">
				</div>
			</div>
		</section>

		<!-- Licence -->
		<section id="licence" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<h3> '.getLicenceTitre($idp).' </h3>
				
				<div id="div-licence">
					<textarea id="textLicence" name="textLicence"></textarea>
					<script>
						var simplemdeLicence = new SimpleMDE({ element: document.getElementById("textLicence"), spellChecker: false, toolbar: false, status: false });
						simplemdeLicence.value("'.getLicenceTexte($idp).'");
						simplemdeLicence.togglePreview(true);
						simplemdeLicence.codemirror.options.readOnly = true;
					</script>
				</div>
			</div>
		</section>

		<!-- Contact -->
		<section id="contact" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<div class="c-div c-div-login centerH flexC w-50">
					<label class="text-muted">
						Adresse mail
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
						<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
						</svg>
					</label>

					<label class="text-muted">
						Numéro de téléphone 
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
						<path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
						<path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
						</svg>
					</label>

					<label class="text-muted">
						Linkedin
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
						<path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
						</svg>
					</label>
					
					<label class="text-muted">
						GitHub 
						<span class="icone"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
						<path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
						</svg></span>
					</label>

					<label class="text-muted">
						Twitter 
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
						<path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
						</svg>
					</label>

					<label class="text-muted">
						Facebook 
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
						<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
						</svg>
					</label>

					<label class="text-muted">
						Instagram 
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
						<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
						</svg>
					</label>
				</div>
			</div>
		</section>

		<!-- Accueil -->
		<section id="accueil" class="position-relative my-5 p-5 border rounded-5">
			<div>
				<h3>'.$prenom.' '.$nom.'</h3>
				<div class="flexR">
					<div class="flex3">
						<textarea id="textAccueil" name="Accueil" required></textarea>
						<script>
							var simplemdeAccueil = new SimpleMDE({ element: document.getElementById("textAccueil"), spellChecker: false, toolbar: false, status: false });
							let texte = \''.getTexteAccueil($idp).'\';
							simplemdeAccueil.value(texte);
							simplemdeAccueil.togglePreview(true);
							simplemdeAccueil.codemirror.options.readOnly = true;
						</script>
					</div>
					<div class="flex1">
						<div class="c-section-content-accueil px-2 centerHV">
							<img class="c-pdp" src="'.$image.'">
						</div>
					</div>
				</div>
			</div>
		</section>
	</div> <!-- Container closure -->
</div> <!-- Container fluid closure -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

');

?>