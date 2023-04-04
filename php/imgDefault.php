<?php

require 'DB.inc.php';
include("fctAux.inc.php");

$db = DB::getInstance();
if ($db == null) {
	erreur ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
} else {
	try {
		$utilisateur = $_SESSION['utilisateur'];

		$db->insertAuteur($count, $nom, $prenom, $email, $password, "./images/user.png");
		$_SESSION['email'] = $email;
		$_SESSION['image'] = "./images/user.png";
		$_SESSION['utilisateur'] = serialize(new Auteur($count, $nom, $prenom, $email, $password, "./images/user.png"));

		Header("Location: ../Compte.php");

		$db->close();
	} catch (Exception $e) { echo $e->getMessage(); }
}

?>