<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require 'DB.inc.php';
	include("fctAux.inc.php");

	$idp = (int) str_replace("portfolio-", "", $_POST['visu-idP']);
	$_SESSION['visu-idP'] = $idp;
	echo isset($_SESSION['visu-idP']);

?>