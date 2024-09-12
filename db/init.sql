-- Создание базы данных kotiks, если она не существует
CREATE DATABASE IF NOT EXISTS kotiks;
USE kotiks;

-- Таблица кошек
CREATE TABLE cats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    age INT NOT NULL
);

-- Таблица котят
CREATE TABLE kittens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    age INT NOT NULL,
    mother_id INT DEFAULT NULL,
    FOREIGN KEY (mother_id) REFERENCES cats(id) ON DELETE SET NULL
);

-- Таблица для связывания котят с их отцами
CREATE TABLE kitten_fathers (
    kitten_id INT,
    father_id INT,
    FOREIGN KEY (kitten_id) REFERENCES kittens(id) ON DELETE CASCADE,
    FOREIGN KEY (father_id) REFERENCES cats(id) ON DELETE CASCADE,
    PRIMARY KEY(kitten_id, father_id)
);