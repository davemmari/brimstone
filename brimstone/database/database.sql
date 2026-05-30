CREATE DATABASE IF NOT EXISTS rpg_game;
USE rpg_game;

CREATE TABLE IF NOT EXISTS heroes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    role VARCHAR(20) NOT NULL,
    hp INT NOT NULL,
    max_hp INT NOT NULL,
    atk INT NOT NULL,
    spd INT NOT NULL,
    def INT NOT NULL,
    gold INT DEFAULT 0
);