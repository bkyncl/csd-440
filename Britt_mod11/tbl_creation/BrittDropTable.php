<?php
/*
BrittDropTable.php
Module 11 Assignment
Name: Brittany Kyncl
Date: 10.2.23
Course: CSD440
Handles the dropping of a database table named "planets". It establishes a database connection using PDO, executes an SQL query to drop the table, and displays a response message.
Key Components:
    - Database connection using PDO with MySQL.
    - SQL query to drop the "planets" table.
    - Handling of success and error responses.
    - DB connect funtion that returns PDO connection.
*/
if (isset($_POST['BrittDropTable'])) {
    // Initialize an empty response message
    $responseMessage = '';

    try {
        // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        $sql = "DROP TABLE IF EXISTS planets";

        if ($conn->exec($sql) !== FALSE) {
            $responseMessage = "Table 'planets' dropped successfully.";
            $alertClass = "alert-success"; // Set a success CSS class

        } else {
            throw new PDOException("Error dropping table: " . implode(" ", $stmt->errorInfo()));
        }

    } catch (PDOException $e) {
        $responseMessage = "An error occurred: " . $e->getMessage();
        $alertClass = "alert-danger"; // Set an error CSS class

    } finally { // Make use of finally block for better resource closure in case of error

        // Close the database connection
        if (isset($conn)) {
            $conn=null;
        }

    }
}
?>