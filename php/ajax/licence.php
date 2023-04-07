<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	// Récupération des données venant de creation.js par la méthode POST, c'est un json

	$licence = $_POST['licence'];

	/* TRAITEMENT BD A FAIRE*/
	function licenceExist($idport) {
		
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$licence = $db->getLicence();
				if ($licence == null) {
					return 0;
				} else {
					return 1;
				}

				return 1;
			} catch (Exception $e) { echo $e->getMessage(); }
		}
	}

	
?>