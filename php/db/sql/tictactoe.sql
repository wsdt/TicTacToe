CREATE DATABASE tictactoe;

USE tictactoe;

CREATE TABLE Users(
	Username VARCHAR(50),
    Passwort VARCHAR(50),
    PRIMARY KEY(Username)
    );
    

CREATE TABLE Highscore(
	  /*Ranking INT, auskommentiert, da sonst zus. Aufwand beim Reinspeichern*/
    Username VARCHAR(50),
    Message VARCHAR(100),
    Wins INT,
    Draws INT,
    Losses INT,
    PRIMARY KEY(Username), /* Da Username ohnehin nur einmal vorkommen darf */
    FOREIGN KEY (Username) REFERENCES Users(Username)
    );
	