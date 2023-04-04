<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("php/DB.inc.php");
include("php/fctAux.inc.php");

$nom = !is_null($_POST['nomInput']) ? $_POST['nomInput'] : null;
$prenom = !is_null($_POST['prenomInput']) ? $_POST['prenomInput'] : null;
$email = !is_null($_POST['emailInput']) ? $_POST['emailInput'] : null;
$mdpOld = !is_null($_POST['passwordOld']) ? $_POST['passwordOld'] : null;
$mdp = !is_null($_POST['passwordInput']) ? $_POST['passwordInput'] : null;
$mdpC = !is_null($_POST['passwordConfirm']) ? $_POST['passwordConfirm'] : null;

if(isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	verification($emailSession, $nom, $prenom, $email, $mdp, $mdpC);
}


function verification($emailSession, $nom, $prenom, $email, $mdp, $mdpC) {

	$db = DB::getInstance();
	if ($db == null) {
		erreur ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {
			$mdpOld = $db->getAuteur(getIdByEmail($emailSession));
			if($mdpOld == $mdp) { Header("Location: Compte.php"); exit(); }
			if($mdp != $mdpC) { Header("Location: Compte.php"); exit(); }

			if($email != null && $email != "") {
				$clients = $db->getAuteurs();
				foreach($clients as $client) {
					if($client != null && $client->getEmail() == $email) {
						Header("Location: Compte.php"); exit();
					}
				}
			}


			// Après validation de toutes les étapes de vérification

			$nom 	= $nom == null ? $utilisateur->getNom() : $nom;
			$prenom = $prenom == null ? $utilisateur->getPrenom() : $prenom;
			$email = $email == null ? $utilisateur->getEmail() : $email;
			$mdp = $mdp == null ? $mdpOld : $mdp;
			$image = $utilisateur->getImage() == null ? "./images/user.png" : $utilisateur->getImage();

			$id = getIdByEmail($email);

			echo (	'id : '.$id.' | nom : '.$nom.' | prénom : '.$prenom.' | email : '.$email.
					' | mdp : '.$mdp.' | image : '.$image);

			$_SESSION['utilisateur'] = serialize(new Auteur($id, $nom, $prenom, $email, $mdp, $image));
			$_SESSION['nom'] = $nom;
			$_SESSION['prenom'] = $prenom;
			$_SESSION['email'] = $email;


			echo (is_null($db) ? "DB null" : "DB ouverte"."\n\n");

			$db->updateAuteur($id, $nom, $prenom, $email, $mdp, $image);
			$db->close();

			Header("Location: Compte.php");

		} catch (Exception $e) { echo $e->getMessage(); }
	}

}



?>