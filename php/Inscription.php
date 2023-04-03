<?php

require 'Auteur.inc.php';
include ("fctAux.inc.php");

$nom = $_POST['nomInput'];
$prenom = $_POST['prenomInput'];
$email = $_POST['emailInput'];
$password = $_POST['passwordInput'];
$passwordC = $_POST['passwordConfirm'];


function verification($nom, $prenom, $email, $password, $passwordC) {

	// Vérification de la bonne correspondance des mots de passe renseignés
	if($password != $passwordC) { erreur("Les mots de passe ne correspondent pas !"); exit(); }


	// Vérification de l'adresse email dans la base, si elle est déjà renseignée on envoie une erreur !
	$count = 0;
	$db = DB::getInstance();
	if ($db == null) {
		echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
	} else {
		try {

			$clients = $db->getAuteurs();
			foreach($clients as $client) {
				if($client->getEmail() == $email) {
					erreur("Adresse email déjà existante !"); exit();
				}
			}

			$count = $db->getMaxAuteurs() + 1; // Enregistrement du dernier id libre (max id enregistré + 1)

		} catch (Exception $e) { echo $e->getMessage(); }
		$db->close();
	}


	// Après validation de toutes les étapes de vérification

	$author = new Auteur($count, $nom, $prenom, $email, $password, $passwordC);
	$_SESSION['utilisateur'] = serialize($author);

	header("Location: ../Compte.html");
	exit();
}

function erreur($erreur) {
	$_REQUEST['erreur'] = $erreur;
}

?>