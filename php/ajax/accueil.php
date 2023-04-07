<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	function accueilExist($id, $idport) {

		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$accueils = $db->getAccueils();

				foreach($accueils as $accueil) {
					$ida = $accueil->getId();
					$idp = $accueil->getIdP();
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
			$texteAccueil = $_POST['texteAccueil'];

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

				$texteAccueil = is_null($texteAccueil) ? "" : $texteAccueil;

				$existe = accueilExist(1, $idp);

				if($existe != 0)
					$db->insertAccueil(1, $idp, $ida, $texteAccueil);
				else
					$db->updateAccueil(1, $idp, $ida, $texteAccueil);


				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }

	
?>