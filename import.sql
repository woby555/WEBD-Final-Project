CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    hashed_password VARCHAR(255) NOT NULL,
    role ENUM('Administrator', 'User', 'Non-User') NOT NULL DEFAULT 'User'
);

CREATE TABLE Elements (
    element_id INT AUTO_INCREMENT PRIMARY KEY,
    element_name VARCHAR(50) NOT NULL
);

CREATE TABLE Weapons (
    weapon_id INT AUTO_INCREMENT PRIMARY KEY,
    weapon_name VARCHAR(50) NOT NULL
);

CREATE TABLE Armors (
    armor_id INT AUTO_INCREMENT PRIMARY KEY,
    armor_name VARCHAR(50) NOT NULL
);

CREATE TABLE Classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL
);

CREATE TABLE Skills (
    skill_id INT AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(50) NOT NULL,
    class_id INT NOT NULL,
    FOREIGN KEY (class_id) REFERENCES Classes(class_id)
);

CREATE TABLE Characters (
    character_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    character_name VARCHAR(20) NOT NULL,
    level INT DEFAULT 1 NOT NULL,
    date_created DATE, 
    class_id INT NOT NULL,
    weapon_id INT,
    element_id INT NOT NULL,
    UNIQUE (user_id),
    CONSTRAINT Level_Check CHECK (level >= 1 AND level <= 100), 
    FOREIGN KEY (user_id) REFERENCES Users (user_id),
    FOREIGN KEY (class_id) REFERENCES Classes (class_id),
    FOREIGN KEY (weapon_id) REFERENCES Weapons (weapon_id),
    FOREIGN KEY (element_id) REFERENCES Elements (element_id)
);

CREATE TABLE CharacterArmors (
    character_armor_id INT AUTO_INCREMENT PRIMARY KEY,
    character_id INT NOT NULL,
    armor_id INT NOT NULL,
    FOREIGN KEY (character_id) REFERENCES Characters (character_id),
    FOREIGN KEY (armor_id) REFERENCES Armors (armor_id)
);

-- Debug
DROP TABLE IF EXISTS CharacterArmors;
DROP TABLE IF EXISTS Characters;
DROP TABLE IF EXISTS Skills;
DROP TABLE IF EXISTS Armors;
DROP TABLE IF EXISTS Weapons;
DROP TABLE IF EXISTS Elements;
DROP TABLE IF EXISTS Classes;
DROP TABLE IF EXISTS Users;