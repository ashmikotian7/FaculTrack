CREATE DATABASE fac;

USE fac;

CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    facultyID VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL, -- Admin's birthdate (used for verification)
    department VARCHAR(100) NOT NULL,
    grade VARCHAR(50) NOT NULL,
    allowance INT NOT NULL,  -- Changed allowance to INT (for whole numbers like 2,000 or 5,000)
    total_score INT NOT NULL, -- New column to store total score
    drive_link VARCHAR(255) NOT NULL
);
