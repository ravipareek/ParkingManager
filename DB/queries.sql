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
CONSTRAINT fk_user FOREIGN KEY (uid) REFERENCES user(uid)
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


INSERT INTO review(pid, uid, rating, description, title) values (13,1,5,"A wonderful parking spot","Great");
INSERT INTO review(pid, uid, rating, description, title) values (13,7,2,"A wonderful parking spot","Great");
INSERT INTO review(pid, uid, rating, description, title) values (14,8,1,"A wonderful parking spot","Great");
INSERT INTO review(pid, uid, rating, description, title) values (14,1,2,"A wonderful parking spot","Great");

--Search Query
select parkingSpot.pid from parkingSpot inner join review on parkingSpot.pid = review.pid where name like '%%' and price between $minPrice and $maxPrice and 111.111 * DEGREES(ACOS(LEAST(COS(RADIANS(latitude)) * COS(RADIANS($current_latitude)) * COS(RADIANS(longitude - ($current_longitude))) + SIN(RADIANS(latitude)) * SIN(RADIANS(latitude)), 1.0))) < $max_distance group by parkingSpot.pid having avg(review.rating) between $min_rating and $max_rating;

select parkingSpot.pid from parkingSpot inner join review on parkingSpot.pid = review.pid where name like '%stu%' and price between 2 and 7 and 111.111 * DEGREES(ACOS(LEAST(COS(RADIANS(latitude)) * COS(RADIANS(-3.44612)) * COS(RADIANS(longitude - (-66.4557))) + SIN(RADIANS(latitude)) * SIN(RADIANS(latitude)), 1.0))) < 100 group by parkingSpot.pid having avg(review.rating) between 0 and 5;



select avg(rating) from review where pid = $pid;