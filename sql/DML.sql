create table user_inscribed (
	id_prueba int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	usuario VARCHAR(255) not null,
	id_curso int not null, 
	lastLesson VARCHAR(255),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);


create table user_evaluation (
	id int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	user VARCHAR(255) not null, 
	id_lesson int not null,  
	id_evaluation int not null, 
	puntaje int not null, 
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ;  


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



INSERT INTO user_evaluation (user,id_lesson,id_evaluation,puntaje) VALUES ("aquilesal2",198,102,3);


DELIMITER $$
CREATE TRIGGER validate_exist_user_evaluation
BEFORE INSERT ON user_evaluation
FOR EACH ROW
BEGIN
  IF (SELECT count(*) FROM user_evaluation WHERE user = NEW.user AND id_lesson = NEW.id_lesson 
  	AND id_evaluation = NEW.id_evaluation) > 0 THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You can not insert record';
  END IF ;
END$$
DELIMITER ;

DROP TRIGGER validate_exist_user_evaluation;

DROP Table user_evaluation;

"SELECT * FROM `user_evaluation` WHERE user='$user' and id_leccion='$idLesson' and id_evaluation='$idEvaluation'"


