-- Active: 1706110255136@@127.0.0.1@3306
CREATE OR REPLACE USER 'local_user'@'localhost' IDENTIFIED BY 'password';
DROP DATABASE IF EXISTS db_gestion_cabinet_app;
create database db_gestion_cabinet_app;

USE db_gestion_cabinet_app;

CREATE TABLE usager(
   id_usager INT AUTO_INCREMENT,
   civilite VARCHAR(50) NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   sexe CHAR(1) NOT NULL,
   adresse VARCHAR(50) NOT NULL,
   code_postal CHAR(5) NOT NULL,
   ville VARCHAR(50) NOT NULL,
   date_nais DATE NOT NULL,
   lieu_nais VARCHAR(50) NOT NULL,
   num_secu CHAR(15) NOT NULL,
   CONSTRAINT PK_usager PRIMARY KEY(id_usager),
   CONSTRAINT AK_usager UNIQUE(num_secu)
);

CREATE TABLE medecin(
   id_medecin INT AUTO_INCREMENT,
   civilite VARCHAR(5) NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   CONSTRAINT PK_medecin PRIMARY KEY(id_medecin)
);

CREATE TABLE consultation(
   id_consult INT AUTO_INCREMENT,
   date_consult DATE NOT NULL,
   heure_consult TIME NOT NULL,
   duree_consult TINYINT NOT NULL,
   id_medecin INT NOT NULL,
   id_usager INT NOT NULL,
   CONSTRAINT PK_consultation PRIMARY KEY(id_consult),
   CONSTRAINT AK_consultation_idx2 UNIQUE(id_medecin, date_consult, heure_consult),
   CONSTRAINT AK_consultation_idx1 UNIQUE(id_usager, date_consult, heure_consult),
   CONSTRAINT FK_consultation_medecin FOREIGN KEY(id_medecin) REFERENCES medecin(id_medecin),
   CONSTRAINT FK_consultation_usager FOREIGN KEY(id_usager) REFERENCES usager(id_usager)
);


DROP DATABASE IF EXISTS db_gestion_cabinet_auth;
create database db_gestion_cabinet_auth;

USE db_gestion_cabinet_auth;


CREATE TABLE user_auth_v2(
   login VARCHAR(50),
   mdp VARCHAR(50) NOT NULL,
   id_auth VARCHAR(50) NOT NULL,
   role VARCHAR(50),
   PRIMARY KEY(login),
   UNIQUE(id_auth)
);
