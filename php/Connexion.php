<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require("DB.inc.php");
include("fctAux.inc.php");
include("../ConnexionErreur.php");

$email = $_POST['emailInput'];
$mdp = $_POST['passwordInput'];

verification($email, $mdp);

function verification($email, $mdp) {

	$db = DB::getInstance();
	if ($db == null) {
		erreur ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {

			$clients = $db->getAuteurs();
			foreach($clients as $client) {
				echo $client;
				if($client != null && $client->getEmail() == $email) {
					if($client->getPassword() == md5($mdp)) {
						$_SESSION['utilisateur'] = serialize($client);

						$_SESSION['image'] = $client->getImage();
						$_SESSION['nom'] = $client->getNom();
						$_SESSION['prenom'] = $client->getPrenom();
						$_SESSION['email'] = $email;

						Header("Location: ../Compte.php");
						exit();
					}
					else {
						erreur("Mot de passe incorrect");
					}
				}
			}

			erreur("Adresse email inexistante");

			$db->close();
		} catch (Exception $e) { echo $e->getMessage(); }
	}

}


function erreur($msg) {
	connexionE($msg);
	exit();
}

?>