<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	function contactExist($id, $idport) {
	
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$contacts = $db->getContacts();
				
				foreach($contacts as $contact) {
					$ida = $contact->getId();
					$idp = $contact->getIdP();
					if($idp == $idport && $ida == $id) {
						return 0;
					}
				}

				return 1;
			} catch (Exception $e) { echo $e->getMessage(); }
		}
	}


	if(isset($_SESSION['email'])) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// Récupération des données venant de creation.js par la méthode POST
			$contacts = $_POST['contact'];
			$contacts = explode(",", $contacts);
			$emailc = is_null($contacts[0]) ? "" : $contacts[0];
			$numtel = is_null($contacts[1]) ? "" : $contacts[1];
			$github = is_null($contacts[2]) ? "" : $contacts[2];
			$instagram = is_null($contacts[3]) ? "" : $contacts[3];
			$facebook = is_null($contacts[4]) ? "" : $contacts[4];
			$twitter = is_null($contacts[5]) ? "" : $contacts[5];
			$linkedin = is_null($contacts[6]) ? "" : $contacts[6];

			$count = 0;
			$db = DB::getInstance();
			while($db == null && $count != 100) {
				$db = DB::getInstance();
				$count++;
			}
			if($count >= 100) { echo("DB unreachable"); }

			try {

				$ida = getIdByEmail($_SESSION['email']);
				$idp = $_SESSION['idP'];

				$existe = contactExist(1, $idp);

				if($existe != 0)
					$db->insertContact(1, $idp, $ida, $emailc, $numtel, $github, $instagram, $facebook, $twitter, $linkedin);
				else
					$db->updateContact(1, $idp, $ida, $emailc, $numtel, $github, $instagram, $facebook, $twitter, $linkedin);


				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }

?>