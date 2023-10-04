<?php
/*
BrittCreateTable.php
Module 11 Assignment
Name: Brittany Kyncl
Date: 10.2.23
Course: CSD440
Handles the creation of the "planets" table. It establishes a database connection using PDO, executes an SQL query to create the table, 
and displays a response message indicating the success or failure of the operation.
Key Components:
    - Database connection using PDO with MySQL.
    - SQL query to create the "planets" table with specified columns.
    - Handling of success and error responses.
    - DB connect funtion that returns PDO connection.
*/
if (isset($_POST['BrittCreateTable'])) {
    // Initialize an empty response message
    $responseMessage = '';

    try {
        // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
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

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            $responseMessage = "Table 'planets' created successfully.";
            $alertClass = "alert-success"; // Set a success CSS class

        } else {
            throw new PDOException("Error creating table: " . implode(" ", $stmt->errorInfo()));
        }

    } catch (PDOException $e) {
        $responseMessage = "An error occurred: " . $e->getMessage();
        $alertClass = "alert-danger"; // Set an error CSS class

    } finally { // Make use of finally block for better resource closure in case of error

        // Close the statement
        if (isset($stmt)) {
            $stmt = null;
        }

        // Close the database connection
        if (isset($conn)) {
            $conn=null;
        }

    }
}
?>
