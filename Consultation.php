<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'php/DB.inc.php';
	include("php/fctAux.inc.php");


function printPortfolios() {
	
	$count = 0;
	$db = DB::getInstance();
	while($db == null && $count != 100) {
		$db = DB::getInstance();
		$count++;
	}
	if($count >= 100) { echo("DB unreachable"); }
	try {
		$portfolios = $db->getPortfolios();
		$ret = '';

		foreach($portfolios as $portfolio) {
			if($portfolio != null) {
				$idp = $portfolio->getIdP();
				$ida = $db->getAuteurOf($idp);
				$auteur = $db->getAuteur($ida);
				$nom = $auteur[0]->getNom();
				$prenom = $auteur[0]->getPrenom();
				$ret = $ret . '
				<div class="c-portfolio-div mb-3" id="portfolio-'.$idp.'">
					<div class="block nomargin">
						<button class="mx-2 block centerHV" onclick="visualiserPortfolio(\'portfolio-'.$idp.'\')" type="submit">
							<img src="./images/icons/eye.png">
						</button>
					</div>
					<h3 class="c-event-h3 mx-3" id="onglet-h3-'.$idp.'">'.$prenom.' '.$nom.' - '.$portfolio->getTitre().'</h3>
				</div>';
			}
		}

		return $ret;

	} catch (Exception $e) { echo $e->getMessage(); }
}

print('

<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" 
		rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
	<link rel="stylesheet" href="css/basics.css">
	<link rel="stylesheet" href="css/position.css">

	<title>Consultation</title>

	<script>
		function visualiserPortfolio(id) {
			console.log(id);

			let data = new FormData();
			data.append("visu-idP", id);
			fetch(\'php/redirectVisualisation.php\', {
				method: \'POST\',
					body: data
			})
			.then(response => response.text())
			.then(data => { 
				console.log(data);
				if(data == \'1\') { // L\'id est set dans $_SESSION
							window.location.href = "Visualisation.php";
				}
			})
			.catch(error => console.error(error));
		}
	</script>
</head>
<body>

<div class="c-container">

	<div class="c-aside">
		<h2 class="c-aside-title">Consultation</h2>
		<div class="c-sep"></div>

		<div class="c-aside-content">
			<div class="c-2em"></div>
			<p class="text-muted">
				Ici vous trouverez les portfolios publiques.
			</p>
		</div>
		

		<div class="c-aside-bottom">
			<div class="c-aside-content">
				<p class="text-muted">Vous êtes auteur ?</p>
				<a href="php/Accueil.php">
					<button class="c-btn c-btn-blue">Connectez-vous</button>
				</a>
			</div>
		</div>
	</div>

	<div class="c-main">
		<section class="c-section">
			<div style="width: 100%; height: 100%;">
				<h3>Portfolios</h3>
				<div class="c-section-content c-scrollable">
					'.printPortfolios().'
				</div>
			</div>
		</section>
	</div>
	
</div>

</body>
</html>

');

?>