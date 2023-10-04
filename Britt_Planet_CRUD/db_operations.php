<?php
/*
db_operations.php
Planet CRUD app
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Handles various db operations requested by form submission from BrittEditForms.php, BrittForms.php, and BrittQuerySearch.php 
including searching for planets based on user input,
inserting new planet records, updating existing planet records, and deleting existing planet records. It establishes a database connection using PDO,
executes SQL queries for data manipulation, and provides response messages for success and error cases.
Key Components:
  - Database connection using PDO with MySQL.
  - Search functionality based on user input, supporting partial matches.
  - Validation of input data for inserting new planet records.
  - Handling of success and error responses for search, insert, update, and delete operations.
  - Secure handling of database queries to prevent SQL injection.

  Functions:
  - connectToDatabase(): Establishes a PDO database connection.
  - validatePlanetData(): Validates and sanitizes user input for new planet insertion.
 
  Usage:
  - Search for planets by entering search criteria or selecting from a list.
  - Insert new planet records into the "planets" table with various attributes.
  - Delete existing planet records by selecting a planet from the displayed list.
  - Update existing planet record by selecting a planet and updating it's attributes.
*/

// include the functional file for validation functions
include("britt_utility/functions.php");

try {
    // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
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
                $sql .= "$column LIKE :keyword OR ";
            }
            
            // Remove the trailing " OR " from the WHERE clause
            $sql = rtrim($sql, " OR ");

        } elseif (!empty($_POST['selectPlanet'])) {
            // If the select box is used for search
            $selectedPlanet = $_POST['selectPlanet'];
            $sql = "SELECT * FROM planets WHERE planet_name = :selectedPlanet";   
        } else {
            // Handle the case where the search input is empty or contains only spaces
            $error = "Please enter or select a search value before searching.";
        }
    
        try {
            // If no error occurred during search input handling
            if (empty($error)) {
                // Prepare and execute the SQL query
                $stmt = $conn->prepare($sql);
    
                if (!empty($keyword)) {
                    // Bind the search pattern parameter
                    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                } elseif (!empty($selectedPlanet)) {
                    // Bind the selected planet parameter
                    $stmt->bindParam(':selectedPlanet', $selectedPlanet, PDO::PARAM_STR);
                }
    
                // Execute the query
                $stmt->execute();
    
                // Fetch and store the result set
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Check if no results were found
                if (empty($result)) {
                    $error = "No results found in 'Planets' table macthing: " . $_POST['keyword'] .".";
                } else {
                    // Fetch and display the results in the HTML template
                    $tableContent = "";
                    foreach ($result as $row) {
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
        } catch (PDOException $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }

    // Check if the insert planet button is clicked
    if (isset($_POST['insert_planet'])) {
        // Initialize an array to store validation errors and send post data to validation function
        $validationErrors = validatePlanetData($_POST);
    
        // Check if a planet with the same name already exists
        try {
            $planetName = $_POST['planet_name'];
    
            // Prepare and execute a query to count planets with the same name
            $query = "SELECT COUNT(*) FROM planets WHERE planet_name = :planet_name";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':planet_name', $planetName, PDO::PARAM_STR);
            $stmt->execute();
            $planetCount = $stmt->fetchColumn();
    
            // If planet name already exists
            if ($planetCount > 0) {
                $validationErrors .= "A planet with the name '$planetName' already exists.<br>";
            }
        } catch (PDOException $e) {
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
            ) VALUES (
                :planet_name, 
                :diameter_km, 
                :distance_from_sun_km, 
                :time_to_orbit_sun, 
                :time_to_spin_on_axis, 
                :moons_count, 
                :average_temp_celsius, 
                :is_dwarf_planet
            )";
            
            // Prepare and execute the SQL statement with PDO
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':planet_name', $_POST['planet_name'], PDO::PARAM_STR);
                $stmt->bindParam(':diameter_km', $_POST['diameter_km'], PDO::PARAM_STR); // Change to PDO::PARAM_STR
                $stmt->bindParam(':distance_from_sun_km', $_POST['distance_from_sun_km'], PDO::PARAM_STR); // Change to PDO::PARAM_STR
                $stmt->bindParam(':time_to_orbit_sun', $_POST['time_to_orbit_sun'], PDO::PARAM_STR); // Change to PDO::PARAM_STR
                $stmt->bindParam(':time_to_spin_on_axis', $_POST['time_to_spin_on_axis'], PDO::PARAM_STR); // Change to PDO::PARAM_STR
                $stmt->bindParam(':moons_count', $_POST['moons_count'], PDO::PARAM_INT);
                $stmt->bindParam(':average_temp_celsius', $_POST['average_temp_celsius'], PDO::PARAM_STR); // Change to PDO::PARAM_STR
                $stmt->bindParam(':is_dwarf_planet', $_POST['is_dwarf_planet'], PDO::PARAM_INT);
                $stmt->execute();
                
                // Handle success
                $responseMessage = "Data for $planetName inserted successfully.<br>";
                $alertClass = "alert-success"; // Set an error CSS class
    
            } catch (PDOException $e) {
                // Handle database errors
                $responseMessage = "An error occurred: " . $e->getMessage();
                $alertClass = "alert-danger"; // Set an error CSS class
            }
        } else {
            // Handle validation errors
            $alertClass = "alert-danger"; // Set an error CSS class
        }
    }

    // Check if the insert planet button is clicked
    if (isset($_POST['edit_planet_record_submit'])) {
        
        // Store the submitted form values in variables
        $planetIdToUpdate = $_POST['planet_id']; 
        $editPlanetName = $_POST['planet_name'];
        $editDiameterKm = $_POST['diameter_km'];
        $editDistanceFromSunKm = $_POST['distance_from_sun_km'];
        $editTimeToOrbitSun = $_POST['time_to_orbit_sun'];
        $editTimeToSpinOnAxis = $_POST['time_to_spin_on_axis'];
        $editMoonsCount = $_POST['moons_count'];
        $editAverageTempCelsius = $_POST['average_temp_celsius'];
        $editIsDwarfPlanet = $_POST['is_dwarf_planet'];

        // Initialize an array to store validation errors and send post data to validation function
        $validationErrors = validatePlanetData($_POST);
    
        // Check if there are any validation errors
        if (empty($validationErrors)) {
            // All data is valid, proceed with updating the database record

            try {
                $planetIdToUpdate = $_POST['planet_id']; // Assuming you have a hidden input field for planet_id

                // Prepare the SQL UPDATE statement
                $sql = "UPDATE planets SET
                    planet_name = :planet_name, 
                    diameter_km = :diameter_km, 
                    distance_from_sun_km = :distance_from_sun_km, 
                    time_to_orbit_sun = :time_to_orbit_sun, 
                    time_to_spin_on_axis = :time_to_spin_on_axis, 
                    moons_count = :moons_count, 
                    average_temp_celsius = :average_temp_celsius, 
                    dwarf_planet = :is_dwarf_planet 
                    WHERE id = :planet_id";

                // Prepare and execute the SQL statement with PDO
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':planet_name', $_POST['planet_name'], PDO::PARAM_STR);
                $stmt->bindParam(':diameter_km', $_POST['diameter_km'], PDO::PARAM_STR);
                $stmt->bindParam(':distance_from_sun_km', $_POST['distance_from_sun_km'], PDO::PARAM_STR);
                $stmt->bindParam(':time_to_orbit_sun', $_POST['time_to_orbit_sun'], PDO::PARAM_STR);
                $stmt->bindParam(':time_to_spin_on_axis', $_POST['time_to_spin_on_axis'], PDO::PARAM_STR);
                $stmt->bindParam(':moons_count', $_POST['moons_count'], PDO::PARAM_INT);
                $stmt->bindParam(':average_temp_celsius', $_POST['average_temp_celsius'], PDO::PARAM_STR);
                $stmt->bindParam(':is_dwarf_planet', $_POST['is_dwarf_planet'], PDO::PARAM_INT);
                $stmt->bindParam(':planet_id', $planetIdToUpdate, PDO::PARAM_INT);
                $stmt->execute();

                // Handle success
                $responseMessage = "Data for planet ID: $planetIdToUpdate updated successfully.<br>";
                $alertClass = "alert-success"; // Set a success CSS class

                // Redirect back to the appropriate page with success message
                header("Location: BrittEditForms.php?successMessage=" . urlencode($responseMessage) . "&alertClass=" . urlencode($alertClass));
            } catch (PDOException $e) {
                // Handle database errors
                $responseMessage = "An error occurred: " . $e->getMessage();
                $alertClass = "alert-danger"; // Set an error CSS class
            }
        } else {
            // Handle validation errors
            $alertClass = "alert-danger"; // Set an error CSS class
            $planetIdToUpdate = htmlspecialchars($planetIdToUpdate); 
            $editPlanetName = htmlspecialchars($editPlanetName);
            $editDiameterKm = htmlspecialchars($editDiameterKm);
            $editDistanceFromSunKm = htmlspecialchars($editDistanceFromSunKm); 
            $editTimeToSpinOnAxis = htmlspecialchars($editTimeToSpinOnAxis);
            $editMoonsCount = htmlspecialchars($editMoonsCount); 
            $editAverageTempCelsius = htmlspecialchars($editAverageTempCelsius);
            $editIsDwarfPlanet = htmlspecialchars($editIsDwarfPlanet);
        }
    }

    // Check if the delete planet button is clicked
    if (isset($_POST['delete-planet'])) {
        try {
            // Get the submitted planet ID to delete
            $planetIdToDelete = $_POST['id'];

            // Prepare and execute the SQL query to delete the planet
            $sql = "DELETE FROM planets WHERE id = :planet_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':planet_id', $planetIdToDelete, PDO::PARAM_INT);
            $stmt->execute();

            // Handle success
            $responseMessage = "Planet ID: $planetIdToDelete  deleted successfully.";
            $alertClass = "alert-success"; // Set an error CSS class

        } catch (PDOException $e) {
            $responseMessage = "Error deleting record: " . $e->getMessage();
            $alertClass = "alert-danger"; // Set an error CSS class
        }
    }

} finally { // close resources 
    //close resultset
    if(isset($result)) {
        $result = null;
    }
    // Close the statement
    if (isset($stmt)) {
        $stmt = null;
    }
    // Close the database connection
    if (isset($conn)) {
        $conn = null;
    }
}
?>