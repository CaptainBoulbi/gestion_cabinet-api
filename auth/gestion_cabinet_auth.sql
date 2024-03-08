-- Active: 1706110255136@@127.0.0.1@3306
CREATE OR REPLACE USER 'local_user'@'localhost' IDENTIFIED BY 'password';

DROP DATABASE IF EXISTS db_gestion_cabinet_auth;
create database db_gestion_cabinet_auth;

USE db_gestion_cabinet_auth;


CREATE TABLE user_auth_v2(
   id_auth INT AUTO_INCREMENT NOT NULL,
   login VARCHAR(50) NOT NULL,
   mdp VARCHAR(50) NOT NULL,
   role VARCHAR(50) NOT NULL,
   PRIMARY KEY(login),
   UNIQUE(id_auth),
   CONSTRAINT ch_role CHECK(role IN ('secretaire', 'medecin', 'usager'))
);

INSERT INTO user_auth_v2(login, mdp, role)
VALUES('secretaire1', 'password1234!', 'secretaire'),
         ('medecin', 'password1234!', 'medecin'),
         ('admin', 'password1234!', 'usager');
