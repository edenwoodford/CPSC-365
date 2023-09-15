CREATE DATABASE movie_rater;
USE movie_rater;
CREATE TABLE Users (
user_id int NOT NULL AUTO_INCREMENT,
username VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
admin boolean,
PRIMARY KEY (user_id)
)engine=InnoDB;

CREATE TABLE Friends (
friend_id int NOT NULL AUTO_INCREMENT,
username1 VARCHAR(255) NOT NULL,
username2 VARCHAR(255) NOT NULL,
PRIMARY KEY (friend_id)
)engine=InnoDB;

CREATE TABLE FriendList (
friendList_id int NOT NULL AUTO_INCREMENT,
friend_id int,
user_id int,
PRIMARY KEY (friendList_id),
FOREIGN KEY (friend_id) REFERENCES Friends(friend_id),
FOREIGN KEY (user_id) REFERENCES Users(user_id)
)engine=InnoDB;

CREATE TABLE Genres (
genre_id int NOT NULL AUTO_INCREMENT,
genre VARCHAR(255) NOT NULL,
PRIMARY KEY (genre_id)
)engine=InnoDB;

CREATE TABLE Movies (
movie_id int NOT NULL AUTO_INCREMENT,
title VARCHAR(255) NOT NULL,
description text,
dateAdded datetime,
genre_id int,
FOREIGN KEY(genre_id) REFERENCES Genres(genre_id),
PRIMARY KEY (movie_id)
)engine=InnoDB;

CREATE TABLE GenreCombos (
movie_id int,
genre_id int,
FOREIGN KEY (movie_id) REFERENCES Movies(movie_id),
FOREIGN KEY (genre_id) REFERENCES Genres(genre_id),
PRIMARY KEY (movie_id, genre_id)
)engine=InnoDB;

CREATE TABLE Ratings (
rating_id int NOT NULL AUTO_INCREMENT,
score int,
user_id int,
movie_id int,
averageRating float,
FOREIGN KEY (user_id) REFERENCES Users(user_id),
FOREIGN KEY (movie_id) REFERENCES Movies(movie_id),
PRIMARY KEY (rating_id)
)engine=InnoDB;

CREATE TABLE Comments (
comment_id int NOT NULL AUTO_INCREMENT,
comments VARCHAR(255) NOT NULL,
movie_id int,
user_id int,
FOREIGN KEY (movie_id) REFERENCES Movies(movie_id),
FOREIGN KEY (user_id) REFERENCES Users(user_id),
PRIMARY KEY (comment_id)
)engine=InnoDB;

SHOW TABLES;