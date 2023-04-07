<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'DB.inc.php';
	include("fctAux.inc.php");

	// Header("Location: Inscription.php");
	// print "He haciendo una redirection para la page de creation de tu portfolio mi amor ~~~<3";
	// if(!isset($_POST['idP'])) {
	// 	Header("Location: ../Compte.php");
	// 	exit();
	// }

	$idp = (int) str_replace("portfolio-", "", $_POST['idP']);
	$_SESSION['idP'] = $idp;
	echo isset($_SESSION['idP']);

?>