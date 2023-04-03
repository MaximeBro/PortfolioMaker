<?php

require("php/Auteur.inc.php");
include("php/fctAux.inc.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

afficherPage();

function afficherPage() {

	if(strpos($_SESSION['utilisateur'], "@")) {

		$utilisateur = unserialize($_SESSION['utilisateur']);
		print('
		
		<html lang="fr">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">

			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" 
				rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
			<link rel="stylesheet" href="./css/basics.css">
			<link rel="stylesheet" href="./css/position.css">
			<link rel="stylesheet" href="./css/compte.css">

			<title>Votre compte</title>
		</head>
		<body>
		
			<div class="c-container">


			<!-- Partie infos et déconnexion, regroupe tous les éléments de la partie aside -->

			<div class="c-aside">
				<div class="c-aside-image">
					<div> <img src="./images/minion.png"> </div>
				</div>
				<div class="c-demi-sep"></div>
				<h2 class="c-aside-title" id="nomProfil">'.$utilisateur->getNom().' '.$utilisateur->getPrenom().'</h2>

				<div class="c-4em"></div>

				<div class="c-aside-content">
					<h4 class="c-aside-h4">Email</h4>
					<p class="text-muted">'.$utilisateur->getEmail().'</p>

					<div class="c-3em"></div>
					<h4 class="c-aside-h4">Projets</h4>
					<p class="text-muted">2 Portfolios</p>
				</div>


				<div class="c-aside-bottom">
					<div class="centered">
						<form action="./php/Deconnexion.php">
							<button class="c-btn c-btn-blue">Déconnexion</button>
						</form>
					</div>
				</div>
			</div>

			<!-- Contenu principal, regroupe toute la partie droite de la page -->

			<div class="c-main">
				
				<nav class="navbar navbar-expand-lg c-4em c-bg-navbar">
					<div class="navbar-collapse offcanvas-collapse c-3em">
						<ul class="c-navbar mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link" id="portfoliosLink" href="#" onclick="clickEvent(\'portfoliosLink\')">Portfolios</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="compteLink" href="#" onclick="clickEvent(\'compteLink\')">Compte</a>
							</li>
						</ul>
					</div>
					
				</nav>

				<section class="c-section" id="portfolios">
					<div style="width: 100%; height: 100%;">
						<h3>Portfolios</h3>
						<div class="c-section-content">
						
						</div>
					</div>
				</section>

				<section class="c-section" id="compte">
					<div style="width: 100%; height: 100%;">
						<h3>Compte</h3>
						<div class="c-section-content">

							<div class="c-section-multiple">
								<div class="c-div-section c-section-form">
									<form class="form-signin" method="post">
										<div class="mb-3 c-ibox-form">
											<input type="text" class="form-control mb-1 c-ibox-elem c-input" name="nom" id="nomInput" placeholder="Nom">
											<div></div>
											<input type="text" class="form-control c-ibox-elem c-input" name="prenom" id="nomInput" placeholder="Prénom">
										</div>

										<input type="email" class="form-control mb-2" id="floatingInput" placeholder="Email">
										<input type="password" class="form-control mb-1" id="floatingPassword" placeholder="Mot de passe">
										<input type="password" class="form-control mb-1" id="passwordConfirm" placeholder="Confirmer">

										<button class="btn btn-lg btn-primary mt-4 centered" type="submit">Enregistrer</button>
									</form>
								</div>

								<div class="c-div-section">
									<h4 class="c-section-h4">Image de profil</h4>
									<div class="c-1em"></div>
									<div class="c-div-dragNdrop" onclick="ouvrirFichier()" id="dragNdropDiv">
										<div class="c-3em"></div>
										<p class="text-muted centered italic">glisser - déposer</p>
										<div class="c-3em"></div>
									</div>

									<div class="c-2em"></div>
									<button class="btn btn-lg btn-secondary centered" onclick="ouvrirFichier()" id="btnFichier">Ouvrir</button>
								</div>
							</div>

						</div>
					</div>
				</section>
			</div> <!-- Main closure -->



		</div> <!-- Container closure -->



		<script>

			// Gestion de l\'ouverture de fichiers

			async function ouvrirFichier() {
				var dragNdropDiv = document.getElementById("dragNdropDiv");
				let files = await selectFile("Pictures/*");
				dragNdropDiv.innerHTML = files.map(file => `<img src="${URL.createObjectURL(file)}" style="width: 100px; height: auto;">`).join(\'\');
			}

			function selectFile (contentType) {
				return new Promise(resolve => {
				let input = document.createElement(\'input\');
					input.type = \'file\';
					input.multiple = false;
					input.accept = contentType;

					input.onchange = _ => { let files = resolve(files[0]); };

					input.click();
				});
			}


			// Gestion des intéractions avec la navbar
			function clickEvent(element) {
				if(element == "portfoliosLink") {
					document.getElementById("portfoliosLink").setAttribute("class", "c-clicked");
					document.getElementById("compteLink").setAttribute("class", "c-default");

					document.getElementById("portfolios").setAttribute("class", "c-expand");
					document.getElementById("compte").setAttribute("class", "c-none");
				}

				if(element == "compteLink") {
					document.getElementById("portfoliosLink").setAttribute("class", "c-default");
					document.getElementById("compteLink").setAttribute("class", "c-clicked");

					document.getElementById("portfolios").setAttribute("class", "c-none");
					document.getElementById("compte").setAttribute("class", "c-expand");
				}
			}

			// Chargement des events quand la page est chargée
			window.onload = function() {
				document.getElementById("portfoliosLink").setAttribute("class", "c-clicked");
				document.getElementById("compteLink").setAttribute("class", "c-default");

				document.getElementById("portfolios").setAttribute("class", "c-expand");
				document.getElementById("compte").setAttribute("class", "c-none");
			}

		</script>

		</body>
		</html>
		
		');

	} 
	else
		Header("Location: ./Connexion.html");
}

?>