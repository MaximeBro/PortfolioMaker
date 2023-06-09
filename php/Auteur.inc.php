<?php

class Auteur {
	private $idauteur;
	private $nom;
	private $prenom;
	private $email;
	private $mdp;
	private $pdp;

	public function __construct($i=-1, $name="", $lastName="", $email="", $password="", $image="") {
		$this->idauteur = $i;
		$this->nom = $name;
		$this->prenom = $lastName;
		$this->email = $email;
		$this->mdp = $password;
		$this->pdp = $image;
	}

	public function getId()  { return $this->idauteur; }
	public function getNom() { return $this->nom; }
	public function getPrenom() { return $this->prenom; }
	public function getEmail() { return $this->email; }
	public function getPassword() { return $this->mdp; }
	public function getImage() { return $this->pdp; }

	public function setImage($img) { $this->pdp = $img; }

	public function __toString() {
		$res = "id:".$this->idauteur."\n";
		$res = $res ."nom:".$this->nom."\n";
		$res = $res ."prénom:".$this->prenom."\n";
		$res = $res ."email:".$this->email."\n";
		$res = $res ."mdp:".$this->mdp."\n";
		$res = $res ."pdp:".$this->pdp."\n";
		return $res;

	}
}

?>