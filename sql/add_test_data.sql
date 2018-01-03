INSERT INTO Kayttaja (tunnus, salasana) VALUES ('Venla', 'salasana');
INSERT INTO Luokka (nimi) VALUES ('Kotihommat');
INSERT INTO Luokka (nimi) VALUES ('Kouluhommat');
INSERT INTO Tehtava (luokkaId, nimi, kuvaus) VALUES (1, 'Pese uuni', 'Osta pesuainetta!');
INSERT INTO Tehtava (luokkaId, nimi, kuvaus, deadline) VALUES (2, 'Tentti', 'Toderi 1 tentti', '2018-01-10');
INSERT INTO Tehtava (luokkaId, nimi, kuvaus, deadline) VALUES ('Tsoha', 'Projektityön loppupalautus', '2018-01-23');