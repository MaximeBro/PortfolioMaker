<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require '../DB.inc.php';
	include("../fctAux.inc.php");

	function projetExist($id, $idport) {
		
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es !");
		} else {
			try {
				$projets = $db->getProjets();
				
				foreach($projets as $projet) {
					$ida = $projet->getId();
					$idp = $projet->getIdP();
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
			$titres = explode(";sepProj;", $_POST['titreProjet']);
			$textes = explode(";sepProj;", $_POST['texteProjet']);
			$couleurs = explode(";sepProj;", $_POST['couleurProjet']);

			echo "récupération projet ";

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

				$db->deleteAllProjets($idp, $ida);

				$nb = count($couleurs);
				for ($i = 0; $i < $nb; $i++) {
					$ind = $i + 1;

					$titre = is_null($titres[$i]) ? "" : $titres[$i];
					$texte = is_null($textes[$i]) ? "" : $textes[$i];
					$couleur = is_null($couleurs[$i]) ? "" : $couleurs[$i];

					if($titre !== "" && $texte !== "" && $couleur !== "") {

						$existe = projetExist($ind, $idp);

						if($existe != 0) {
							$db->insertProjet($ind, $idp, $ida, $titre, $texte, $couleur);
						}
						else {
							$db->updateProjet($ind, $idp, $ida, $titre, $texte, $couleur);
						}
					}
				}

				echo 0;
			} catch(Exception $e) { $e->getMessage(); }

		}
	}
	else { exit(); }
	

	
?>