-- Active: 1710323626621@@127.0.0.1@3306@db_gestion_cabinet_app
CREATE OR REPLACE USER 'local_user'@'localhost' IDENTIFIED BY 'password';
DROP DATABASE IF EXISTS db_gestion_cabinet_app;
create database db_gestion_cabinet_app;

grant all privileges on db_gestion_cabinet_app.* TO 'local_user'@'localhost' identified by 'password';

USE db_gestion_cabinet_app;

CREATE TABLE medecin(
   id_medecin INT AUTO_INCREMENT,
   civilite VARCHAR(50) NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   CONSTRAINT PK_medecin PRIMARY KEY(id_medecin),
   CONSTRAINT ch_civilite_med CHECK(civilite IN ('M.', 'Mme.'))
);

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
   id_medecin INT,
   CONSTRAINT PK_usager_usa PRIMARY KEY(id_usager),
   CONSTRAINT FK_usager_medecin FOREIGN KEY(id_medecin) REFERENCES medecin(id_medecin),
   CONSTRAINT AK_usager_usa UNIQUE(num_secu),
   CONSTRAINT ch_sexe_usa CHECK(sexe IN ('H', 'F')),
   CONSTRAINT ch_code_postal_usa CHECK(LENGTH(code_postal) = 5),
   CONSTRAINT ch_num_secu_usa CHECK(LENGTH(num_secu) = 15),
   CONSTRAINT ch_civilite_usa CHECK(civilite IN ('M.', 'Mme.'))
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
   CONSTRAINT FK_consultation_usager FOREIGN KEY(id_usager) REFERENCES usager(id_usager),
   CONSTRAINT ch_heure_consult CHECK(heure_consult BETWEEN '08:00:00' AND '18:00:00'),
   CONSTRAINT ch_duree_consult CHECK(duree_consult IN (15, 30, 45, 60))
);


INSERT INTO medecin(civilite, nom, prenom)
VALUES('M.', 'Dupont', 'Xavier'),
         ('Mme.', 'Darc', 'Jeanne'),
         ('M.', 'Siphon', 'Paul'),
         ('Mme.', 'Pinet', 'Maitas'),
         ('M.', 'Huge', 'Gilbert'),
         ('Mme.', 'Fanso', 'Sofian'),
         ('M.', 'Cub', 'Buque'),
         ('Mme.', 'Detoi', 'Morgan'),
         ('M.', 'Oskour', 'Jeanne'),
         ('Mme.', 'Manda', 'Loriianne');


INSERT INTO usager(civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu, id_medecin)
VALUES('M.', 'Dupont', 'Jean', 'H', '1 rue de la Paix', '75000', 'Paris', '1990-01-06', 'Paris', '180010101010101', 7),
         ('Mme.', 'Durand', 'Marie', 'F', '2 avenu de l''Angle', '31320', 'Auzeville-Tolosane', '1987-03-07', 'Clermont-Ferrant', '280010101010101', 5),
         ('Mme.', 'Martin', 'Sophie', 'F', '3 rue de la Paix', '75000', 'Paris', '1980-02-09', 'Paris', '380010101010101', 1),
         ('M.', 'Lefevre', 'Pierre', 'H', '4 rue de la Paix', '75000', 'Paris', '1975-04-10', 'Paris', '480010101010101', 2),
         ('M.', 'Leroy', 'Jacques', 'H', '5 rue de la Paix', '75000', 'Paris', '2000-05-11', 'Paris', '580010101010101', NULL),
         ('Mme.', 'Darc', 'Jeanne', 'F', '6 rue de la Paix', '75000', 'Paris', '1965-06-12', 'Paris', '680010101010101', 2),
         ('M.', 'Siphon', 'Paul', 'H', '7 rue de la Paix', '75000', 'Paris', '1989-07-13', 'Paris', '780010101010101', 3),
         ('Mme.', 'Pinet', 'Maitas', 'F', '8 rue de la Paix', '75000', 'Paris', '2003-08-14', 'Paris', '880010101010101', 4),
         ('M.', 'Leroy', 'Raymond', 'H', '9 rue de la Paix', '75000', 'Paris', '2004-09-15', 'Paris', '980010101010101', NULL),
         ('Mme.', 'Duminet', 'Marie', 'F', '10 rue de la Paix', '75000', 'Paris', '1945-10-16', 'Paris', '080010101010101', 1);

INSERT INTO consultation(date_consult, heure_consult, duree_consult, id_medecin, id_usager)
VALUES('2024-01-01', '08:00:00', 15, 1, 1),
         ('2024-01-02', '09:00:00', 30, 2, 2),
         ('2024-01-03', '10:00:00', 45, 3, 3),
         ('2024-01-04', '11:00:00', 60, 4, 4),
         ('2024-01-05', '12:00:00', 15, 5, 5),
         ('2024-01-06', '13:00:00', 30, 6, 6),
         ('2024-01-07', '14:00:00', 45, 7, 7),
         ('2024-01-08', '15:00:00', 60, 8, 8),
         ('2024-01-09', '16:00:00', 15, 9, 9),
         ('2024-01-10', '17:00:00', 30, 10, 10),
         ('2024-01-11', '08:00:00', 15, 1, 2),
         ('2024-01-12', '09:00:00', 30, 2, 3),
         ('2024-01-13', '10:00:00', 45, 3, 4),
         ('2024-01-14', '11:00:00', 60, 4, 5),
         ('2024-01-15', '12:00:00', 15, 5, 6),
         ('2024-01-16', '13:00:00', 30, 6, 7),
         ('2024-01-17', '14:00:00', 45, 7, 8),
         ('2024-01-18', '15:00:00', 60, 8, 9),
         ('2024-01-19', '16:00:00', 15, 9, 10),
         ('2024-01-20', '17:00:00', 30, 10, 1),
         ('2024-01-21', '08:00:00', 15, 1, 3),
         ('2024-01-22', '09:00:00', 30, 2, 4),
         ('2024-01-23', '10:00:00', 45, 3, 5),
         ('2024-01-24', '11:00:00', 60, 4, 6),
         ('2024-01-25', '12:00:00', 15, 5, 7),
         ('2024-01-26', '13:00:00', 30, 6, 8),
         ('2024-01-27', '14:00:00', 45, 7, 9),
         ('2024-01-28', '15:00:00', 60, 8, 10),
         ('2024-01-29', '16:00:00', 15, 9, 1),
         ('2024-01-30', '17:00:00', 30, 10, 2),
         ('2024-01-31', '08:00:00', 15, 1, 4),
         ('2024-02-01', '09:00:00', 30, 2, 5),
         ('2024-02-02', '10:00:00', 45, 3, 6),
         ('2024-02-03', '11:00:00', 60, 4, 7),
         ('2024-02-04', '12:00:00', 15, 5, 8),
         ('2024-02-05', '13:00:00', 30, 6, 9),
         ('2024-02-06', '14:00:00', 45, 7, 10),
         ('2024-02-07', '15:00:00', 60, 8, 1),
         ('2024-02-08', '16:00:00', 15, 9, 2),
         ('2024-02-09', '17:00:00', 30, 10, 3),
         ('2024-02-10', '08:00:00', 15, 1, 5),
         ('2024-02-11', '09:00:00', 30, 2, 6),
         ('2024-02-12', '10:00:00', 45, 3, 7),
         ('2024-02-13', '11:00:00', 60, 4, 8),
         ('2024-02-14', '12:00:00', 15, 5, 9),
         ('2024-02-15', '13:00:00', 30, 6, 10),
         ('2024-02-16', '14:00:00', 45, 7, 1),
         ('2024-02-17', '15:00:00', 60, 8, 2),
         ('2024-02-18', '16:00:00', 15, 9, 3),
         ('2024-02-19', '17:00:00', 30, 10, 4);

