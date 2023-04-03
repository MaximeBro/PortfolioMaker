<?php

require("DB.inc.php");
include("fctAux.inc.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$nom = $_POST['nomInput'];
$prenom = $_POST['prenomInput'];
$email = $_POST['emailInput'];
$password = $_POST['passwordInput'];
$passwordC = $_POST['passwordConfirm'];

verification($nom, $prenom, $email, $password, $passwordC);


function verification($nom, $prenom, $email, $password, $passwordC) {

	// Vérification de la bonne correspondance des mots de passe renseignés
	if($password != $passwordC) { erreur("Les mots de passe ne correspondent pas !"); }

	// Vérification de l'adresse email dans la base, si elle est déjà renseignée on envoie une erreur !

	$db = DB::getInstance();
	if ($db == null) {
		erreur ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
	} else {
		try {

			$clients = $db->getAuteurs();
			foreach($clients as $client) {
				if($client != null && $client->getEmail() == $email) {
					erreur("Adresse email déjà existante !");
				}
			}


			// Après validation de toutes les étapes de vérification

			$count = (int) $db->getMaxAuteurs(); // Enregistrement du dernier id libre (max id enregistré + 1)
			$count = $count + 1;

			$db->insertAuteur($count, $nom, $prenom, $email, $password, "../images/user.png");
			$_SESSION['utilisateur'] = serialize(new Auteur($count, $nom, $prenom, $email, $password, "../images/user.png"));

			Header("Location: ../Compte.php");


			$db->close();
		} catch (Exception $e) { echo $e->getMessage(); }
	}
}

function erreur($msg) {
	echo '<p style="color: red;">'.$msg.'</p>';
	exit();
}

?>