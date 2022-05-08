CREATE TABLE `users` ( 
    `userID` INT NOT NULL AUTO_INCREMENT, 
    `username` VARCHAR(255) NOT NULL UNIQUE, 
    `email` VARCHAR(255) NOT NULL UNIQUE, 
    `password` VARCHAR(255) NOT NULL , 
    `profilePic` MEDIUMBLOB, PRIMARY KEY (`userID`)
) ENGINE = InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `threads` (
    `threadID` INT NOT NULL AUTO_INCREMENT, 
    `userID` INT NOT NULL, 
    `author` VARCHAR(255) NOT NULL, 
    `title` VARCHAR(255) NOT NULL, 
    `body` MEDIUMTEXT NOT NULL,
    PRIMARY KEY (`threadID`)
) ENGINE = InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `comments` (
    `commentID` INT NOT NULL AUTO_INCREMENT,
    `threadID` INT NOT NULL,
    `author` VARCHAR(255) NOT NULL,
    `body` MEDIUMTEXT NOT NULL,
    PRIMARY KEY (`commentID`),
    FOREIGN KEY (`threadID`) REFERENCES threads(`threadID`) 
) ENGINE = InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE threads
ADD FOREIGN KEY (`userID`) REFERENCES users(`userID`);

ALTER TABLE project.`threads` ADD time DATETIME;

ALTER TABLE project.`comments` ADD time DATETIME;