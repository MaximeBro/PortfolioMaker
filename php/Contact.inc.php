<?php

class Contact {
	private $idcontact;
	private $idportfolio;
	private $idauteur;
	private $emailc;
	private $numtel;
	private $github;
	private $instagram;
	private $facebook;
	private $twitter;
	private $linkedin;

	public function __construct($idcontact=-1, $idp=-1, $ida=-1, $emailc="", $numtel="", 
					 $github="", $instagram="", $facebook="", $twitter="", $linkedin="") {
		
		$this->idcontact = $idcontact;
		$this->idportfolio = $idp;
		$this->idauteur = $ida;
		$this->emailc = $emailc;
		$this->numtel = $numtel;
		$this->github = $github;
		$this->instagram = $instagram;
		$this->facebook = $facebook;
		$this->twitter = $twitter;
		$this->linkedin = $linkedin;
	}

	public function getId()  { return $this->idcontact; }
	public function getIdP()  { return $this->idportfolio; }
	public function getIdA()  { return $this->idauteur; }
	public function getEmailC() { return $this->emailc; }
	public function getNumTel() { return $this->numtel; }
	public function getGithub() { return $this->github; }
	public function getInstagram() { return $this->instagram; }
	public function getFacebook() { return $this->facebook; }
	public function getTwitter() { return $this->twitter; }
	public function getLinkedin() { return $this->linkedin; }

	public function __toString() {
		$res = "id:".$this->idcontact."\n";
		$res = $res ."idp:".$this->idportfolio."\n";
		$res = $res ."ida:".$this->idauteur."\n";
		$res = $res ."emailc:".$this->emailc."\n";
		$res = $res ."numtel:".$this->numtel."\n";
		$res = $res ."github:".$this->github."\n";
		$res = $res ."instagram:".$this->instagram."\n";
		$res = $res ."facebook:".$this->facebook."\n";
		$res = $res ."twitter:".$this->twitter."\n";
		$res = $res ."linkedin:".$this->linkedin."\n";
		return $res;

	}
}

?>