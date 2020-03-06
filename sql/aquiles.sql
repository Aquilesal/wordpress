create table topic_forum (
    id_topic int UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    creator_user VARCHAR(255) not null,
	id_course int not null, 
    id_forum int not null, 
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