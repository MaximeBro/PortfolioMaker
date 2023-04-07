<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	// Récupération des données venant de creation.js par la méthode POST, c'est un json
	if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
		// Récupération des données brutes du corps de la requête
		$input = file_get_contents('php://input');

		// Vérification que le contenu est bien un PDF
		if (substr($input, 0, 4) == '%PDF') {
			//Récupération du nom du fichier
			$utilisateur = unserialize($_SESSION['utilisateur']);
			$email = $utilisateur->getEmail();
			$id = getIdByEmail($email);
			$nomFichier = '../../client/'.$id.'/cv.pdf';

			// Enregistrement du fichier dans le dossier de destination
			file_put_contents($nomFichier, $input);

			// Le fichier a bien été enregistré
			echo "Fichier enregistré avec succès.";
		} else {
			// Le contenu n'est pas un PDF
			echo "Le contenu envoyé n'est pas un PDF.";
		}
	}
?>