create table user_inscribed (
	id_prueba int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	usuario VARCHAR(255) not null,
	id_curso int not null, 
	lastLesson VARCHAR(255),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);


create table user_evaluation (id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, id_course int not null, id_lesson int not null,  id_evaluation int not null, puntaje int not null, aprobado boolean, reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ;  



create table topic_forum (
	id_topic int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	creator_user VARCHAR(255) not null,
	id_course int not null, id_forum int not null,
	 title varchar(255) not null,
	 reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);

create table answer_topic (
	id_answer int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	creator_user VARCHAR(255) not null,
	id_topic int not null, 
	id_father int ,
	answer MEDIUMTEXT not null, 
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);


create table lesson_user_view (
	id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, 
	id_course int not null,  
	id_lesson int not null, 
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ;  

create table user_badges (id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, id_badge int not null, reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);  

create table user_stripe (id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, id_course int not null, id_transaction VARCHAR(255) not null, monto int not null,reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);  

create table user_paypal (id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, id_course int not null, id_transaction VARCHAR(255) not null, monto int not null,reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);  


create table user_certificate (id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, id_course int not null, id_certificate VARCHAR(255) not null, url VARCHAR(255) not null,reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);  


create table course_valoration (id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,user VARCHAR(255) not null,id_course int not null, puntaje int not null, reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);



INSERT INTO lesson_user_view (user,id_course,id_lesson) VALUES ("aquilesal",228,198);

INSERT INTO user_evaluation (user, id_lesson, id_course, id_evaluation, puntaje) VALUES ('aquilesal', '228','198','5','10');

UPDATE user_evaluation SET puntaje='87' WHERE user='aquilesal' and id_course='265' 
      and id_lesson='198' and id_evaluation='102';


INSERT INTO user_evaluation (user,id_course,id_lesson,id_evaluation,puntaje,aprobado) VALUES ("aquilesal",265,198,102,80,true);

INSERT INTO user_evaluation (user,id_course,id_lesson,id_evaluation,puntaje,aprobado) VALUES ("aquilesal",265,274,275,75,true);

INSERT INTO user_certificate (user,id_course,id_certificate,url) VALUES ("aquilesal",265,274,"url");

INSERT INTO user_inscribed (usuario,id_curso,lastLesson) VALUES ("aquilesal",266,274);

INSERT INTO course_valoration (user,id_course,puntaje) VALUES ("aquilesal",100,2);

select id_curso, count(id_curso) as total from user_inscribed group by id_curso order by total desc;


DELIMITER $$
CREATE TRIGGER validate_exist_user_evaluation
BEFORE INSERT ON user_evaluation
FOR EACH ROW
BEGIN
  IF (SELECT count(*) FROM user_evaluation WHERE user = NEW.user AND id_course = NEW.id_course AND id_lesson = NEW.id_lesson 
  	AND id_evaluation = NEW.id_evaluation) > 0 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You can not insert record';
  END IF ;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER validate_exist_lesson_user_view
BEFORE INSERT ON lesson_user_view
FOR EACH ROW
BEGIN
  IF (SELECT count(*) FROM lesson_user_view WHERE user = NEW.user AND id_course = NEW.id_course 
  	AND id_lesson = NEW.id_lesson) > 0 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You can not insert record';
  END IF ;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER validate_exist_user_certificate
BEFORE INSERT ON user_certificate
FOR EACH ROW
BEGIN
  IF (SELECT count(*) FROM user_certificate WHERE user = NEW.user AND id_course = NEW.id_course) > 0 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You can not insert record';
  END IF ;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER validate_only_one_time_valoration
BEFORE INSERT ON course_valoration
FOR EACH ROW
BEGIN
  IF (SELECT count(*) FROM course_valoration WHERE user = NEW.user AND id_course = NEW.id_course) > 0 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You can not insert record';
  END IF ;
END$$
DELIMITER ;


DROP TRIGGER validate_exist_user_evaluation;

DROP TRIGGER validate_exist_lesson_user_view;

DROP TRIGGER validate_only_one_time_valoration;

DROP Table user_evaluation;

DELETE FROM user_inscribed WHERE usuario="aquilesal";

"SELECT * FROM `user_evaluation` WHERE user='$user' and id_leccion='$idLesson' and id_evaluation='$idEvaluation'"

Credenciales para probar paypal
sb-hrsp31596553@personal.example.com
t>V?2c/K




ALTER TABLE user_evaluation
  ADD id_course int not null
    AFTER user;


UPDATE course_valoration SET puntaje='14',puntaje=true WHERE user='aquilesal' AND id_course='265';