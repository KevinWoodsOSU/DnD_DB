DROP TABLE IF EXISTS dnd_character_skill;
DROP TABLE IF EXISTS dnd_character_feat;
DROP TABLE IF EXISTS dnd_character_weapon;
DROP TABLE IF EXISTS dnd_weapon;
DROP TABLE IF EXISTS dnd_feat;
DROP TABLE IF EXISTS dnd_skill;
DROP TABLE IF EXISTS dnd_character;
DROP TABLE IF EXISTS dnd_race;
DROP TABLE IF EXISTS dnd_class;

CREATE TABLE dnd_race (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL UNIQUE KEY
	) ENGINE=InnoDB;

CREATE TABLE dnd_class (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL UNIQUE KEY
	) ENGINE=InnoDB;


CREATE TABLE dnd_character (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL UNIQUE KEY,
	race int(11),
	class int(11),
	level int(11),
	strength int(11),
	dexterity int(11),
	constitution int(11),
	intelligence int(11),
	wisdom int(11),
	charisma int(11),
	HP int(11) NOT NULL,
	AC int(11),
	FOREIGN KEY (race) REFERENCES dnd_race (id)
		ON DELETE SET NULL
		ON UPDATE CASCADE,
	FOREIGN KEY (class) REFERENCES dnd_class (id)
		ON DELETE SET NULL
		ON UPDATE CASCADE
	) ENGINE=InnoDB;

CREATE TABLE dnd_skill (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL UNIQUE KEY,
	ability varchar(255)
	) ENGINE=InnoDB;

CREATE TABLE dnd_character_skill (
	character_id int(11) NOT NULL,
 	skill_id int(11) NOT NULL,
 	PRIMARY KEY (character_id, skill_id),
 	FOREIGN KEY (character_id) REFERENCES dnd_character (id)
 		ON UPDATE CASCADE
 		ON DELETE CASCADE,
 	FOREIGN KEY (skill_id) REFERENCES dnd_skill (id)
 		ON UPDATE CASCADE
 		ON DELETE CASCADE
 	) ENGINE=InnoDB;

CREATE TABLE dnd_feat (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL UNIQUE KEY,
	description text DEFAULT NULL,
	prerequisite text DEFAULT NULL
	) ENGINE=InnoDB;

CREATE TABLE dnd_character_feat (
	character_id int(11) NOT NULL,
	feat_id int(11) NOT NULL,
	PRIMARY KEY (character_id, feat_id),
	FOREIGN KEY (character_id) REFERENCES dnd_character (id)
		ON UPDATE CASCADE
 		ON DELETE CASCADE,
	FOREIGN KEY (feat_id) REFERENCES dnd_feat (id)
		ON UPDATE CASCADE
 		ON DELETE CASCADE
	) ENGINE=InnoDB;
	
CREATE TABLE dnd_weapon (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(255) NOT NULL UNIQUE KEY,
	damage varchar(255) NOT NULL,
	damage_type varchar(255) NOT NULL,
	weapon_type varchar(255) NOT NULL
	) ENGINE=InnoDB;
	
CREATE TABLE dnd_character_weapon (
	character_id int(11) NOT NULL,
	weapon_id int(11) NOT NULL,
	PRIMARY KEY (character_id, weapon_id),
	FOREIGN KEY (character_id) REFERENCES dnd_character (id)
		ON UPDATE CASCADE
 		ON DELETE CASCADE,
	FOREIGN KEY (weapon_id) REFERENCES dnd_weapon (id)
		ON UPDATE CASCADE
 		ON DELETE CASCADE
	) ENGINE=InnoDB;

