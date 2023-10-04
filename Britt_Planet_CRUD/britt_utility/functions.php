<!--
functions.php
Planet CRUD app
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
This file contains various functions related to credential validation,
database queries, and data validation for a planets database application.

Functions:
    - checkCredentials(): Validates probided credentials against valid credentials
    - GenerateAllPlanets(): Returns html options for dropdown containing all planet names.
    - connectToDatabase(): Establishes a PDO database connection.
    - validatePlanetData(): Validates and sanitizes user input for new planet insertion.
    - queryDatabaseAndGetTableContent(): Returns table conent of planet data and deletion form for each.
    - validateNumeric(): Validates numeric field.
    - validatePlanetData(): Validates and sanitizes user input for new planet insertion.
-->
<?php

/**
 * Checks the provided credentials against hardcoded values.
 *
 * @param string $username The username to be checked.
 * @param string $password The password to be checked.
 * @param string $database The database name to be checked.
 *
 * @return bool True if the provided credentials match the valid credentials, false otherwise.
 */
function checkCredentials($username, $password, $database) {
    // Hardcoded valid username and password
    $validUsername = "student1"; // check for username
    $validPassword = "pass"; // check for password
    $validDatabase = "baseball_01"; // check for database

    // Check if the provided username and password match the valid credentials
    if ($username === $validUsername && $password === $validPassword && $database == $validDatabase) {
        return true; // Credentials are valid
    } else {
        return false; // Credentials are not valid
    }
}
/**
 * Generates HTML options for a dropdown menu based on data from the 'planets' table.
 *
 * @return string HTML options for a dropdown menu containing planet names.
 */
function generateAllPlanets() {
    try {
        // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        // SQL query to retrieve all planet names from the "planets" table
        $query = "SELECT planet_name FROM planets";

        // Execute the query
        $result = $conn->query($query);

        // Initialize an empty string to store the HTML options
        $options = "";

        // Check if there are any results
        if ($result->rowCount() > 0) {
            
            // Loop through the results and populate the select options
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $options .= "<option value='" . $row['planet_name'] . "'>" . $row['planet_name'] . "</option>";
            }

        } else {
            // Add a default option indicating no data in the table
            $options .= "<option value='' disabled>Error: No data in 'Planets' table.</option>";
        }

        // Return the HTML options
        return $options;

    } catch (PDOException $e) {
        // Return the error message as a string
        return "<option value='' disabled>Error:"  . $e->getMessage() ."</option>";

    } finally { // Make use of finally block for better resource closure in case of error

        // Close the statement
        if (isset($result)) {
            $result = null;
        }

        // Close the database connection
        if (isset($conn)) {
            $conn=null;
        }

    }
}

/**
 * Queries the database and returns table content of Planets or an error message.
 * Includes returned html form for deletion of planet. (For use in 'BrittEditForms.php')
 *
 * @return string Table content of planets or an error message.
 */
function queryDatabaseAndGetTableContent() {
    // Initialize an empty response message
    $responseMessage = '';

    try {
        // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        // Query to retrieve all records from the "planets" table
        $sql = "SELECT * FROM planets";

        // Execute the query
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result !== false) {
            // Check if there are rows in the result set
            if ($result->rowCount() > 0) {
                // Initialize an empty table content
                $tableContent = '';

                // Loop through the result set and build the table content
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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

                    // Edit form (work on this later... leave out for now :/)
                    $tableContent .= '<td>';
                    $tableContent .= '<form method="POST" action="edit_form.php">';
                    $tableContent .= '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    $tableContent .= '<button type="submit" class="btn btn-info" name="edit-planet">Edit</button>';
                    $tableContent .= '</form>';
                    $tableContent .= '</td>';
                    
                    // Delete form
                    $tableContent .= '<td>';
                    $tableContent .= '<form method="POST" action="">';
                    $tableContent .= '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    $tableContent .= '<button type="submit" class="btn btn-danger" name="delete-planet">Delete</button>';
                    $tableContent .= '</form>';
                    $tableContent .= '</td>';
                    
                    $tableContent .= '</tr>';
                }

                // Set $responseMessage to an empty string (no error message)
                $responseMessage = $tableContent;
            } else {
                $responseMessage = "Error: No records found in the 'planets' table.";
            }
        } 

    } catch (PDOException $e) {
        $responseMessage = "Error: " . $e->getMessage();
    } finally { // Make use of finally block for better resource closure in case of error
        // Close the result set
        if (isset($result)) {
            $result = null;
        }

        // Close the database connection
        if (isset($conn)) {
            $conn = null;
        }
    }

    // Return the response message (either table content or an error message)
    return $responseMessage;
}

/**
 * Validates a numeric field.
 *
 * @param mixed $field The field to be validated.
 * @param string $fieldName The name of the field, used in error message if validation fails.
 *
 * @return string An error message if validation fails, empty string otherwise.
 */
function validateNumeric($field, $fieldName) {
    if (!is_numeric($field) || $field < 0) {
        return "$fieldName must be a positive number.<br>";
    }
    return "";
}
/**
 * Validates planet data input fields from planet insertion form.
 *
 * @param array $postData An array containing the submitted planet data.
 *
 * @return string Validation errors as a concatenated string, or an empty string if data is valid.
 */
function validatePlanetData($postData) {
    // Initialize an array to store validation errors
    $validationErrors = "";

    // Validate planet_name (Allow inputs with spaces)
    $planetName = trim($postData['planet_name']);
    if (empty($planetName)) {
        $validationErrors .= "Planet Name is required.<br>";
    } elseif (!preg_match("/^[A-Za-z ]+$/", $planetName)) {
        // Check if the planetName contains only letters and spaces
        $validationErrors .= "Planet Name must contain only letters and spaces.<br>";
    }

    // Validate diameter_km
    $validationErrors .= validateNumeric(trim($postData['diameter_km']), "Diameter (km)");

    // Validate distance_from_sun_km
    $validationErrors .= validateNumeric(trim($postData['distance_from_sun_km']), "Distance from Sun (km)");

    // Validate time_to_orbit_sun
    $timeToOrbitSun = trim($postData['time_to_orbit_sun']);
    if (empty($timeToOrbitSun)) {
        $validationErrors .= "Time to Orbit Sun is required.<br>";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d,.\s]*$/", $timeToOrbitSun)) {
        $validationErrors .= "Time to Orbit Sun must contain at least one letter, one number, and may include commas, periods, and spaces.<br>";
    }

    // Validate time_to_spin_on_axis
    $timeToSpinOnAxis = trim($postData['time_to_spin_on_axis']);
    if (empty($timeToSpinOnAxis)) {
        $validationErrors .= "Time to Spin on Axis is required.<br>";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d,.\s]*$/", $timeToSpinOnAxis)) {
        $validationErrors .= "Time to Spin on Axis must contain at least one letter, one number, and may include commas, periods, and spaces.<br>";
    }

    // Validate moons_count
    $validationErrors .= validateNumeric(trim($postData['moons_count']), "Moons Count");

    // Validate average_temp_celsius
    $averageTempCelsius = trim($postData['average_temp_celsius']);
    if (!is_numeric($averageTempCelsius)) {
        $validationErrors .= "Average Temp (Celsius) must be a number.<br>";
    }

    // Validate is_dwarf_planet (Assuming it's 0 or 1)
    $isDwarfPlanet = trim($postData['is_dwarf_planet']);
    if ($isDwarfPlanet !== '0' && $isDwarfPlanet !== '1') {
        $validationErrors .= "Dwarf Planet must be true or false.<br>";
    }
    return $validationErrors;
}
?>