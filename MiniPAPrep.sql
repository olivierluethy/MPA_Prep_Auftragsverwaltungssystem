-- This is the SQL for the database structure for the Mini PA preparation --

DROP DATABASE IF EXISTS minipaprep;
CREATE DATABASE minipaprep;
USE minipaprep;

CREATE TABLE Mitarbeiter (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR (50) NOT NULL,
	adresse VARCHAR (50) NOT NULL, 
	email VARCHAR (100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	istAdmin TINYINT(1) NOT NULL
);

CREATE TABLE Auftraege (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	titel VARCHAR (50) NOT NULL,
	beschreibung VARCHAR (500) NOT NULL,
	fk_mitarbeiterId INT NOT NULL,
	erledigen_am DATE DEFAULT CURRENT_TIMESTAMP,
	status TINYINT(1) NOT NULL,
	document LONGBLOB NOT NULL,
	FOREIGN KEY (fk_mitarbeiterId) REFERENCES Mitarbeiter(id)
);