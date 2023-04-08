<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");


	function licenceExist($id, $idport) {
		
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$licences = $db->getLicences();

				foreach($licences as $licence) {
					$idl = $licence->getId();
					$idp = $licence->getIdP();
					if($idp == $idport && $idl == $id) {
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
			$licence = $_POST['licence'];
			$licenceText = $_POST['licenceText'];

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

				switch($licence) {
					case "GNU":
						$licenceText = 'https://www.gnu.org/licenses/gpl-3.0.html';
						break;

					case "MIT":
						$licenceText = 'https://mit-license.org/';
						break;
				
					case "CC":
						$licenceText = 'https://creativecommons.org/';
						break;

					case "All Rights Reserved":
						$licenceText = 'All Rights Reserved unless otherwise explicitly stated.';
						break;
				}

				$existe = licenceExist(1, $idp);
				
				if($existe != 0)
					$db->insertLicence(1, $idp, $ida, $licence, $licenceText);
				else
					$db->updateLicence(1, $idp, $ida, $licence, $licenceText);

				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }


?>