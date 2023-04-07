<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);


function validerSession() {

	if(isset($_SESSION['email'])) {
		Header("Location: ../Compte.php");
	} else {
		Header ("Location: ../Connexion.html");
	}
}

function validerModif() {
	if(!isset($_SESSION['email'])) {
		Header("Location: ./Connexion.html");
	} 
}

function getIdByEmail($email) {

	$db = DB::getInstance();
	if ($db == null) {
		echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {

			$id = $db->getId($email);
			if($id == null || $id <= 0)
				echo("Adresse email inexistante");

			return $id;
		} catch (Exception $e) { echo $e->getMessage(); }
	}

}


function getImageByEmail($email) {

	$db = DB::getInstance();
	if ($db == null) {
		echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {
			$image = $db->getImage($email);
			if($image == null || $image == "")
				echo("Adresse email inexistante");

			return $image;
		} catch (Exception $e) { echo $e->getMessage(); }
	}
}


function portfolioExist($id) {

	$db = DB::getInstance();
	if ($db == null) {
		echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {
			$portfolios = $db->getPortfolios();
			
			foreach($portfolios as $portfolio) {
				$idP = $portfolio->getIdP();
				if($idP == $id) {
					return 0;
				}
			}

			return 1;
		} catch (Exception $e) { echo $e->getMessage(); }
	}
}


function getLastPortfolio() {

	$db = DB::getInstance();
	if ($db == null) {
		echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {
			$nb = $db->getMaxPortfolio();

			return $nb;
		} catch (Exception $e) { echo $e->getMessage(); }
	}
}


?>