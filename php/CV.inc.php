<?php

class CV {
	private $idcv;
	private $idportfolio;
	private $idauteur;
	private $chemincv;
	private $imagecv;
	private $textecv;

	public function __construct($idcv=-1, $idp=-1, $idaut=-1, $chemin="", $image="", $texte="") {
		$this->idcv = $idcv;
		$this->idportfolio = $idp;
		$this->idauteur = $idaut;
		$this->chemincv = $chemin;
		$this->imagecv = $image;
		$this->textecv = $texte;
	}

	public function getId()  { return $this->idcv; }
	public function getIdP()  { return $this->idportfolio; }
	public function getIdA()  { return $this->idauteur; }
	public function getChemin() { return $this->chemincv; }
	public function getImage() { return $this->imagecv; }
	public function getTexte() { return $this->textecv; }

	public function __toString() {
		$res = "id:".$this->idcv."\n";
		$res = $res ."idp:".$this->idportfolio."\n";
		$res = $res ."ida:".$this->idauteur."\n";
		$res = $res ."chemin:".$this->chemincv."\n";
		$res = $res ."image:".$this->imagecv."\n";
		$res = $res ."texte:".$this->textecv."\n";
		return $res;

	}
}

?>