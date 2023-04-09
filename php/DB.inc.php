<?php

require 'Auteur.inc.php';
require 'Portfolio.inc.php';
require 'Accueil.inc.php';
require 'CV.inc.php';
require 'Competence.inc.php';
require 'Projet.inc.php';
require 'Licence.inc.php';
require 'Contact.inc.php';

class DB {
	private static $instance = null; //mémorisation de l'instance de DB pour appliquer le pattern Singleton
	private $connect=null; //connexion PDO à la base

	/************************************************************************/
	//	Constructeur gerant  la connexion à la base via PDO                 //
	//	NB : il est non utilisable a l'exterieur de la classe DB            //
	/************************************************************************/
	private function __construct() {
		// Connexion à la base de données
		$connStr = 'pgsql:host=woody port=5432 dbname=bv200989';
		try {
			// Connexion à la base
			$this->connect = new PDO($connStr, 'bv200989', 'valentin');

			// Configuration facultative de la connexion
			$this->connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) {
			echo "problème de connexion :".$e->getMessage();
			return null;
		}
	}

	/************************************************************************/
	//	Methode permettant d'obtenir un objet instance de DB
	//	NB : cet objet est unique pour l'exécution d'un même script PHP
	//	NB2: c'est une methode de classe.
	/************************************************************************/
	public static function getInstance() {
		if (is_null(self::$instance)) {
			try {
				self::$instance = new DB();
			}
			catch (PDOException $e) {
				echo $e;
			}
		} //fin IF
		$obj = self::$instance;

		if (($obj->connect) == null) {
			self::$instance=null;
		}
		return self::$instance;
	} //fin getInstance

	/************************************************************************/
	//	Methode permettant de fermer la connexion a la base de données      //
	/************************************************************************/
	public function close() {
		$this->connect = null;
	}

	/************************************************************************/
	//	Methode uniquement utilisable dans les méthodes de la class DB
	//	permettant d'exécuter n'importe quelle requête SQL
	//	et renvoyant en résultat les tuples renvoyés par la requête
	//	sous forme d'un tableau d'objets
	//	param1 : texte de la requête à exécuter (éventuellement paramétrée)
	//	param2 : tableau des valeurs permettant d'instancier les paramètres de la requête
	//	NB : si la requête n'est pas paramétrée alors ce paramètre doit valoir null.
	//	param3 : nom de la classe devant être utilisée pour créer les objets qui vont
	//	représenter les différents tuples.
	//	NB : cette classe doit avoir des attributs qui portent le même que les attributs
	//	de la requête exécutée.
	//	ATTENTION : il doit y avoir autant de ? dans le texte de la requête
	//	que d'éléments dans le tableau passé en second paramètre.
	//	NB : si la requête ne renvoie aucun tuple alors la fonction renvoie un tableau vide
	/************************************************************************/
	private function execQuery($requete,$tparam,$nomClasse) {
		//on prépare la requête
		try {
			$stmt = $this->connect->prepare($requete);
		} catch(Exception $e) { echo $e->getMessage(); }
		
		//on indique que l'on va récupére les tuples sous forme d'objets instance de Auteur
		$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $nomClasse);
		
		//on exécute la requête
		if ($tparam != null) {
			$stmt->execute($tparam);
		}
		else {
			$stmt->execute();
		}
		//récupération du résultat de la requête sous forme d'un tableau d'objets
		$tab = array();
		$tuple = $stmt->fetch(); //on récupère le premier tuple sous forme d'objet
		if ($tuple) {
			//au moins un tuple a été renvoyé
			while ($tuple != false) {
				$tab[]=$tuple; //on ajoute l'objet en fin de tableau
				$tuple = $stmt->fetch(); //on récupère un tuple sous la forme
				//d'un objet instance de la classe $nomClasse
			} //fin du while
		}
		return $tab;
	}


	private function execQueryNoObject($requete, $tparam) {
		
		try {
			$stmt = $this->connect->prepare($requete);
		} catch(Exception $e) { echo $e->getMessage(); }
		
		$stmt->execute($tparam);
		return $stmt->fetchColumn();
	}

	private function execQueryNoParam($requete) {
		
		try {
			$stmt = $this->connect->prepare($requete);
		} catch(Exception $e) { echo $e->getMessage(); }
		
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	/************************************************************************/
	//	Methode utilisable uniquement dans les méthodes de la classe DB
	//	permettant d'exécuter n'importe quel ordre SQL (update, delete ou insert)
	//	autre qu'une requête.
	//	Résultat : nombre de tuples affectés par l'exécution de l'ordre SQL
	//	param1 : texte de l'ordre SQL à exécuter (éventuellement paramétré)
	//	param2 : tableau des valeurs permettant d'instancier les paramètres de l'ordre SQL
	//	ATTENTION : il doit y avoir autant de ? dans le texte de la requête
	//	que d'éléments dans le tableau passé en second paramètre.
	/************************************************************************/
	private function execMaj($ordreSQL,$tparam) {
		$stmt = $this->connect->prepare($ordreSQL);
		$res = $stmt->execute($tparam); //execution de l'ordre SQL
		return $stmt->rowCount();
	}



	/*************************************************************************
	 * Fonctions qui peuvent être utilisées dans les scripts PHP             *
	 *************************************************************************/

	public function getImage($email) {
		$requete = 'select cheminphoto from Auteur where email = ?';
		return $this->execQueryNoObject($requete, array($email));
	}

	public function getImageById($ida) {
		$requete = 'select cheminphoto from Auteur where idauteur = ?';
		return $this->execQueryNoObject($requete, array($ida));
	}


	public function getAuteur($id) {
		$requete = 'select * from auteur where idauteur = ?';
		return $this->execQuery($requete, array($id), 'Auteur');
	}

	public function getId($email) {
		$requete = 'select idauteur from Auteur where email = ?';
		return $this->execQueryNoObject($requete, array($email));
	}

	public function getMaxAuteurs() {
		$requete = 'select max(idauteur) from Auteur';
		$res = $this->execQueryNoParam($requete);
		
		if(!isset($res) || is_null($res) || !is_int($res)) { $res = 0; }
		return $res;
	}

	public function getAuteurs() {
		$requete = 'select * from auteur order by idauteur';
		return $this->execQuery($requete, null, 'Auteur');
	}

	public function insertAuteur($idA, $nom, $prenom, $email, $mdp, $image) {
		$requete = 'insert into auteur values(?,?,?,?,?,?)';
		$tparam = array($idA, $nom, $prenom, $email, md5($mdp), $image);
		return $this->execMaj($requete, $tparam);
	}

	public function updateAuteur($idAuteur, $nom, $prenom, $email, $mdp, $image) {
		$requete = 'update auteur set nom = ? , prenom = ? , email = ? , mdp = ? , cheminphoto = ? where idauteur = ?';
		$tparam = array($nom, $prenom, $email, $mdp, $image, $idAuteur);
		return $this->execMaj($requete, $tparam);
	}

	public function updateImage($id, $img) {
		$requete = 'update auteur set cheminphoto = ? where idauteur = ?';
		$tparam = array($img, $id);
		return $this->execMaj($requete, $tparam);
	}

	public function deleteAuteur($idAuteur) {
		$requete = 'delete from auteur where idauteur = ?';
		$tparam = array($idAuteur);
		return $this->execMaj($requete, $tparam);
	}

	public function getPorfolioCountWithId($id) {
		$requete = 'select count(*) from portfolio where idauteur = ?';
		return $this->execQueryNoObject($requete, array($id));
	}

	public function getMaxPortfolio() {
		$requete = 'select max(idportfolio) from Portfolio';
		$res = $this->execQueryNoObject($requete, array());
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function getPortfolios() {
		$requete = 'select * from portfolio order by idportfolio';
		return $this->execQuery($requete, null, 'Portfolio');
	}

	public function getAuteurOf($idp) {
		$requete = 'select idauteur from portfolio where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getPortfoliosById($ida) {
		$requete = 'select * from portfolio where idauteur = ? order by idportfolio';
		return $this->execQuery($requete, array($ida), 'Portfolio');
	}

	public function insertPortfolio($idp, $ida, $titre, $chemina, $chemins) {
		$requete = 'insert into portfolio values(?,?,?,?,?)';
		$tparam = array($idp, $ida, $titre, $chemina, $chemins);
		return $this->execQuery($requete, $tparam, 'Portfolio');
	}

	public function updatePortfolio($idp, $ida, $titre, $chemina, $chemins) {
		$requete = 'update portfolio set titrep = ? , cheminauteur = ? , cheminspec = ? where idportfolio = ?';
		$tparam = array($titre, $chemina, $chemins, $idp);
		return $this->execMaj($requete, $tparam);
	}

	public function deletePortfolio($idp) {
		$requete = 'delete from portfolio where idportfolio = ?';
		return $this->execMaj($requete, array($idp));
	}



	// -------- //
	// CREATION //
	// -------- //

	//Accueil
	public function getAccueils() {
		$requete = 'select * from accueil order by idaccueil';
		return $this->execQuery($requete, null, 'Accueil');
	}

	public function getMaxAccueil() {
		$requete = 'select max(idaccueil) from Accueil';
		$res = $this->execQueryNoObject($requete, array());
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function getTexteAccueil($idp) {
		$requete = 'select texteacc from accueil where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getAccueilById($ida, $idp) {
		$requete = 'select * from accueil where idauteur = ? and idportfolio = ? order by idaccueil';
		return $this->execQuery($requete, array($ida, $idp), 'Accueil');
	}

	public function insertAccueil($id, $idp, $ida, $texte) {
		$requete = 'insert into accueil values(?,?,?,?)';
		$tparam = array($id, $idp, $ida, $texte);
		return $this->execMaj($requete, $tparam);
	}

	public function updateAccueil($id, $idp, $ida, $texte) {
		$requete = 'update accueil set texteacc = ? where idaccueil = ? and idportfolio = ? and idauteur = ?';
		$tparam = array($texte, $id, $idp, $ida);
		return $this->execMaj($requete, $tparam);
	}

	public function deleteAccueil($id) {
		$requete = 'delete from accueil where idaccueil = ?';
		return $this->execMaj($requete, array($id));
	}



	// CV
	public function getCVs() {
		$requete = 'select * from cv order by idcv';
		return $this->execQuery($requete, null, 'CV');
	}

	public function getCVById($ida, $idp) {
		$requete = 'select * from CV where idauteur = ? and idportfolio = ? order by idcv';
		return $this->execQuery($requete, array($ida, $idp), 'CV');
	}

	public function getMaxCV() {
		$requete = 'select max(idcv) from CV';
		$res = $this->execQueryNoObject($requete, array());
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function insertCV($id, $idp, $ida, $chemincv, $imagecv, $textecv) {
		$requete = 'insert into cv values(?,?,?,?,?,?)';
		$tparam = array($id, $idp, $ida, $chemincv, $imagecv, $textecv);
		return $this->execMaj($requete, $tparam);
	}

	public function updateCV($id, $idp, $ida, $chemincv, $imagecv, $textecv) {
		$requete = 'update cv set chemincv = ? , imagecv = ? , textecv = ? where idcv = ? and idportfolio = ? and idauteur = ?';
		$tparam = array($chemincv, $imagecv, $textecv, $id, $idp, $ida);
		return $this->execMaj($requete, $tparam);
	}


	// Compétence
	public function getCompetences() {
		$requete = 'select * from competence order by idcomp';
		return $this->execQuery($requete, null, 'Competence');
	}

	public function getCompetenceById($ida, $idp) {
		$requete = 'select * from Competence where idauteur = ? and idportfolio = ? order by idcomp';
		return $this->execQuery($requete, array($ida, $idp), 'Competence');
	}

	public function getCompetenceByIdComp($idcomp, $ida, $idp) {
		$requete = 'select * from Competence where idcomp = ? and idauteur = ? and idportfolio = ? order by idcomp';
		return $this->execQuery($requete, array($idcomp, $ida, $idp), 'Competence');
	}

	public function getMaxCompetence() {
		$requete = 'select max(idcomp) from Competence';
		$res = $this->execQueryNoObject($requete, array());
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function insertCompetence($idcomp, $idp, $ida, $titre, $texte, $couleur) {
		$requete = 'insert into competence values(?,?,?,?,?,?)';
		$tparam = array($idcomp, $idp, $ida, $titre, $texte, $couleur);
		return $this->execMaj($requete, $tparam);
	}

	public function updateCompetence($idcomp, $idp, $ida, $titre, $texte, $couleur) {
		$requete = 'update competence set titre = ? , texte = ? , couleur = ? where idcomp = ? and idportfolio = ? and idauteur = ?';
		$tparam = array($titre, $texte, $couleur, $idcomp, $idp, $ida);
		return $this->execMaj($requete, $tparam);

	}



	// Projet
	public function getProjets() {
		$requete = 'select * from projet order by idprojet';
		return $this->execQuery($requete, null, 'Projet');
	}

	public function getProjetsId($ida, $idp) {
		$requete = 'select * from projet where idauteur = ? and idportfolio = ? order by idprojet';
		return $this->execQuery($requete, array($ida, $idp), 'Projet');
	}

	public function getProjetById($idprojet, $ida, $idp) {
		$requete = 'select * from projet where idprojet = ? and idauteur = ? and idportfolio = ?';
		return $this->execQuery($requete, array($idprojet, $ida, $idp), 'Projet');
	}

	public function getTitreProjet($idp) {
		$requete = 'select titrep from projet where idprojet = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getTexteProjet($idp) {
		$requete = 'select descriptionp from projet where idprojet = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getCouleurProjet($idp) {
		$requete = 'select couleur from projet where idprojet = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getNbProjet($idp) {
		$requete = 'select count(*) from projet where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getMaxProjet($idp) {
		$requete = 'select max(idprojet) from Projet where idportfolio = ?';
		$res = $this->execQueryNoObject($requete, array($idp));
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function insertProjet($idprojet, $idp, $ida, $titrep, $descp, $couleur) {
		$requete = 'insert into projet values(?,?,?,?,?,?)';
		$tparam = array($idprojet, $idp, $ida, $titrep, $descp, $couleur);
		return $this->execMaj($requete, $tparam);
	}

	public function updateProjet($idprojet, $idp, $ida, $titrep, $descp, $couleur) {
		$requete = 'update projet set titrep = ? , descriptionp = ? , couleur = ? where idprojet = ? and idportfolio = ? and idauteur = ?';
		$tparam = array($titrep, $descp, $couleur, $idprojet, $idp, $ida);
		return $this->execMaj($requete, $tparam);
	}

	public function deleteAllProjets($idp, $ida) {
		$requete = 'delete from projet * where idportfolio = ? and idauteur = ?';
		return $this->execMaj($requete, array($idp, $ida));
	}

	// =======
	// Licence
	// =======
	public function getLicences() {
		$requete = 'select * from licence order by idlicence';
		return $this->execQuery($requete, null, 'Licence');
	}

	public function getLicenceTitre($idp) {
		$requete = 'select titrel from licence where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getLicenceTexte($idp) {
		$requete = 'select textel from licence where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idp));
	}

	public function getLicenceById($ida, $idp) {
		$requete = 'select * from licence where idauteur = ? and idportfolio = ? order by idlicence';
		return $this->execQuery($requete, array($ida, $idp), 'Licence');
	}

	public function getMaxLicence() {
		$requete = 'select max(idlicence) from licence';
		$res = $this->execQueryNoObject($requete, array());
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function insertLicence($idlicence, $idp, $ida, $titrel, $textel) {
		$requete = 'insert into licence values(?,?,?,?,?)';
		$tparam = array($idlicence, $idp, $ida, $titrel, $textel);
		return $this->execMaj($requete, $tparam);
	}

	public function updateLicence($idlicence, $idp, $ida, $titrel, $textel) {
		$requete = 'update licence set titrel = ? , textel = ? where idlicence = ? and idportfolio = ? and idauteur = ?';
		$tparam = array($titrel, $textel, $idlicence, $idp, $ida);
		return $this->execMaj($requete, $tparam);
	}


	// Contact
	public function getContacts() {
		$requete = 'select * from contact order by idcontact';
		return $this->execQuery($requete, null, 'Contact');
	}

	public function getContactById($ida, $idp) {
		$requete = 'select * from Contact where idauteur = ? and idportfolio = ? order by idlicence';
		return $this->execQuery($requete, array($ida, $idp), 'Contact');
	}

	public function getMaxContact() {
		$requete = 'select max(idcontact) from Contact';
		$res = $this->execQueryNoObject($requete, array());
		
		if(!isset($res) || is_null($res)) { $res = 0; }
		return $res;
	}

	public function insertContact($idcontact, $idp, $ida, $emailc, $numtel, $github, $instagram, $facebook, $twitter, $linkedin) {
		$requete = 'insert into contact values(?,?,?,?,?,?,?,?,?,?)';
		$tparam = array($idcontact, $idp, $ida, $emailc, $numtel, $github, $instagram, $facebook, $twitter, $linkedin);
		return $this->execMaj($requete, $tparam);
	}

	public function updateContact($idcontact, $idp, $ida, $emailc, $numtel, $github, $instagram, $facebook, $twitter, $linkedin) {
		$requete = 'update contact set emailc = ? , numtel = ? , github = ? , instagram = ? , facebook = ? , twitter = ? ,
					linkedin = ? where idcontact = ? and idportfolio = ? and idauteur = ?';
		$tparam = array($emailc, $numtel, $github, $instagram, $facebook, $twitter, $linkedin, $idcontact, $idp, $ida);
		return $this->execMaj($requete, $tparam);
	}

	public function getEmailC($idport) {
		$requete = 'select emailc from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

	public function getNumTel($idport) {
		$requete = 'select numtel from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

	public function getGithub($idport) {
		$requete = 'select github from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

	public function getInsta($idport) {
		$requete = 'select instagram from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

	public function getFB($idport) {
		$requete = 'select facebook from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

	public function getTwitter($idport) {
		$requete = 'select twitter from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

	public function getLinkedin($idport) {
		$requete = 'select linkedin from contact where idportfolio = ?';
		return $this->execQueryNoObject($requete, array($idport));
	}

} //fin classe DB

?>