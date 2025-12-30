CREATE DATABASE pokemon_wordle
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE pokemon_wordle;

CREATE TABLE pokemon (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    type1 VARCHAR(20) NOT NULL,
    type2 VARCHAR(20) DEFAULT NULL,
    generation INT NOT NULL,
    height FLOAT NOT NULL,
    weight FLOAT NOT NULL
);