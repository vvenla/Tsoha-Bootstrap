INSERT INTO Person (username, password) VALUES ('Testikäyttäjä1', 'salasana1'), ('Testikäyttäjä2', 'salasana2'), ('Testikäyttäjä3', 'salasana3');

INSERT INTO Category (personid, name) VALUES (1, 'Tsoha'), (1, 'Kouluhommat');

INSERT INTO Task (name, description) VALUES ('Dokumentaatio', 'Asennusohje ym');
INSERT INTO Task (name, deadline) VALUES ('Tentti', '2018-01-10');
INSERT INTO Task (name, description) VALUES ('Ulkonäkö', 'Muokkaa taulukoiden leveyttä ym');
INSERT INTO Task (name, description, deadline) VALUES ('Tsoha', 'Projektityön loppupalautus', '2018-01-23');

INSERT INTO PersonTaskCategory (taskid, personid, categoryid) VALUES (1, 1, 1), (2, 1, 2), (3, 1, 2), (4, 1, 2);