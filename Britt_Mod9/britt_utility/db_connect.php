<?php
/*
db_connect.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Contains function used to establish or establishing a databse connection 
Contains database connection parameters and creates a mysqli connection. 
The function returns the connection object if the connection is successful, 
and it throws an Exception with an error message if any issues occur during the connection process.
*/
// Function to establish a database connection
function connectToDatabase() {
    // Connection parameters
    $hostname = "localhost";
    $username = "student1";
    $password = "pass";
    $database = "baseball_01";

    try {
        // Create a new MySQLi connection
        $conn = new mysqli($hostname, $username, $password, $database);

        // Check for connection errors
        if ($conn->connect_error) {
            // Throw an exception with the error message
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        return $conn; // Return the MySQLi connection object
    } catch (Exception $e) {
        // Handle exceptions here (e.g., log the error)
        throw new Exception("Database connection error: " . $e->getMessage());
    }
}
?>