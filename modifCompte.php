<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'php/DB.inc.php';
include("php/fctAux.inc.php");

$nom = !is_null($_POST['nomInput']) ? $_POST['nomInput'] : null;
$prenom = !is_null($_POST['prenomInput']) ? $_POST['prenomInput'] : null;
$email = !is_null($_POST['emailInput']) ? $_POST['emailInput'] : null;
$mdpOld = !is_null($_POST['passwordOld']) ? $_POST['passwordOld'] : null;
$mdp = !is_null($_POST['passwordInput']) ? $_POST['passwordInput'] : null;
$mdpC = !is_null($_POST['passwordConfirm']) ? $_POST['passwordConfirm'] : null;

if(isset($_SESSION['email'])) {
	$emailSession = $_SESSION['email'];
	verification($emailSession, $nom, $prenom, $email, $mdpOld, $mdp, $mdpC);
}


function verification($emailSession, $nom, $prenom, $email, $mdpOld, $mdp, $mdpC) {

	$count = 0;
	$db = DB::getInstance();
	while($db == null && $count !== 100) {
		$db = DB::getInstance();
		$count++;
	}

	if($count >= 100) { echo("BD unrecheable"); exit(); }

	
	try {
		$id = getIdByEmail($emailSession);
		$mdpBD = $db->getAuteur($id)[0]->getPassword();

		if(md5($mdpOld) != $mdpBD) { $db->close(); Header("Location: Compte.php");  exit(); } // Si celui entré différent de celui de la base
		if($mdpOld == $mdp) { $db->close(); Header("Location: Compte.php"); exit(); } // Si saisie de l'ancien mdp comme nouveau
		if($mdp != $mdpC) { $db->close(); Header("Location: Compte.php"); exit(); }   // Si nouveau est différent de la confirmation
		

		if($email != null && $email != "") {
			$clients = $db->getAuteurs();
			foreach($clients as $client) {
				if($client != null && $client->getEmail() == $email) {
					$db->close();
					Header("Location: Compte.php");
					echo("Adresse email déjà existante !");
					exit();
				}
			}
		}

		$nom 	= $nom == null ? $_SESSION['nom'] : $nom;
		$prenom = $prenom == null ? $_SESSION['prenom'] : $prenom;
		$email = $email == null ? $emailSession : $email;
		$mdp = $mdp == null ? $mdpOld : $mdp;
		$image = $_SESSION['image'] == null ? "./images/user.png" : $_SESSION['image'];

		echo (	'id : '.$id.' | nom : '.$nom.' | prénom : '.$prenom.' | email : '.$email.
				' | mdp : '.$mdp.' | image : '.$image);

		$_SESSION['utilisateur'] = serialize(new Auteur($id, $nom, $prenom, $email, $mdp, $image));
		$_SESSION['nom'] = $nom;
		$_SESSION['prenom'] = $prenom;
		$_SESSION['email'] = $email;


		// Après validation de toutes les étapes de vérification
		$db->updateAuteur($id, $nom, $prenom, $email, md5($mdp), $image);
		$db->close();

		Header("Location: Compte.php");

	} catch (Exception $e) { echo $e->getMessage(); }

}



?>