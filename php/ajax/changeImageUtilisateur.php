<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");



	// Vérification de la session (si l'utilisateur est connecté)
	if(isset($_SESSION['email'])) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Récupération de la chaine envoyé dans Compte.php
			$data = file_get_contents('php://input');
			//var_dump($data);

			// Changement dans la session
			$_SESSION['image'] = $data;

			// Changement dans la base de données
			$email = $_SESSION['email'];
			$id = getIdByEmail($email);
			
			// On attend que la base de données soit disponible
			// sinon
			$count = 0;
			$db = DB::getInstance();
			while($db == null && $count !== 100) {
				$db = DB::getInstance();
				$count++;
			}

			if($count >= 100) { echo("BD unrecheable"); exit(); }
			//echo ("Impossible de se connecter à la base de données !");
			try {

				$db->updateImage($id, $data);

			} catch (Exception $e) { echo $e->getMessage(); }

			
			// Refresh de la page (via JS) pour que l'image soit mise à jour
			echo "0";
		}
	}
	else { exit(); }
?>