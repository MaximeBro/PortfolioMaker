<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	if(isset($_SESSION['email'])) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// Récupération de la chaîne envoyée dans Compte.php
			$idp = json_decode(file_get_contents("php://input"), true);
			$idp = $idp['param'];
			$idp = str_replace("onglet-input-", "", $idp);

			$count = 0;
			$db = DB::getInstance();
			while($db == null && $count != 100) {
				$db = DB::getInstance();
				$count++;
			}
			if($count >= 100) { echo("DB unreachable"); }

			try {
				$ida = getIdByEmail($_SESSION['email']);
				$existe = portfolioExist($id);

				if($existe == 0) {
					$db->deletePortfolio($idp, $ida);
				}

			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }



?>
