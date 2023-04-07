<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	if(isset($_SESSION['email'])) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$email = $_SESSION['email'];
			$id = getIdByEmail($email);

			// Suppression du CV dans les dossiers
			$nomFichier = '../../client/'.$id.'/cv.pdf';

			if(file_exists($nomFichier)) {
				unlink($nomFichier);
				echo 0;
			} else {
				echo 1;
			}

		}
	}

?>