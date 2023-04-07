<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	if(isset($_SESSION['email'])) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// Récupération des paramètres
			$titre = $_POST['param1'];
			$idp = (int) str_replace("onglet-input-", "", $_POST['param2']);

			$count = 0;
			$db = DB::getInstance();
			while($db == null && $count != 100) {
				$db = DB::getInstance();
				$count++;
			}
			if($count >= 100) { echo("DB unreachable"); }

			try {
				$ida = getIdByEmail($_SESSION['email']);
				$existe = 0;
				$existe = portfolioExist($idp); 

				if($existe == 0) {
					$db->updatePortfolio($idp, $ida, $titre, './client/'.$ida, './general/public/'.$ida);
				}
				else {
					if($idp != 0)
						$db->insertPortfolio($idp, $ida, $titre, './client/'.$ida, './general/public/'.$ida);
				}
				
				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }



?>
