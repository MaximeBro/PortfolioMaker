<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	function cvExist($id, $idport) {
	
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$cvs = $db->getCVs();
				
				foreach($cvs as $cv) {
					$idcv = $cv->getId();
					$idp = $cv->getIdP();
					if($idport == $idp && $idcv == $id) {
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
			$textCv = explode(",", $_POST['textCv']);

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
				$image = $_SESSION['image'];
				$chemin = '../../client/'.$ida.'/cv.pdf';


				$texte = "";
				for($i = 1; $i <= 6; $i++) {
					$texte = $texte .";sepRubrique;". $textCv[$i];
				}

				$existe = cvExist(1, $idp);

				if($existe != 0)
					$db->insertCV(1, $idp, $ida, $chemin, $image, $texte);
				else
					$db->updateCV(1, $idp, $ida, $chemin, $image, $texte);

				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }
	
?>