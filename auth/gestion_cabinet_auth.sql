-- Active: 1707474650741@@localhost@3306@db_gestion_cabinet_auth
CREATE OR REPLACE USER 'local_user'@'localhost' IDENTIFIED BY 'password';

DROP DATABASE IF EXISTS db_gestion_cabinet_auth;
create database db_gestion_cabinet_auth;

grant all privileges on db_gestion_cabinet_auth.* TO 'local_user'@'localhost' identified by 'password';

USE db_gestion_cabinet_auth;


CREATE TABLE user_auth_v2(
   id_auth INT AUTO_INCREMENT NOT NULL,
   login VARCHAR(50) NOT NULL,
   mdp VARCHAR(100) NOT NULL,
   role VARCHAR(50) NOT NULL,
   PRIMARY KEY(login),
   UNIQUE(id_auth),
   CONSTRAINT ch_role CHECK(role IN ('secretaire', 'medecin', 'usager'))
);

INSERT INTO user_auth_v2(login, mdp, role)
VALUES('secretaire1', '$2y$08$EPJXk5LG41f1usT95xQyT.nZ5WGSd.rtn93ebWlKl4b3UqoykmpaW', 'secretaire'),
         ('medecin', '$2y$08$.YH/iH.3QmefKdaDCvj/VuV7UFx/HQBkNRfKpAPGWDM2YtwgGeH4W', 'medecin'),
         ('admin', '$2y$08$DeSNMhna8Un5l00J6UpYbued5keF4cRRnKo5XPEwQw5cJXELDmGn6', 'usager');
