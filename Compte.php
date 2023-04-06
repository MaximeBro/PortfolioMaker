<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'php/DB.inc.php';
include("php/fctAux.inc.php");

afficherPage();

function printPortfolios($email) {
	
	$count = 0;
	$db = DB::getInstance();
	while($db == null && $count != 100) {
		$db = DB::getInstance();
		$count++;
	}
	if($count >= 100) { echo("DB unreachable"); }
	try {
		$ida = getIdByEmail($email);
		$portfolios = $db->getPortfolios($ida);
		$ret = '';

		foreach($portfolios as $portfolio) {
			if($portfolio != null) {
				$idp = $portfolio->getIdP();
				$ret = $ret . '
				<div class="c-portfolio-div mb-3" id="portfolio-'.$idp.'">
					<button class="btn btn-lg btn-danger mx-2" onclick="supprimerPortfolio(\'portfolio-'.$idp.'\')">Supprimer</button>
					<h3 class="c-event-h3" id="onglet-h3-'.$idp.'">'.$portfolio->getTitre().'</h3>
					<button class="mx-2" onclick="modifierPortfolio(\'portfolio-'.$idp.'\')">
						<img src="./images/icons/edit.png">
					</button>
				</div>

				<script>
					let portfolio'.$idp.' = document.getElementById("portfolio-'.$idp.'");
					let h3'.$idp.' = document.getElementById("onglet-h3-'.$idp.'");
					let input'.$idp.' = document.createElement("input");
					input'.$idp.'.setAttribute("id", "onglet-input-'.$idp.'");

					input'.$idp.'.addEventListener("blur", (event) => {
						h3'.$idp.'.setAttribute("class", "c-event-h3");
						h3'.$idp.'.setAttribute("id", "onglet-h3-'.$idp.'");
						h3'.$idp.'.innerHTML = input'.$idp.'.value;
						portfolio'.$idp.'.replaceChild(h3'.$idp.', input'.$idp.');

						let data'.$idp.' = new FormData();
						data'.$idp.'.append(\'param1\', input'.$idp.'.value);
						data'.$idp.'.append(\'param2\', input'.$idp.'.id);
						fetch(\'php/ajax/creationPortfolio.php\', {
							method: \'POST\',
							body: data'.$idp.'
						})
						.then(response => response.text())
						.then(data => console.log(data))
						.catch(error => console.error(error));
					});

					h3'.$idp.'.addEventListener("click", (event) => {
						input'.$idp.'.setAttribute("class", "form-control");
						portfolio'.$idp.'.replaceChild(input'.$idp.', h3'.$idp.');
						input'.$idp.'.innerHTML = h3'.$idp.'.value;
						input'.$idp.'.focus();
					});
				</script>';
			}
		}

		return $ret;

	} catch (Exception $e) { echo $e->getMessage(); }
}


function getPortfolioCount($email) {

	$db = DB::getInstance();
	if ($db == null) {
		echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {
			$id = getIdByEmail($email);
			$nb = $db->getPorfolioCountWithId($id);

			return $nb;
		} catch (Exception $e) { echo $e->getMessage(); }
	}

}


function afficherPage() {

	if(strpos($_SESSION['utilisateur'], "@")) {

		$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : "";
		$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : "";
		$email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
		$image = isset($_SESSION['image']) ? $_SESSION['image'] : "";

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

			<script>
				// Bouton suppression portfolio
				function supprimerPortfolio(id) {
					let element = document.getElementById(id);
					console.log(element);
					console.log(id);
					document.getElementById("lstPortfolios").removeChild(element);
				}
			</script>

		</head>
		<body>
		
			<div class="c-container">


			<!-- Partie infos et déconnexion, regroupe tous les éléments de la partie aside -->

			<div class="c-aside">
				<div class="c-aside-image">
					<div> <img src="'.$image.'"> </div>
				</div>
				<div class="c-demi-sep"></div>
				<h2 class="c-aside-title" id="nomProfil">'.$prenom.' '.$nom.'</h2>

				<div class="c-4em"></div>

				<div class="c-aside-content">
					<h4 class="c-aside-h4">Email</h4>
					<p class="text-muted">'.$email.'</p>

					<div class="c-3em"></div>
					<h4 class="c-aside-h4">Portfolios</h4>
					<p class="text-muted">'.getPortfolioCount($email).' Portfolio(s)</p>
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
				
				<nav class="navbar navbar-expand-lg c-4em bg-dark">
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
						<button class="btn btn-lg btn-danger absolute right top" onclick="creerPortfolio(\''.(getLastPortfolio()+1).'\', \' \')">Créer</button>
						<div class="c-section-content flexC">
							<div class="c-section-multiple-reverse c-scrollable" id="lstPortfolios">
								'.printPortfolios($email).'
							</div>
						</div>
					</div>
				</section>


				<section class="c-section" id="compte">
					<div style="width: 100%; height: 100%;">
						<h3>Compte</h3>
						<div class="c-section-content">

							<div class="c-section-multiple flexR">
								<div class="c-div-section c-section-form">
									<form class="form-signin" method="post" action="./modifCompte.php">
										<div class="mb-2 c-ibox-form">
											<input type="text" class="form-control mb-1 c-ibox-elem c-input" name="nomInput" id="nomInput" placeholder="Nom">
											<div></div>
											<input type="text" class="form-control c-ibox-elem c-input" name="prenomInput" id="prenomInput" placeholder="Prénom">
										</div>

										<input type="email" class="form-control mb-2" id="emailInput" placeholder="Email" name="emailInput">
										<input type="password" class="form-control mb-2" id="passwordOld" placeholder="Mot de passe actuel" name="passwordOld" required>
										<input type="password" class="form-control mb-1" id="passwordInput" placeholder="Nouveau mot de passe" name="passwordInput">
										<input type="password" class="form-control mb-1" id="passwordConfirm" placeholder="Confirmer nouveau mot de passe" name="passwordConfirm">

										<button class="btn btn-lg btn-primary mt-4 centered" type="submit">Enregistrer</button>
									</form>
								</div>

								<div class="c-div-section flexC">
									<h4 class="c-section-h4">Image de profil</h4>
									<div class="c-1em"></div>
									<div class="c-div-dragNdrop" onclick="ouvrirFichier()" id="dragNdropDiv">
										<div class="annotation"><p class="nomargin">image carrée préférable</p></div>
										<div class=" c-3em"></div>
										<div>
											<p class="text-muted centered italic nomargin">glisser - déposer</p>
										</div>
										<div class="c-3em"></div>
									</div>

									<button class="btn btn-lg btn-secondary centered mt-3" onclick="ouvrirFichier()" id="btnFichier">Ouvrir</button>
									<form class="centered mt-3" method="POST" action="php/imgDefault.php">
										<button class="btn btn-lg btn-secondary" type="submit" id="imgDefault">Par défaut</button>
									</form>
								</div>
							</div>

						</div>
					</div>
				</section>
			</div> <!-- Main closure -->

		</div> <!-- Container closure -->



		<script>

			/* ------------------ */
			/* ONGLETS PORTFOLIO  */
			/* ------------------ */

			// Bouton création de portfolios
			function creerPortfolio(id, texte) {
				let portfolio = document.createElement(\'div\');
				let input = document.createElement(\'input\');
				let h3 = document.createElement("h3");
				let btnDel = document.createElement(\'button\');
 				let btnEdit = document.createElement(\'button\');
				let icon = document.createElement(\'img\');

				portfolio.setAttribute("class", "c-portfolio-div mb-3");
				portfolio.setAttribute("id", "portfolio-" + id);

				input.setAttribute("class", "form-control");
				input.setAttribute("id", "onglet-input-" + id);

				btnDel.setAttribute("class", "btn btn-lg btn-danger mx-2");
				btnDel.setAttribute("onclick", "supprimerPortfolio(portfolio.id)");
				btnDel.innerHTML = "Supprimer";


				btnEdit.setAttribute("onclick", "modifierPortfolio(portfolio.id)");
				btnEdit.setAttribute("class", "mx-2");

				icon.setAttribute("src", "./images/icons/edit.png");
				btnEdit.appendChild(icon);

				portfolio.appendChild(btnDel);
				portfolio.appendChild(input);
				portfolio.appendChild(btnEdit);

				input.addEventListener("blur", (event) => {
					h3.innerHTML = input.value;
					h3.setAttribute("class", "c-event-h3");
					portfolio.replaceChild(h3, input);

					let data = new FormData();
					data.append(\'param1\', input.value);
					data.append(\'param2\', input.id);
					fetch(\'php/ajax/creationPortfolio.php\', {
						method: \'POST\',
							body: data
					})
					.then(response => response.text())
					.then(data => {
					console.log(data);
					})
					.catch(error => console.error(error));

					// location.reload();
				});

				h3.addEventListener("click", (event) => {
					input.innerHTML = h3.value;
					input.setAttribute("class", "form-control");
					portfolio.replaceChild(input, h3);
					input.focus();
				});

				btnDel.addEventListener("click", (event) => {
					const data = { param: input.id };
					fetch(\'php/ajax/supprimerPortfolio.php\', {
						method: \'POST\',
						headers: { 
							\'Content-Type\': \'application/json\' 
						},
						body: JSON.stringify(data)
					})
					.then(data => {
						console.log(data);
					});

				});

				document.getElementById("lstPortfolios").appendChild(portfolio);
			}



			/* --------- */
			/*  NAV BAR  */
			/* --------- */
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

			

			/* --------------- */
			/*  IMAGE PROFILE  */
			/* --------------- */
			// Gestion de l\'ouverture de fichiers
			async function ouvrirFichier() {
				var dragNdropDiv = document.getElementById("dragNdropDiv");
				let files = await selectFile("Pictures/*");
				console.log(files);
				dragNdropDiv.innerHTML = \'<img src="${URL.createObjectURL(file)}" style="width: 100px; height: auto;">\' ;
			}

			// Sélectionne un fichier et appelle la fonction de traitement
			function selectFile (contentType) {
				return new Promise(resolve => {
				let input = document.createElement(\'input\');
					input.type = \'file\';
					input.multiple = false;
					input.accept = contentType;
		
					input.onchange = _ => { 
						let files = Array.from(input.files);
						changementImage(files[0]);
					};
		
					input.click();
				});
			}

			// Gestion du dragover pour indiquer que l\'on peut drop
			dragNdropDiv.addEventListener(\'dragover\', (event) => {
				// Empêche le navigateur de faire son comportement par défaut (ouvrir le fichier)
				event.stopPropagation();
				event.preventDefault(); 
				// Permet de montrer que l\'on peut drop dans la zone
				event.dataTransfer.dropEffect = \'copy\';
			});

			// Gestion du drop de l\'image
			dragNdropDiv.addEventListener(\'drop\', (event) => {
				// Empêche le navigateur de faire son comportement par défaut (ouvrir le fichier)
				event.stopPropagation();
				event.preventDefault();
				let image = event.dataTransfer.files[0]; // Récupération de l\'image déposée
				changementImage(image); // Envoi de l\'image au script PHP
			});

			function changementImage(image) {
				// Création d\'un objet FormData pour envoyer l\'image
				var formData = new FormData();
				formData.append(\'image\', image);

				// Envoi de l\'image et du $_SESSION au script PHP en utilisant fetch
				fetch(\'./php/ajax/SaveImage.php\', {
					method: \'POST\',
					body: formData
				})
				.then(response => response.text()) // Réponse du script PHP (200 si tout s\'est bien passé)
				.then(data => {
					console.log(data, \'\tfrom SaveImagePHP\'); // Affichage de la réponse du script PHP dans la console
					let dataSave = data;
					switch(dataSave.charAt(0)) {
						// L\'image a été enregistrée
						case \'1\':
							console.log("Image enregistrée");
							// script pour changer l\\\'image dans la base de données et sur la page
							fetch(\'./php/ajax/changeImageUtilisateur.php\', {
								method: \'POST\',
								body: dataSave.substring(2)
							})
							.then(response => response.text())
							.then(data => {
								let data2 = data;
								if(data2 == \'0\') {
									location.reload(true); // On recharge la page pour mettre à jour l\\\'image
								}
							})
							break;
						// L\\\'image n\\\'a pas été enregistrée
						case \'2\':
							alert(\'Ce n\\\'est pas une image.\');
							break;
					}
				})
				.catch(error => {
					console.error(error);
					alert(\'Une erreur est survenue lors de l\\\'enregistrement de l\\\'image.\');
				});
			}


			/* --------------- */
			/*  WINDOW ONLOAD  */
			/* --------------- */
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