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
   CONSTRAINT ch_role CHECK(role IN ('secretaire', 'administrateur', 'medecin', 'usager'))
);

INSERT INTO user_auth_v2(login, mdp, role)
VALUES('secretaire1', '$2y$08$EPJXk5LG41f1usT95xQyT.nZ5WGSd.rtn93ebWlKl4b3UqoykmpaW', 'secretaire'), # password1234!
      ('admin1', '$2y$08$EPJXk5LG41f1usT95xQyT.nZ5WGSd.rtn93ebWlKl4b3UqoykmpaW', 'administrateur'), # password1234!
      ('UMODUJE72', '$2y$08$g.I3si7EXhvcxF1Y5SZxYOMeGX1Plgj5lLxE4rJGDGU3N1BEXpGAm', 'usager'), # user1234!
      ('UMADUMA90', '$2y$08$M5XgCc2ZPyXHzAuM6Pa04eUcOa9n6GFddJDEWwXDMsbeBcyh1jble', 'usager'),
      ('UMAMASO96', '$2y$08$76farNwGzKMKCKk7WX8XlOppNYBdvrMwYtVvTcQ8z6EFprcqM1w0.', 'usager'),
      ('UMOLEPI05', '$2y$08$NE9GYl7mE6hpv.1NFflLIOUagEuWLJh3oUmzTr.HCex34dVl0nXjq', 'usager'),
      ('UMOLEJA70', '$2y$08$4PbfXt96mmnko5wSFhhyzOTOiwj7xFiHBust26LrhPaoN3vRjETEy', 'usager'),
      ('UMADAJE56', '$2y$08$hQf7D0E8M6Tv0oyjEiOWf.6x8Qd3t7ObT6e338tghGFetDmediS3C', 'usager'),
      ('UMOSIPA72', '$2y$08$O1QiVYDMHKWK38ItVM28Cu6Mj4yhczXrdhNeUsVzQGRxAfysAaiDa', 'usager'),
      ('UMAPIMA75', '$2y$08$vbvZCLIpAJyUxe30OTlTWe7ueg5./MZq8TSaEkmN6aSfeM38Tmj.m', 'usager'),
      ('UMOLERA70', '$2y$08$pypmXl9QPjOb6/clrVXlZOikPz9cjAtPf95HHUD7Mft1CISE/uGgC', 'usager'),
      ('UMADUMA12', '$2y$08$auNfT08L.F73JF1XrK7gDOibcmdZ25CnPeGKTrfH/TGiI590yoalK', 'usager'),
      ('MMODUXA84', '$2y$08$S8O6Z1CJsbrcB6yHouEZ4uc2QQlxpBL51MX.vmc2IwEIinNBAQj7C', 'medecin'), # med1234!
      ('MMADAJE56', '$2y$08$0Hfb9bIoFBoLc2TWiv274OmcgAOECbvXcHwDI.XhDj/QTq5xabxCK', 'medecin'),
      ('MMOSIPA72', '$2y$08$Ooe7LiQUimy0d.NHGpU.detUp0oYj9GInzwjOJ7X/jSxKkp/SJ5vq', 'medecin'),
      ('MMAPIMA75', '$2y$08$bipwPv1rtZOkD4GH2mBabOc/I1/5Dv7y.ofQ.5Fk8AOG1Nz1j5Qr.', 'medecin'),
      ('MMOHUGI52', '$2y$08$5GgOGsDKhnUiUpqvVKTn3OUFT2sjCC3VGbygZAGVE4Z0VmDx9ae3O', 'medecin'),
      ('MMAFASO75', '$2y$08$n0g.wFXSYAR.rycSkusIROh0QEQ/UpsVH8lb4izkDD.1OXIZ4rS4y', 'medecin'),
      ('MMOCUBU30', '$2y$08$gnfu4mZDwCp/EyhfCqb/6.XWB3WNKI68/OMP.pVFZ/yN7GzzlMw2i', 'medecin'),
      ('MMADEMO75', '$2y$08$yXU1oCRyA.7rk05JARXBVuPU8PkI8WDjMfl.UfRl7EAmnWhmbEtJK', 'medecin'),
      ('MMOOSJE84', '$2y$08$uf0cf3eXapcA8a9a79vWCuVLtNL0nfe9Wx6372J01dgpqN1erI2ru', 'medecin'),
      ('MMAMALO85', '$2y$08$o7NESjILEdmv7/SmeXrpMeUnmwLBIaVXqec3StOxtwptmPBq1LXBW', 'medecin');

