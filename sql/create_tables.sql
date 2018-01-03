CREATE TABLE Person(
    id SERIAL PRIMARY KEY,
    username varchar(30) NOT NULL,
    password varchar(50) NOT NULL
);

CREATE TABLE Category(
    id SERIAL PRIMARY KEY,
    name varchar(30) NOT NULL
);

CREATE TABLE Task(
    id SERIAL PRIMARY KEY,
    categoryid integer REFERENCES Category(id),
    name varchar(30) NOT NULL,
    description varchar(90),
    deadline date
);


CREATE TABLE PersonTask(
    taskid integer REFERENCES Task(id),
    personid integer REFERENCES Person(id)
);