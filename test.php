<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

require 'php/DB.inc.php';
include ("php/fctAux.inc.php");

	function afficherAll() {
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es ALL !");
		} else {
			try {

				$clients = $db->getAuteurs();
				foreach($clients as $client) {
					echo($client);
				}

			} catch (Exception $e) { echo $e->getMessage(); }
		} 
	}

	function updateClient($id, $nom, $prenom, $email, $mdp, $image) {
		
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es UPDATE !");
		} else {
			try {

				$db->updateAuteur($id, $nom, $prenom, $email, $mdp, $image);

			} catch (Exception $e) { echo $e->getMessage(); }
		}


	}


	function afficherPorts() {
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es ALL !");
		} else {
			try {

				$clients = $db->getPortfolios(2);
				foreach($clients as $client) {
					echo($client);
				}

			} catch (Exception $e) { echo $e->getMessage(); }
		} 
	}

	function updatePort($id, $ida, $titre, $chemina, $chemins) {
		
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es UPDATE !");
		} else {
			try {

				$db->updatePortfolio($id, $ida, $titre, $chemina, $chemins);

			} catch (Exception $e) { echo $e->getMessage(); }
		}


	}
	

?>

<html>
<head>
	<link rel="stylesheet" href="css/basics.css">
	<link rel="stylesheet" href="css/position.css">
</head>
<body>


	<div class="c-div">
		<?php updatePort(1, 2, 'MEGA TITRE', '', ''); ?>
	</div>
	<div class="c-div"><?php afficherPorts() ?></div>

</body>
</html>


