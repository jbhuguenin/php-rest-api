CREATE SCHEMA `rest_api` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

USE rest_api;

CREATE TABLE user (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE song (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  time INT NOT NULL,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE favorites (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  song_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (song_id) REFERENCES song(id)
);

INSERT INTO user (email, name) values ('john.doe@acme.com', 'John Doe');
INSERT INTO user (email, name) values ('daniel.marhely@deezer.com', 'Daniel Marhely');
INSERT INTO user (email, name) values ('jonathan.benassaya@deezer.com', 'Jonathan Benassaya');


INSERT INTO song (time, name) VALUES (180, 'sample 1');
INSERT INTO song (time, name) VALUES (300, 'sample 2');
INSERT INTO song (time, name) VALUES (240, 'sample 3');


INSERT INTO favorites (user_id, song_id) VALUES (1, 1);
INSERT INTO favorites (user_id, song_id) VALUES (2, 1);
INSERT INTO favorites (user_id, song_id) VALUES (2, 2);