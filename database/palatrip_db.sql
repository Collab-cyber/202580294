-- PalaTrip database (MySQL / MariaDB)
-- Import via phpMyAdmin (Import tab) or: mysql -u root < database/palatrip_db.sql

CREATE DATABASE IF NOT EXISTS palatrip_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE palatrip_db;

CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Make sure an older users table matches what the trips foreign key needs
-- (InnoDB engine + INT UNSIGNED id). Safe to run even if it already matches.
ALTER TABLE users ENGINE=InnoDB;
ALTER TABLE users MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT;

-- Each row is one trip in a user's travel history.
-- Deleting a user also deletes their trips (ON DELETE CASCADE).
CREATE TABLE IF NOT EXISTS trips (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    destination VARCHAR(100) NOT NULL,
    activity    VARCHAR(100) NOT NULL,
    trip_date   DATE         NOT NULL,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_trips_user (user_id),
    CONSTRAINT fk_trips_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
