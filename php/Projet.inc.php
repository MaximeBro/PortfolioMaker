<?php

class Projet {
	private $idprojet;
	private $idportfolio;
	private $idauteur;
	private $titrep;
	private $descriptionp;
	private $couleur;

	public function __construct($idprojet=-1, $idp=-1, $ida=-1, $titre="", $desc="", $couleur="") {
		$this->idprojet = $idprojet;
		$this->idportfolio = $idp;
		$this->idauteur = $ida;
		$this->titrep = $titre;
		$this->descriptionp = $desc;
		$this->couleur = $couleur;
	}

	public function getId() { return $this->idprojet; }
	public function getIdP() { return $this->idportfolio; }
	public function getIdA() { return $this->idauteur; }
	public function getTitre() { return $this->titrep; }
	public function getDesc() { return $this->descriptionp; }
	public function getCouleur() { return $this->couleur; }

	public function __toString() {
		$res = "id:".$this->idprojet."\n";
		$res = $res ."idp:".$this->idportfolio."\n";
		$res = $res ."ida:".$this->idauteur."\n";
		$res = $res ."titre:".$this->titrep."\n";
		$res = $res ."desc:".$this->descriptionp."\n";
		$res = $res ."couleur:".$this->couleur."\n";
		return $res;

	}
}

?>