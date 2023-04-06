<?php

class Portfolio {
	private $idportfolio;
	private $idauteur;
	private $titrep;
	private $cheminauteur;
	private $cheminspec;

	public function __construct($idp=-1, $ida=-1, $titre="", $cheminauteur="", $cheminspec="") {
		$this->idportfolio = $idp;
		$this->idauteur = $ida;
		$this->titrep = $titre;
		$this->cheminauteur = $cheminauteur;
		$this->cheminspec = $cheminspec;
	}

	public function getIdP()  { return $this->idportfolio; }
	public function getIdA() { return $this->idauteur; }
	public function getTitre() { return $this->titrep; }
	public function getCheminA() { return $this->cheminauteur; }
	public function getCheminS() { return $this->cheminspec; }

	public function __toString() {
		$res = "idP : ".$this->idportfolio."\n";
		$res = $res."idP : ".$this->idauteur."\n";
		$res = $res."titreP : ".$this->titrep."\n";
		$res = $res."cheminA :".$this->cheminauteur."\n";
		$res = $res."cheminP :".$this->cheminspec."\n";
		return $res;
	}
}

?>