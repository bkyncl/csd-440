<?php
/*
db_connect.php
Planet CRUD app
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Contains function used to establish or establishing a databse connection 
Contains database connection parameters and creates a PDO connection. 
The PDO error mode is configured to throw exceptions on errors. The function returns the PDO connection object if the connection is successful, 
and it throws a PDOException with an error message if any issues occur during the connection process.
*/
// Function to establish a database connection
function connectToDatabase() {
    // connection parameters
    $dsn = "mysql:host=localhost;dbname=baseball_01";
    $username = "student1";
    $password = "pass";

    try {

        // Attempt to create a new PDO database connection 
        $conn = new PDO($dsn, $username, $password);
        // Set PDO error mode to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // // Set default fetch mode to associative arrays
        // $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn; // Return the PDO connection object

    } catch (PDOException $e) {
        // Throw an exception with the error message
        throw new PDOException("Connection failed: " . $e->getMessage());
    }
}
?>