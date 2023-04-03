<?php
session_start();

function validerSession() {

	if(isset($_SESSION['utilisateur'])) {
		header("Location: ../Compte.php");
	} else {
		header ("Location: ../Connexion.html");
	}
}


?>