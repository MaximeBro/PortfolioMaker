<?php
	require '../DB.inc.php';
	include("../fctAux.inc.php");

	ini_set('display_errors', 1);
	error_reporting(E_ALL);


	if(isset($_SESSION['utilisateur'])) {
		$utilisateur = unserialize($_SESSION['utilisateur']);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Récupération de la chaine envoyé dans Compte.php
			$data = file_get_contents('php://input');
			//var_dump($data);

			// Changement dans la session
			$utilisateur->setImage($data);
			$_SESSION['utilisateur'] = serialize($utilisateur);

			// Changement dans la base de données
			$email = $utilisateur->getEmail();
			$id = getIdByEmail($email);
			
			/*$db = DB::getInstance();
			if ($db == null) {
				echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
			} else {
				try {

					$db->updateImage($id, $data);

				} catch (Exception $e) { echo $e->getMessage(); }
			}*/
			
			// Refresh de la page (via JS) pour que l'image soit mise à jour
			echo "0";
		}
	}
	else { exit(); }
?>