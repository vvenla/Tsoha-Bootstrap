CREATE TABLE Person(
    id SERIAL PRIMARY KEY,
    username varchar(30) NOT NULL,
    password varchar(50) NOT NULL
);

CREATE TABLE Category(
    id SERIAL PRIMARY KEY,
    personid integer REFERENCES Person(id),
    name varchar(30) NOT NULL
);

CREATE TABLE Task(
    id SERIAL PRIMARY KEY,
    name varchar(30) NOT NULL,
    description varchar(90),
    deadline date
);

CREATE TABLE PersonTaskCategory(
    taskid integer REFERENCES Task(id) ON DELETE CASCADE,
    personid integer REFERENCES Person(id) ON DELETE CASCADE,
    categoryid integer REFERENCES Category(id) ON DELETE CASCADE,
    PRIMARY KEY (taskid, personid)
);