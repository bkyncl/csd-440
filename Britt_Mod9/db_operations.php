<?php
/*
db_operations.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Handles various db operations requested by form submission from BrittEditForms.php, BrittForms.php, and BrittQuerySearch.php 
including searching for planets based on user input,
inserting new planet records, and deleting existing planet records. It establishes a database connection,
executes SQL queries for data manipulation, and provides response messages for success and error cases.
Key Components:
  - Database connection using mysqli.
  - Search functionality based on user input, supporting partial matches.
  - Validation of input data for inserting new planet records.
  - Handling of success and error responses for search, insert, and delete operations.
  - Secure handling of database queries to prevent SQL injection.

  Functions:
  - connectToDatabase(): Establishes a database connection.
  - validatePlanetData(): Validates and sanitizes user input for new planet insertion.
 
  Usage:
  - Search for planets by entering search criteria or selecting from a list.
  - Insert new planet records into the "planets" table with various attributes.
  - Delete existing planet records by selecting a planet from the displayed list.
*/

// include the functional file for validation functions
include("britt_utility/functions.php");

try {
    // Get the returned MySQLi connection using the connectToDatabase() function from db_connect.php
    $conn = connectToDatabase();

    // Check if the search button is clicked
    if (isset($_POST['search_planets'])) {
        // Check if the search value is not empty
        if (!empty($_POST['keyword']) && trim($_POST['keyword']) !== '') {
            // Sanitize and create a search pattern with wildcards for partial matches
            $keyword = '%' . trim($_POST['keyword']) . '%'; 
            $sql = "SELECT * FROM planets WHERE ";
            
            // Define an array of column names to search in
            $columns = array(
                'planet_name',
                'diameter_km',
                'distance_from_sun_km',
                'time_to_orbit_sun',
                'time_to_spin_on_axis',
                'moons_count',
                'average_temp_celsius',
                'dwarf_planet'
            );
            
            // Add each column to the WHERE clause with LIKE condition
            foreach ($columns as $column) {
                $sql .= "$column LIKE ? OR ";
            }
            
            // Remove the trailing " OR " from the WHERE clause
            $sql = rtrim($sql, " OR ");

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Dynamically bind the search pattern parameter for each column
            $paramTypes = str_repeat("s", count($columns)); // "ssssssss"
            $params = array_fill(0, count($columns), $keyword);
            $stmt->bind_param($paramTypes, ...$params);

        } elseif (!empty($_POST['selectPlanet'])) {
            // If the select box is used for search
            $selectedPlanet = $_POST['selectPlanet'];
            $sql = "SELECT * FROM planets WHERE planet_name = ?"; 

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Bind the selected planet parameter
            $stmt->bind_param("s", $selectedPlanet);
        } else {
            // Handle the case where the search input is empty or contains only spaces
            $error = "Please enter or select a search value before searching.";
        }
    
        try {
            // If no error occurred during search input handling
            if (empty($error)) {
                // Execute the query
                $stmt->execute();

                // Store the result set
                $result = $stmt->get_result();

                // Check if no results were found
                if ($result->num_rows === 0) {
                    $error = "No results found in 'Planets' table matching: " . $_POST['keyword'] . ".";
                } else {
                    // Fetch and display the results in the HTML template
                    $tableContent = "";
                    while ($row = $result->fetch_assoc()) {
                        $tableContent .= "<tr>";
                        $tableContent .= "<td>" . $row['id'] . "</td>";
                        $tableContent .= "<td>" . $row['planet_name'] . "</td>";
                        $tableContent .= "<td>" . $row['diameter_km'] . "</td>";
                        $tableContent .= "<td>" . $row['distance_from_sun_km'] . "</td>";
                        $tableContent .= "<td>" . $row['time_to_orbit_sun'] . "</td>";
                        $tableContent .= "<td>" . $row['time_to_spin_on_axis'] . "</td>";
                        $tableContent .= "<td>" . $row['moons_count'] . "</td>";
                        $tableContent .= "<td>" . $row['average_temp_celsius'] . "</td>";
                        $tableContent .= "<td>" . ($row['dwarf_planet'] ? 'Yes' : 'No') . "</td>";
                        $tableContent .= "</tr>";
                    }
                }
            }
        } catch (Exception $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }

    // Check if the insert planet button is clicked
    if (isset($_POST['insert_planet'])) {
        // Initialize an array to store validation errors and send post data to the validation function
        $validationErrors = validatePlanetData($_POST);
    
        // Check if a planet with the same name already exists
        try {
            $planetName = $_POST['planet_name'];
    
            // Prepare and execute a query to count planets with the same name
            $query = "SELECT COUNT(*) FROM planets WHERE planet_name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $planetName);
            $stmt->execute();
            $planetCount = $stmt->get_result()->fetch_row()[0];
    
            // If planet name already exists
            if ($planetCount > 0) {
                $validationErrors .= "A planet with the name '$planetName' already exists.<br>";
            }
        } catch (Exception $e) {
            $validationErrors .= "An error occurred while checking for existing planets: " . $e->getMessage() . "<br>";
        }
    
        // Check if there are any validation errors
        if (empty($validationErrors)) {
            // All data is valid, proceed with database insertion
            // Prepare the SQL statement using placeholders
            $sql = "INSERT INTO planets (
                planet_name, 
                diameter_km, 
                distance_from_sun_km, 
                time_to_orbit_sun, 
                time_to_spin_on_axis, 
                moons_count, 
                average_temp_celsius, 
                dwarf_planet
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Prepare and execute the SQL statement with MySQLi
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    'sddssids',
                    $_POST['planet_name'],
                    $_POST['diameter_km'],
                    $_POST['distance_from_sun_km'],
                    $_POST['time_to_orbit_sun'],
                    $_POST['time_to_spin_on_axis'],
                    $_POST['moons_count'],
                    $_POST['average_temp_celsius'],
                    $_POST['is_dwarf_planet']
                );
                $stmt->execute();
                
                // Handle success
                $responseMessage = "Data for $planetName inserted successfully.<br>";
                $alertClass = "alert-success"; // Set a success CSS class
    
            } catch (Exception $e) {
                // Handle database errors
                $responseMessage = "An error occurred: " . $e->getMessage();
                $alertClass = "alert-danger"; // Set an error CSS class
            }
        } else {
            // Handle validation errors
            $alertClass = "alert-danger"; // Set an error CSS class
        }
    }

    // Check if the delete planet button is clicked
    if (isset($_POST['delete-planet'])) {
        try {
            // Get the submitted planet ID to delete
            $planetIdToDelete = $_POST['id'];

            // Prepare and execute the SQL query to delete the planet
            $sql = "DELETE FROM planets WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $planetIdToDelete);
            $stmt->execute();

            // Handle success
            $responseMessage = "Planet ID: $planetIdToDelete  deleted successfully.";
            $alertClass = "alert-success"; // Set a success CSS class

        } catch (Exception $e) {
            $responseMessage = "Error deleting record: " . $e->getMessage();
            $alertClass = "alert-danger"; // Set an error CSS class
        }
    }

} catch (Exception $e) {
    // Handle the exception, e.g., log the error or display an error message
    $error = "An error occurred: " . $e->getMessage();
} finally { // close resources 
    //close resultset
    if (isset($result)) {
        $result->close();
    }
    // Close the statement
    if (isset($stmt)) {
        $stmt->close();
    }
    // Close the database connection
    if (isset($conn)) {
        $conn->close();
    }
}
?>