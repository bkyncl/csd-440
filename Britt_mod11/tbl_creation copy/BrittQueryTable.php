<?php
/*BrittQueryTable.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Handles the query of data from a database table named "planets" and displays it in a formatted table. 
It establishes a database connection, executes a SELECT * query to retrieve data.
Key Components:
    - Database connection using mysqli.
    - Executes a SELECT * query to retrieve all records from the "planets" table.
    - Dynamically generates an HTML table to display the retrieved data.
    - Handles potential errors during database operations and displays appropriate messages.
    - DB connect funtion that returns db connection.
*/
if (isset($_POST['BrittQueryTable'])) {
    // Initialize an empty response message
    $responseMessage = '';
    $alertClass = '';

    try {
        // Get the returned MySQLi connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        // Query to retrieve all records from the "planets" table
        $sql = "SELECT * FROM planets";

        // Execute the query
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result !== false) {
            // Check if there are rows in the result set
            if ($result->num_rows > 0) {
                // Initialize an empty table content
                $tableContent = '';

                // Loop through the result set and build the table content
                while ($row = $result->fetch_assoc()) {
                    $tableContent .= '<tr>';
                    $tableContent .= '<td>' . $row['id'] . '</td>';
                    $tableContent .= '<td>' . $row['planet_name'] . '</td>';
                    $tableContent .= '<td>' . $row['diameter_km'] . '</td>';
                    $tableContent .= '<td>' . $row['distance_from_sun_km'] . '</td>';
                    $tableContent .= '<td>' . $row['time_to_orbit_sun'] . '</td>';
                    $tableContent .= '<td>' . $row['time_to_spin_on_axis'] . '</td>';
                    $tableContent .= '<td>' . $row['moons_count'] . '</td>';
                    $tableContent .= '<td>' . $row['average_temp_celsius'] . '</td>';
                    $tableContent .= '<td>' . ($row['dwarf_planet'] ? 'Yes' : 'No') . '</td>';
                    $tableContent .= '</tr>';
                }

                // Set $responseMessage to an empty string (no error message)
                $responseMessage = '';
            } else {
                $responseMessage = "No records found in the 'planets' table.";
                $alertClass = "alert-danger"; // Set an error CSS class
            }
        } 

    } catch (Exception $e) {
        $responseMessage = "An error occurred: " . $e->getMessage();
        $alertClass = "alert-danger"; // Set an error CSS class

    } finally { // Make use of finally block for better resource closure in case of error
        // Close the result set
        if (isset($result)) {
            $result->close();
        }

        // Close the database connection
        if (isset($conn)) {
            $conn->close();
        }
    }
}
?>
?>
