<?php
	require '../DB.inc.php';
	include("../fctAux.inc.php");

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	if(isset($_SESSION['utilisateur'])) {
		$utilisateur = unserialize($_SESSION['utilisateur']);

		// Récupération du fichier envoyé par le drag and drop
		$image = $_FILES['image']; 
		$email = $utilisateur->getEmail();
		$id = getIdByEmail($email); 

		// Chemin de destination où vous souhaitez enregistrer l'image
		$destination = '../../client/'.$id.'/images/pdp.png';
		$destRapportAComptePHP = './client/'.$id.'/images/pdp.png';

		// Vérification si le fichier est bien une image
		if (getimagesize($image['tmp_name'])) {
			// Enregistrement de l'image dans le dossier de destination
			move_uploaded_file($image['tmp_name'], $destination);
			// L'image à bien été enregistrée
			echo "1:".$destRapportAComptePHP;
		} else {
			// Le fichier n'est pas une image
			echo "2";
		}

	}
	else { exit(); }
?>