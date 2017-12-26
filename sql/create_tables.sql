CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    tunnus varchar(30) NOT NULL,
    salasana varchar(50) NOT NULL
);

CREATE TABLE Tarkeys(
    id SERIAL PRIMARY KEY,
    aste integer
);

CREATE TABLE Luokka(
    id SERIAL PRIMARY KEY,
    tarkeysId integer REFERENCES Tarkeys(id),
    nimi varchar(30) NOT NULL
);

CREATE TABLE Tehtava(
    id SERIAL PRIMARY KEY,
    tarkeysId integer REFERENCES Tarkeys(id),
    nimi varchar(30) NOT NULL,
    luotu date,
    status varchar(20),
    deadline date,
    huomioita varchar(90)
);

CREATE TABLE TehtavaLuokka(
    tehtavaId integer REFERENCES Tehtava(id),
    luokkaId integer REFERENCES Luokka(id)
);