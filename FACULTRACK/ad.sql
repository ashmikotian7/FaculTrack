-- Create the database
CREATE DATABASE admin;

-- Use the database
USE admin;

-- Create the 'admin' table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for each admin
    adminID VARCHAR(50) NOT NULL UNIQUE,     -- Unique admin ID
    name VARCHAR(100) NOT NULL,              -- Admin's full name
    email VARCHAR(100) NOT NULL UNIQUE,      -- Admin's email address
    password VARCHAR(255) NOT NULL,          -- Hashed password
    birthdate DATE NOT NULL         -- Admin's birthdate (used for verification)          
);
