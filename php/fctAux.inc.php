<?php
session_start();

function validerSession() {

	if(isset($_SESSION['utilisateur'])) {
		header("Location: ../Compte.html");
	} else {
		header ("Location: ../Connexion.html");
	}
}


?>