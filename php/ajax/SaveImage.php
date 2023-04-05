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

		// Création du dossier de destination s'il n'existe pas déjà
		if (!file_exists('../../client/'.$id)) {
			// Utilise un script shell car sinon la fonction mkdir() 
			// cree le dossier avec les droits du serveur web et non de l'utilisateur 
			$output = shell_exec("./creaDossier.sh $id");
			echo $output;
		}

		// Pour les droits
		//mkdir('../client/'.$id.'/images', 0777, true);
		//chown('../client/'.$id.'/images', 'bv200989');
		//supprimer les fichiers dans le dossier
		//rmdir('../client/4/images');
		//rmdir('../client/4');

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