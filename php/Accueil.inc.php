<?php

class Accueil {
	private $idaccueil;
	private $idportfolio;
	private $idauteur;
	private $texte;

	public function __construct($ida=-1, $idp=-1, $idaut=-1, $texte="") {
		$this->idaccueil = $ida;
		$this->idportfolio = $idp;
		$this->idauteur = $idaut;
		$this->texte = $texte;
	}

	public function getId()  { return $this->idaccueil; }
	public function getIdP()  { return $this->idportfolio; }
	public function getIdA()  { return $this->idauteur; }
	public function getTexte() { return $this->texte; }

	public function __toString() {
		$res = "id:".$this->idaccueil."\n";
		$res = $res ."idp:".$this->idportfolio."\n";
		$res = $res ."ida:".$this->idauteur."\n";
		$res = $res ."texte:".$this->texte."\n";
		return $res;

	}
}

?>