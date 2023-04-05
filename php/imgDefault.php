<?php

require 'DB.inc.php';
include("fctAux.inc.php");

$db = DB::getInstance();
if ($db == null) {
	erreur ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
} else {
	try {
		$email = $_SESSION['email'];
		$id = getIdByEmail($email);

		$db->updateImage($id, "./images/user.png");
		$_SESSION['image'] = "./images/user.png";
		

		Header("Location: ../Compte.php");

		$db->close();
	} catch (Exception $e) { echo $e->getMessage(); }
}

?>