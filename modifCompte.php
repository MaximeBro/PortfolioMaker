<?php

require("DB.inc.php");

$nom = $_POST['nomInput'];
$prenom = $_POST['prenomInput'];
$email = $_POST['emailInput'];
$mdpOld = $_POST['passwordOld'];
$mdp = $_POST['passwordInput'];
$mdpC = $_POST['passwordConfirm'];

$utilisateur = $_SESSION['utilisateur'];

verification($utilisateur, $nom, $prenom, $email, $mdpOld, $mdp, $mdpC);


function verification($utilisateur, $nom, $prenom, $email, $mdpOld, $mdp, $mdpC) {

	if($utilisateur->getPassword() != $mdpOld) {
		erreur("Mot de passe incorrect !");
	}


	$db = DB::getInstance();
	if ($db == null) {
		erreur ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {

			if($mdpOld == $mdp) { erreur("Saisissez un nouveau mot de passe !"); }
			if($mdp != $mdpC) { erreur("Les mots de passe ne correspondent pas !"); }


			if($email != null && $email != "") {
				$clients = $db->getAuteurs();
				foreach($clients as $client) {
					if($client != null && $client->getEmail() == $email) {
						erreur("Adresse email déjà existante !");
					}
				}
			}



			// Après validation de toutes les étapes de vérification

			$count = (int) $db->getMaxAuteurs(); // Enregistrement du dernier id libre (max id enregistré + 1)
			$count = $count + 1;

			$db->insertAuteur($count, $nom, $prenom, $email, $mdp, "../images/user.png");
			$_SESSION['utilisateur'] = serialize(new Auteur($count, $nom, $prenom, $email, $mdp, $utilisateur->getImage()));

			Header("Location: ../Compte.php");


			$db->close();
		} catch (Exception $e) { echo $e->getMessage(); }
	}

}


function erreur($mdp) {
	exit();
}

?>