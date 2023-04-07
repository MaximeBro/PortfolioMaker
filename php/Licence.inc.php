<?php

class Licence {
	private $idlicence;
	private $idportfolio;
	private $idauteur;
	private $titre;
	private $texte;

	public function __construct($idlicence=-1, $idp=-1, $ida=-1, $titre="", $texte="") {
		$this->idlicence = $idlicence;
		$this->idportfolio = $idp;
		$this->idauteur = $ida;
		$this->titre = $titre;
		$this->texte = $texte;
	}

	public function getId()  { return $this->idlicence; }
	public function getIdP()  { return $this->idportfolio; }
	public function getIdA()  { return $this->idauteur; }
	public function getTitre() { return $this->titre; }
	public function getTexte() { return $this->texte; }

	public function __toString() {
		$res = "id:".$this->idlicence."\n";
		$res = $res ."idp:".$this->idportfolio."\n";
		$res = $res ."ida:".$this->idauteur."\n";
		$res = $res ."titre:".$this->titre."\n";
		$res = $res ."texte:".$this->texte."\n";
		return $res;

	}
}

?>