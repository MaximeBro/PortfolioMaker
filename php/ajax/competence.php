<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	function competenceExist($id, $idport) {

		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$competences = $db->getCompetences();
				
				foreach($competences as $competence) {
					$ida = $competence->getId();
					$idp = $competence->getIdP();
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
			$titres = explode(",", $_POST['titreCompetence']);
			$textes = explode(",", $_POST['texteCompetence']);
			$couleurs = explode(",", $_POST['couleurCompetence']);

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

				for ($i = 1; $i <= 6; $i++) {
					$titre = is_null($titres[$i]) ? "" : $titres[$i];
					$texte = is_null($textes[$i]) ? "" : $textes[$i];
					$couleur = is_null($couleurs[$i]) ? "" : $couleurs[$i];

					$ind = $i + 1;
					$existe = competenceExist($ind, $idp);

					if($existe != 0)
						$db->insertCompetence($ind, $idp, $ida, $titre, $texte, $couleur);
					else
						$db->updateCompetence($ind, $idp, $ida, $titre, $texte, $couleur);
				}

				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }

	
?>