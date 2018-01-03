INSERT INTO Person (username, password) VALUES ('testi', 'salasana'), ('testi2', 'salasana2');

INSERT INTO Category (name) VALUES ('Kotihommat'), ('Kouluhommat');

INSERT INTO Task (categoryid, name, description) VALUES (1, 'Pese uuni', 'Osta pesuainetta!');
INSERT INTO Task (categoryid, name, deadline) VALUES (2, 'Tentti', '2018-01-10');
INSERT INTO Task (categoryid, name, description, deadline) VALUES (2, 'Tsoha', 'Projektityön loppupalautus', '2018-01-23');
INSERT INTO PersonTask (taskid, personid) VALUES (1, 1), (2, 1), (1, 2);