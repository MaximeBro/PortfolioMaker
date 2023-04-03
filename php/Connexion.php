<?php

require("DB.inc.php");
include("fctAux.inc.php");
include("../ConnexionErreur.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);


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
				if($client != null && $client->getEmail() == $email) {
					if($client->getPassword() == $mdp) {
						$_SESSION['utilisateur'] = serialize($client);
						Header("Location: ../Compte.php");
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