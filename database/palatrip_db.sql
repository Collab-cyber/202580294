-- PalaTrip database (MySQL / MariaDB)
-- Import via phpMyAdmin (Import tab) or: mysql -u root < database/palatrip_db.sql

SET NAMES utf8mb4;

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

-- Palawan destinations shown on the Home page search and in the Add a Trip dropdown.
-- activities = comma-separated list. featured = 1 for the "Popular Destinations" cards.
-- sort_order controls the display order (lower comes first).
CREATE TABLE IF NOT EXISTS destinations (
    id          VARCHAR(50)  NOT NULL PRIMARY KEY,
    name        VARCHAR(100) NOT NULL UNIQUE,
    area        VARCHAR(150) NOT NULL,
    category    VARCHAR(50)  NOT NULL,
    emoji       VARCHAR(16)  NOT NULL DEFAULT '',
    image       VARCHAR(255) NOT NULL DEFAULT '',
    description TEXT         NOT NULL,
    activities  VARCHAR(255) NOT NULL,
    keywords    VARCHAR(255) NOT NULL DEFAULT '',
    featured    TINYINT(1)   NOT NULL DEFAULT 0,
    sort_order  INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Starting data. If a row already exists, it is not duplicated; only an
-- empty image is filled in (an image you already set is kept).
INSERT INTO destinations
    (id, name, area, category, emoji, image, description, activities, keywords, featured, sort_order)
VALUES
    ('el-nido', 'El Nido', 'Northern Palawan', 'Islands', '🏝️', 'images/el-nido.jpg', 'Known for its beautiful lagoons, beaches, limestone cliffs, and island-hopping activities.', 'Island hopping, Kayaking, Snorkeling', 'bacuit bay lagoon cliffs', 1, 10),
    ('coron', 'Coron', 'Busuanga Island, Palawan', 'Diving', '🌊', 'images/coron.jpg', 'A popular destination known for its clear waters, islands, lagoons, and diving spots.', 'Wreck diving, Island hopping, Snorkeling', 'busuanga shipwreck lagoon', 1, 20),
    ('puerto-princesa', 'Puerto Princesa', 'Puerto Princesa, Palawan', 'Nature', '🌴', 'images/puerto-princesa.jpg', 'The capital city of Palawan and home to the famous Underground River.', 'Underground River tour, City tour, Firefly watching', 'underground river sabang capital city', 1, 30),
    ('port-barton', 'Port Barton', 'San Vicente, Palawan', 'Beaches', '🏖️', 'images/port-barton.jpg', 'A quiet, laid-back beach town with calm bays, little islands and great snorkeling spots.', 'Island hopping, Snorkeling, Beach time', 'san vicente quiet relaxing', 0, 40),
    ('nacpan-beach', 'Nacpan Beach', 'El Nido, Palawan', 'Beaches', '🌅', 'images/nacpan-beach.jpg', 'A long stretch of golden sand with clear water, well known for its sunsets.', 'Swimming, Sunset watching, Beach walks', 'twin beach calitang sunset', 0, 50),
    ('honda-bay', 'Honda Bay', 'Puerto Princesa, Palawan', 'Islands', '⛵', 'images/honda-bay.jpg', 'A group of small islands and sandbars reached by boat, a favorite day trip from the city.', 'Island hopping, Snorkeling, Swimming', 'starfish island luli island pandan', 0, 60),
    ('kayangan-lake', 'Kayangan Lake', 'Coron, Palawan', 'Nature', '💧', 'images/kayangan-lake.jpg', 'A crystal-clear lake surrounded by limestone cliffs, often called one of the cleanest lakes in Asia.', 'Swimming, Hiking viewpoint, Photography', 'coron lake limestone', 0, 70),
    ('twin-lagoon', 'Twin Lagoon', 'Coron, Palawan', 'Nature', '🛶', 'images/twin-lagoon.jpg', 'Two lagoons separated by a rock wall, where cool and warm water layers meet.', 'Swimming, Kayaking, Snorkeling', 'coron lagoon kayak', 0, 80),
    ('calauit-safari-park', 'Calauit Safari Park', 'Busuanga Island, Palawan', 'Nature', '🦒', 'images/calauit-safari-park.jpg', 'A wildlife sanctuary where giraffes, zebras and other animals roam freely.', 'Safari tour, Wildlife watching, Photography', 'busuanga giraffe zebra animals wildlife', 0, 90),
    ('tubbataha-reefs', 'Tubbataha Reefs', 'Sulu Sea, Cagayancillo, Palawan', 'Diving', '🐠', 'images/tubbataha-reefs.jpg', 'A UNESCO World Heritage marine park with rich coral reefs, reachable by liveaboard dive trips in the diving season.', 'Scuba diving, Liveaboard trips, Marine life watching', 'unesco coral reef marine park cagayancillo', 0, 100),
    ('balabac', 'Balabac', 'Southern Palawan', 'Islands', '🦌', 'images/balabac.jpg', 'A remote island group at the southern tip of Palawan with white sandbars and the Philippine mouse-deer.', 'Island hopping, Sandbar visits, Wildlife watching', 'sandbar mouse deer remote south onuk', 0, 110),
    ('apulit-island', 'Apulit Island', 'Taytay, Palawan', 'Islands', '🏝️', 'images/apulit-island.jpg', 'A private-feeling island with white beaches and clear water in the Linapacan Strait.', 'Swimming, Snorkeling, Relaxing', 'taytay resort beach', 0, 120),
    ('taytay', 'Taytay (Fort Santa Isabel)', 'Taytay, Palawan', 'History', '🏰', 'images/taytay.jpg', 'Home to a Spanish-era fort overlooking the bay, one of the oldest historic sites in the province.', 'Heritage visit, Sightseeing, Photography', 'fort spanish historic heritage church', 0, 130),
    ('ugong-rock', 'Ugong Rock', 'Puerto Princesa, Palawan', 'Nature', '🧗', 'images/ugong-rock.jpg', 'A limestone rock formation with a cave you can climb through, plus a zipline for the adventurous.', 'Cave climbing, Zipline, Hiking', 'cave climb zipline adventure', 0, 140),
    ('tabon-caves', 'Tabon Caves', 'Quezon, Palawan', 'History', '🗿', 'images/tabon-caves.jpg', 'An archaeological site where some of the oldest human remains in the Philippines were found.', 'Cave exploring, Museum visit, Guided tour', 'archaeological cave tabon man quezon museum', 0, 150),
    ('cuyo-islands', 'Cuyo Islands', 'Northern Palawan, Sulu Sea', 'History', '⛪', 'images/cuyo-islands.jpg', 'A far-off island group with white beaches and a centuries-old Spanish fort and church.', 'Beach hopping, Heritage visit, Island life', 'cuyo fort church beach remote', 0, 160)
ON DUPLICATE KEY UPDATE image = IF(image = '', VALUES(image), image);
