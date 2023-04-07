<?php

class Competence {
	private $idcomp;
	private $idportfolio;
	private $idauteur;
	private $titre;
	private $texte;
	private $couleur;

	public function __construct($idcomp=-1, $idp=-1, $ida=-1, $titre="", $texte="", $couleur="") {
		$this->idcomp = $idcomp;
		$this->idportfolio = $idp;
		$this->idauteur = $ida;
		$this->titre = $titre;
		$this->texte = $texte;
		$this->couleur = $couleur;
	}

	public function getId()  { return $this->idcomp; }
	public function getIdP()  { return $this->idportfolio; }
	public function getIdA()  { return $this->idauteur; }
	public function getTitre() { return $this->titre; }
	public function getTexte() { return $this->texte; }
	public function getCouleur() { return $this->couleur; }

	public function __toString() {
		$res = "id:".$this->idcomp."\n";
		$res = $res ."idp:".$this->idportfolio."\n";
		$res = $res ."ida:".$this->idauteur."\n";
		$res = $res ."titre:".$this->titre."\n";
		$res = $res ."texte:".$this->texte."\n";
		$res = $res ."couleur:".$this->couleur."\n";
		return $res;

	}
}

?>