<!--

Andrew McCloud

September 14, 2023

Professor Voelcker

Module 8 Coding Assignment

-->

<?php
// Create a variable for the host of the database
$dbHost = 'localhost';

// Create a variable for the username in the database
$dbUsername = 'student1';

// Create a variable for the password of the account in the database
$dbPassword = 'pass';

// Create a variable for the database name in MySQL
$dbDatabase = 'baseball_01';

// Connect to the database with the variables created and assign it to a variable
// We can use this throughout the other files
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

// If there is a connection error
if($conn -> connect_error){

    // Exit the connection and display an error message
    die("Connection Failed: " . $conn->connect_error);

}

?>