CREATE DataBase IF NOT EXISTS apec_last;
USE apec_last;

CREATE TABLE users(id int auto_increment primary key , firstName  varchar(40) not null 
, lastName  varchar(40) not null , pwd text(255) not null , phone int(11) unique not null , 
country varchar(20) not null);


CREATE TABLE education(uni varchar(50) not null , faculty varchar(50) not null , 
department varchar(30) null , year varchar(10) not null , 
grade varchar(10) not null , is_garduated bool not null default 0 );


CREATE TABLE skill (id int primary key auto_increment , certificte varchar(50) not null);

CREATE TABLE courses(id int primary key auto_increment ,  certificate varchar(50) not null 
, c_from varchar(30) not null , year int(4) not null , month varchar(9) not null);

CREATE TABLE activities(id int auto_increment primary key , activity varchar(20) not null ,

job_desc text(100) not null , year int(4) not null , position varchar(20) not null default 'member');

CREATE TABLE trainning (id int auto_increment primary key , certificte varchar(50) not null , description text(100) not null ,
year int(4) not null );

CREATE TABLE about(bio text(150) not null , lives_in varchar(30) not null); 


--! DataBase Relation ..


alter table about  add column   id int primary key auto_increment after bio;

alter table education  add column   id int primary key auto_increment after uni;

ALTER TABLE activities add column activity_user int not null, add constraint foreign key (activity_user) references 
users (id);

ALTER TABLE skill  add column s_data int not null, add constraint foreign key (s_data) references 
users (id);

ALTER TABLE education  add column e_data int not null, add constraint foreign key (e_data) references 
users (id);

ALTER TABLE courses  add column c_data int not null, add constraint foreign key (c_data) references 
users (id);

alter table users add column image text(200) null;

ALTER TABLE trainning  add column t_data int not null, add constraint foreign key (t_data) references 
users (id);

ALTER TABLE about  add column about int not null, add constraint foreign key (about) references 
users (id);




--! Stored Procedure ..
--! Education Section .. 
DELIMITER $$
CREATE procedure education_user_data (id int)
BEGIN
SELECT users.id , uni , faculty , department , year , grade , is_garduated , e_data FROM education 
left JOIN  users on education.e_data = users.id 
WHERE users.id = id AND e_data = id;
END $$
DELIMITER ;

-- *****

DELIMITER $$
CREATE procedure replace_user_education (id_user int, uni_n varchar(50) , faculty_n varchar(50), department_n varchar(30) , 
year_n varchar(10) , grade_n varchar(20) , is_garduated_n bool)
BEGIN
DECLARE edu_id int;
DECLARE u_id int;

SET u_id = id_user;

SELECT education.id  INTO edu_id FROM education LEFT JOIN users ON education.e_data = users.id 
WHERE users.id = id_user AND e_data = id_user;

REPLACE INTO education (id , uni , faculty , department , year , grade , is_garduated , e_data) values (edu_id , uni_n , faculty_n , 
department_n , year_n , grade_n , is_garduated_n , u_id);

END $$
DELIMITER ;

--! About Section .. 

DELIMITER $$
CREATE procedure about_user_data (id int)
BEGIN
SELECT users.id , bio , lives_in , about.about FROM about 
left JOIN  users on about.about = users.id 
WHERE users.id = id AND about.about = id;
END $$
DELIMITER ;

-- *****
DELIMITER $$
CREATE procedure replace_user_about (id_user int , bio_n text(150) , lives_in_n varchar(30))
BEGIN
DECLARE about_id int;
DECLARE u_id int;

SET u_id = id_user;

SELECT about.id  INTO about_id FROM about LEFT JOIN users ON about.about = users.id 
WHERE users.id = id_user AND about.about = id_user;

REPLACE INTO about (id , bio , lives_in ,about) values (about_id , bio_n ,  lives_in_n, u_id);

END $$
DELIMITER ;

--! Skill Section ..

DELIMITER $$
CREATE PROCEDURE add_skill(id int , cert varchar(50))
BEGIN 
INSERT INTO skill (s_data , certificte) VALUES (id , cert);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE skill_user_data(id int)
BEGIN 

DECLARE u_id int ;
SET u_id = id;

SELECT  skill.id AS skill_id, certificte FROM skill LEFT JOIN users ON skill.s_data = users.id
WHERE users.id = u_id AND s_data = u_id;
END $$
DELIMITER ;

DELIMITER $$
CREATE procedure delete_user_skill (cert_id int)
BEGIN 
DELETE FROM skill WHERE skill.id = cert_id;
END $$
DELIMITER ;

--! Course Section ..
DELIMITER $$
CREATE procedure add_course(id int , cert varchar(50) , c_from_a varchar(30) , 
year_n  int(4) , month_n varchar(9))
BEGIN 

INSERT INTO courses (c_data , certificate , c_from , year , month) VALUES ( id , cert , c_from_a , year_n , month_n);

END $$
DELIMITER ;



DELIMITER $$
CREATE procedure course_user_data(u_id int)
BEGIN 

SELECT courses.id AS courses_id ,certificate , c_from , year , month from courses LEFT JOIN users
ON courses.c_data = users.id 
WHERE users.id = u_id AND courses.c_data = u_id;

END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE delete_user_course(c_id int)
BEGIN 

DELETE FROM courses WHERE courses.id = c_id;

END $$

DELIMITER ;


--! Tranning Section ..

DELIMITER $$
CREATE PROCEDURE add_trainning(id int , cert varchar(50) , decs_n text(100) , year_n int (4))

BEGIN 

INSERT INTO trainning (t_data , certificte , description , year) VALUES (id , cert , decs_n , year_n);

END $$
DELIMITER ;

DELIMITER $$
CREATE procedure trainning_user_data(u_id int )
BEGIN 

SELECT trainning.id AS train_id , certificte , description , year FROM trainning 
LEFT JOIN users ON trainning.t_data = users.id
WHERE users.id = u_id AND trainning.t_data = u_id; 

END $$
DELIMITER ;


DELIMITER $$
CREATE procedure delete_user_trainning(t_id int)

BEGIN 

DELETE FROM trainning WHERE trainning.id = t_id;

END $$
DELIMITER ;

--! Activity Section ..
DELIMITER $$

CREATE procedure add_activity(id int , activity_n varchar(20) , job_des_n text(100) , 
year_n int(4) , position_n varchar(20) null)

BEGIN 

INSERT INTO activities ( activity_user , activity , job_desc , year , position) VALUES (id , activity_n , 
job_des_n , year_n , position_n);

END $$
DELIMITER ;

DELIMITER $$

CREATE procedure activity_user_data(u_id int)
BEGIN 

SELECT activities.id AS act_id , job_desc , year , position FROM activities 
LEFT JOIN users ON activities.activity_user = users.id
WHERE users.id = u_id AND activities.activity_user = u_id;

END $$
DELIMITER ;



DELIMITER $$
CREATE procedure delete_user_activity(a_id int)

BEGIN 

DELETE FROM activities WHERE activities.id = a_id;

END $$
DELIMITER ;