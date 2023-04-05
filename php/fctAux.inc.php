<?php

session_start();

function validerSession() {

	if(isset($_SESSION['utilisateur'])) {
		Header("Location: ../Compte.php");
	} else {
		Header ("Location: ../Connexion.html");
	}
}

function validerModif() {
	if(!isset($_SESSION['utilisateur'])) {
		Header("Location: ../Connexion.html");
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


?>