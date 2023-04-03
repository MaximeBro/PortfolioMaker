-- mon ami fait moi le script sql de création des tables :
-- (copilot) stp
-- Auteur(idAuteur, nom, prenom, email, mdp, cheminPhoto)
-- Portfolio(idPortfolio, titre, cheminAuteur, cheminSpec)
-- Image(idImage, titre, cheminImage)
-- Licence(idLicence, titre, texte)
-- Contact(email, numTel, github, instagram, facebook, twitter, linkedin)
-- Projet(idProjet, titre, description, date, lien)
-- Competence(idComp, titre, texte, couleur)
-- CV(idCv, image, texte)



-- drop toute les tables si elles existent
drop table if exists Auteur cascade;
drop table if exists Portfolio cascade;
drop table if exists Image cascade;
drop table if exists Licence cascade;
drop table if exists Contact cascade;
drop table if exists Projet cascade;
drop table if exists Competence cascade;
drop table if exists CV cascade;




CREATE TABLE Auteur (
	idAuteur integer primary key NOT NULL,
	nom VARCHAR(50) NOT NULL,
	prenom VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	mdp text NOT NULL,
	cheminPhoto text NOT NULL
);

CREATE TABLE Portfolio (
	idPortfolio serial NOT NULL,
	idAuteur 	integer references Auteur(idAuteur) NOT NULL,
	titreP text NOT NULL,
	cheminAuteur text NOT NULL,
	cheminSpec text NOT NULL,

	primary key(idPortfolio, idAuteur),
	unique(idPortfolio)
);

CREATE TABLE Image (
	idImage serial primary key NOT NULL,
	titreI text NOT NULL,
	cheminI text NOT NULL
);

CREATE TABLE Licence (
	idLicence serial NOT NULL,
	idPortfolio serial references Portfolio(idPortfolio) NOT NULL,
	idAuteur 	integer references Auteur(idAuteur) NOT NULL,
	titreL VARCHAR(255) NOT NULL,
	texteL VARCHAR(255) NOT NULL,

	primary key(idLicence, idPortfolio, idAuteur)
);

CREATE TABLE Contact (
	emailC VARCHAR(50) NOT NULL,
	idPortfolio serial references Portfolio(idPortfolio) NOT NULL,
	idAuteur 	integer references Auteur(idAuteur) NOT NULL,

	numTel VARCHAR(50),
	github text,
	instagram VARCHAR(50),
	facebook text,
	twitter VARCHAR(50),
	linkedin text,

	primary key(emailC, idPortfolio, idAuteur)
);

CREATE TABLE Projet (
	idProjet serial NOT NULL,
	idPortfolio serial references Portfolio(idPortfolio) NOT NULL,
	idAuteur 	integer references Auteur(idAuteur) NOT NULL,

	titreP text NOT NULL,
	descriptionP text NOT NULL,
	dateP VARCHAR(255) NOT NULL,
	lienP text NOT NULL,

	primary key(idProjet, idPortfolio, idAuteur)
);

CREATE TABLE Competence (
	idComp serial NOT NULL,
	idPortfolio serial references Portfolio(idPortfolio) NOT NULL,
	idAuteur 	integer references Auteur(idAuteur) NOT NULL,

	titre VARCHAR(255) NOT NULL,
	texte VARCHAR(255) NOT NULL,
	couleur VARCHAR(255) NOT NULL,

	primary key(idComp, idPortfolio, idAuteur)
);

CREATE TABLE CV (
	idCv serial NOT NULL,
	idPortfolio serial references Portfolio(idPortfolio) NOT NULL,
	idAuteur 	integer references Auteur(idAuteur) NOT NULL,

	cheminCV text,
	imageCV text NOT NULL,
	texteCV text NOT NULL,

	primary key(idCv, idPortfolio, idAuteur)
);


INSERT INTO AUTEUR VALUES(1, 'admin', 'admin', 'admin@ecareus.fr', 'admin', 'admin.png');
