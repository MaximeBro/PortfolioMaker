/* Script de création de la base de données */
/* Author : Ecare-Us */

-- drop toute les tables si elles existent
drop table if exists Auteur cascade;
drop table if exists Portfolio cascade;
drop table if exists Image cascade;
drop table if exists Accueil cascade;
drop table if exists Licence cascade;
drop table if exists Contact cascade;
drop table if exists Projet cascade;
drop table if exists Competence cascade;
drop table if exists CV cascade;



/* Table Auteur
		- idAuteur    : identifiant de l'auteur
		- nom         : nom de l'auteur
		- prenom      : prénom de l'auteur
		- email       : email de l'auteur
		- mdp         : mot de passe de l'auteur
		- cheminPhoto : chemin de la photo de l'auteur
*/
CREATE TABLE Auteur (
	idauteur integer primary key NOT NULL,
	nom VARCHAR(50) NOT NULL,
	prenom VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	mdp text NOT NULL,
	cheminphoto text NOT NULL
);


/* Table Portfolio
		- idPortfolio   : identifiant du portfolio
		- idAuteur      : identifiant de l'auteur
		- titreP        : titre du portfolio
		- cheminAuteur  : chemin de la photo de l'auteur
		- cheminSpec    : chemin de la photo dans fichiers serveur
*/
CREATE TABLE Portfolio (
	idportfolio integer NOT NULL,
	idauteur 	integer references Auteur(idauteur) NOT NULL,
	titrep text NOT NULL,
	cheminauteur text NOT NULL,
	cheminspec text NOT NULL,

	primary key(idportfolio, idauteur),
	unique(idportfolio)
);

/* Table Accueil
		- idAccueil   : identifiant de l'accueil
		- idPortfolio : identifiant du portfolio
		- idAuteur    : identifiant de l'auteur
		- texteAcc	  : texte de l'accueil
*/
CREATE TABLE Accueil (
	idaccueil serial NOT NULL,
	idportfolio serial references Portfolio(idportfolio) NOT NULL,
	idauteur 	integer references Auteur(idauteur) NOT NULL,

	texteacc text NOT NULL,

	primary key(idaccueil, idportfolio, idauteur)
);

/* Table Image
		- idImage   : identifiant de l'image
		- titreI    : titre de l'image
		- cheminI   : chemin de l'image
*/
CREATE TABLE Image (
	idimage serial primary key NOT NULL,
	titrei text NOT NULL,
	chemini text NOT NULL
);


/* Table Licence
		- idLicence   : identifiant de la licence
		- idPortfolio : identifiant du portfolio
		- idAuteur    : identifiant de l'auteur
		- titreL      : titre de la licence
		- texteL      : texte de la licence
*/
CREATE TABLE Licence (
	idlicence serial NOT NULL,
	idportfolio serial references Portfolio(idportfolio) NOT NULL,
	idauteur 	integer references Auteur(idauteur) NOT NULL,
	titrel VARCHAR(255) NOT NULL,
	texteL text NOT NULL,

	primary key(idlicence, idportfolio, idauteur)
);


/* Table Contact
		- emailC      : email de contact
		- idPortfolio : identifiant du portfolio
		- idAuteur    : identifiant de l'auteur
		- numTel      : numéro de téléphone
		- github      : lien github
		- instagram   : lien instagram
		- facebook    : lien facebook
		- twitter     : lien twitter
		- linkedin    : lien linkedin
*/
CREATE TABLE Contact (
	idcontact serial NOT NULL,
	idportfolio serial references Portfolio(idportfolio) NOT NULL,
	idauteur 	integer references Auteur(idauteur) NOT NULL,

	emailc VARCHAR(50) NOT NULL,
	numtel VARCHAR(50),
	github text,
	instagram VARCHAR(50),
	facebook text,
	twitter VARCHAR(50),
	linkedin text,

	primary key(idcontact, idportfolio, idauteur)
);


/* Table Projet
		- idProjet     : identifiant du projet
		- idPortfolio  : identifiant du portfolio
		- idAuteur     : identifiant de l'auteur
		- titreP       : titre du projet
		- descriptionP : description du projet
		- dateP        : date du projet
		- lienP        : lien du projet
*/
CREATE TABLE Projet (
	idprojet serial NOT NULL,
	idportfolio serial references Portfolio(idportfolio) NOT NULL,
	idauteur integer references Auteur(idauteur) NOT NULL,

	titrep text NOT NULL,
	descriptionp text NOT NULL,
	couleur VARCHAR(50) NOT NULL,

	primary key(idprojet, idportfolio, idauteur)
);


/* Table Competence
		- idComp       : identifiant de la compétence
		- idPortfolio  : identifiant du portfolio
		- idAuteur     : identifiant de l'auteur
		- titre        : titre de la compétence
		- texte        : texte de la compétence
		- couleur      : couleur de la compétence
*/
CREATE TABLE Competence (
	idcomp serial NOT NULL,
	idportfolio serial references Portfolio(idportfolio) NOT NULL,
	idauteur 	integer references Auteur(idauteur) NOT NULL,

	titre VARCHAR(255) NOT NULL,
	texte VARCHAR(255) NOT NULL,
	couleur VARCHAR(255) NOT NULL,

	primary key(idcomp, idportfolio, idauteur)
);


/* Table CV
		- idCv         : identifiant du CV
		- idPortfolio  : identifiant du portfolio
		- idAuteur     : identifiant de l'auteur
		- cheminCV     : chemin du CV
		- imageCV      : image du CV
		- texteCV      : texte du CV
*/
CREATE TABLE CV (
	idcv serial NOT NULL,
	idportfolio serial references Portfolio(idportfolio) NOT NULL,
	idauteur 	integer references Auteur(idauteur) NOT NULL,

	chemincv text,
	imagecv text NOT NULL,
	textecv text NOT NULL,

	primary key(idcv, idportfolio, idauteur)
);



/* Insertion d'un auteur */
-- INSERT INTO AUTEUR VALUES(1, 'admin', 'admin', 'admin@ecareus.fr', 'admin', 'admin.png');
