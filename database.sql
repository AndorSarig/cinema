CREATE TABLE `user` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL UNIQUE,
	`password` CHAR(64) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `movie` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` varchar(128) NOT NULL,
	`release_date` INT(4) NOT NULL,
	`img` varchar(256) NOT NULL,
	`description` varchar(5120) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `genre` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `movie_genre` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`movie_id` INT(11) NOT NULL,
	`genre_id` INT(11) NOT NULL,
	FOREIGN KEY (`movie_id`) REFERENCES `movie`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`genre_id`) REFERENCES `genre`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `room` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL UNIQUE,
	`capacity` INT(4) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `screening` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`movie_id` INT(11) NOT NULL,
	`room_id` INT(11) NOT NULL,
	`date` DATETIME(6) NOT NULL,
	FOREIGN KEY (`movie_id`) REFERENCES `movie`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`room_id`) REFERENCES `room`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `reservation` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`screening_id` INT NOT NULL,
	`seat_id` INT NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`screening_id`) REFERENCES `screening`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (`id`)
);
