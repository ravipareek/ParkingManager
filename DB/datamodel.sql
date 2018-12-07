USE comp4ww3;

CREATE TABLE user(
uid SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL,
password varchar(255) NOT NULL,
email varchar(255) NOT NULL,
driver bool not null,
owner bool NOT NULL,
CONSTRAINT pk_user PRIMARY KEY (uid, email)
);

CREATE TABLE parkingSpot(
pid SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
uid SMALLINT UNSIGNED NOT NULL,
name varchar(255) NOT NULL,
description varchar(500) NOT NULL,
latitude float  not null,
longitude float not null,
price float not null,
type varchar(255) NOT NULL,
photo varchar(255) NOT null,
video varchar(255),
CONSTRAINT pk_spot PRIMARY KEY (pid),
FOREIGN KEY (uid) REFERENCES user(uid)
);

CREATE TABLE review(
rid SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
pid SMALLINT UNSIGNED NOT NULL,
uid SMALLINT UNSIGNED NOT NULL,
rating SMALLINT NOT NULL,
description varchar(500) not null,
title varchar(255) not null,
CONSTRAINT pk_review PRIMARY KEY (rid),
FOREIGN KEY (pid) REFERENCES parkingSpot(pid),
FOREIGN KEY (uid) REFERENCES user(uid)
);