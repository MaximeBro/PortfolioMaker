<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

require 'php/DB.inc.php';
include ("php/fctAux.inc.php");

	function afficherAll() {
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es ALL !");
		} else {
			try {

				$clients = $db->getAuteurs();
				foreach($clients as $client) {
					echo($client);
				}

				$db->close();
			} catch (Exception $e) { echo $e->getMessage(); }
		} 
	}

	function updateClient($id, $nom, $prenom, $email, $mdp, $image) {
		
		$db = DB::getInstance();
		if ($db == null) {
			echo ("Impossible de se connecter &agrave; la base de donn&eacute;es UPDATE !");
		} else {
			try {

				$db->updateAuteur($id, $nom, $prenom, $email, $mdp, $image);

				$db->close();
			} catch (Exception $e) { echo $e->getMessage(); }
		}


	}
	

?>

<html>
<head>
	<link rel="stylesheet" href="css/basics.css">
	<link rel="stylesheet" href="css/position.css">
</head>
<body>

	<div class="c-div">
		<?php afficherAll(); ?>
	</div>

</body>
</html>


