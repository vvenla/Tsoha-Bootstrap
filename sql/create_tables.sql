CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    tunnus varchar(30) NOT NULL,
    salasana varchar(50) NOT NULL
);

CREATE TABLE Luokka(
    id SERIAL PRIMARY KEY,
    nimi varchar(30) NOT NULL
);

CREATE TABLE Tehtava(
    id SERIAL PRIMARY KEY,
    luokkaId integer REFERENCES Luokka(id),
    nimi varchar(30) NOT NULL,
    kuvaus varchar(90),
    deadline date
);


CREATE TABLE KayttajaTehtava(
    tehtavaId integer REFERENCES Tehtava(id),
    kayttajaId integer REFERENCES Kayttaja(id)
);