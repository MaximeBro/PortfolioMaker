<?php

function connexionE($msg) {

	print('

	<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" 
			rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
		<link rel="stylesheet" href="../css/basics.css">
		<link rel="stylesheet" href="../css/position.css">

		<title>Connexion</title>
	</head>
	<body class="text-center">

		<div class="h-100 d-flex align-items-center justify-content-center">

			<div class="c-div c-div-login">
				<form class="form-signin" method="post" action="Connexion.php">
					<h2 class="mb-4">Connexion</h2>
					<input type="email" class="form-control mb-3" id="floatingInput" placeholder="Email" name="emailInput">
					<input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe" name="passwordInput">

					<p id="erreur" class="erreur">'.$msg.'</p>

					<button class="btn btn-lg btn-primary mt-3" type="submit">Se connecter</button>

					<p class="text-muted mt-3">
						Vous n\'êtes pas inscrit ? <br>
						<a class="link-primary" href="../Inscription.html">Inscrivez-vous</a> 
					</p>
					
				</form>
			</div>

			<a href="Consultation.php">
					<button class="c-btn c-btn-bluep fixed top right mt-3 mx-5">Invité</button>
			</a>

		</div>

	</body>
	</html>

	');
}

?>