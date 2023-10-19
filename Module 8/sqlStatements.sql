/* 

Andrew McCloud

September 14, 2023

Professor Voelcker

Module 8 Coding Assignment

*/

/* 

My SQL statements used in the files

These are included ONLY for the professor to have clarification on what SQL statements I used

*/

CREATE DATABASE baseball_01;

CREATE TABLE golfers (
    firstName VARCHAR(70),
    lastName VARCHAR(70),
    age INT,
    birthCountry VARCHAR(100),
    dateOfBirth DATE
);

DROP TABLE IF EXISTS golfers;

INSERT INTO golfers VALUES 

    ('Jordan', 'Spieth', 30, 'Unites States', '1993-07-27'),
    ('Rory', 'Mcllroy', 34, 'United Kingdom', '1989-05-04'),
    ('Cameron', 'Smith', 30, 'Australia', '1993-08-18');

