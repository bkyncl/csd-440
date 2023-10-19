<?php
/*
BrittCreateTable.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Handles the creation of the "planets" table. It establishes a database connection, executes an SQL query to create the table, 
and displays a response message indicating the success or failure of the operation.
Key Components:
    - Database connection using mysqli.
    - SQL query to create the "planets" table with specified columns.
    - Handling of success and error responses.
    - DB connect funtion that returns a connection.
*/

if (isset($_POST['BrittCreateTable'])) {
    // Initialize an empty response message
    $responseMessage = '';
    $alertClass = '';

    try {
        // Get the returned MySQLi connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        // SQL query to create a table for planets
        $sql = "CREATE TABLE IF NOT EXISTS planets (
            id INT PRIMARY KEY AUTO_INCREMENT,
            planet_name VARCHAR(255) NOT NULL,
            diameter_km DECIMAL(20, 2) NOT NULL,
            distance_from_sun_km DECIMAL(20, 2) NOT NULL,
            time_to_orbit_sun VARCHAR(255) NOT NULL,
            time_to_spin_on_axis VARCHAR(255) NOT NULL,
            moons_count INT NOT NULL,
            average_temp_celsius DECIMAL(10, 2) NOT NULL,
            dwarf_planet BOOLEAN DEFAULT 0 NOT NULL
        )";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            $responseMessage = "Table 'planets' created successfully.";
            $alertClass = "alert-success"; // Set a success CSS class
        } else {
            throw new Exception("Error creating table: " . $conn->error);
        }

    } catch (Exception $e) {
        $responseMessage = "An error occurred: " . $e->getMessage();
        $alertClass = "alert-danger"; // Set an error CSS class

    } finally { // Make use of finally block for better resource closure in case of error
        // Close the database connection
        if (isset($conn)) {
            $conn->close();
        }
    }
}
?>
