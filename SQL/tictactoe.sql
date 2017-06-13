CREATE DATABASE tictactoe;

USE tictactoe;

CREATE TABLE Users(
	Username VARCHAR(50),
    Passwort VARCHAR(50),
    PRIMARY KEY(Username)
    );
    

CREATE TABLE Highscore(
	Ranking INT,
    Username VARCHAR(50),
    Message VARCHAR(100),
    Wins INT,
    Draws INT,
    Losses INT,
    PRIMARY KEY(Platzierung),
    FOREIGN KEY (Username) REFERENCES Users(Username)
    );
	