<?php
/*
BrittPopTable.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Handles the population of a database table named "planets" with predefined planet data. It establishes a database connection 
inserts planet data into the table, and displays a response message
Key Components:
    - Database connection using mysqli.
    - Defines an array of planet data to be inserted into the table.
    - Prepared statements for secure data insertion.
    - Checks for existing data to avoid duplicates.
    - Displays success or error messages for each planet's insertion.
    - DB connect funtion that returns a connection.
*/

if (isset($_POST['BrittPopTable'])) {
    // Initialize an empty response message
    $responseMessage = "";
    $alertClass = '';

    try {
        // Get the returned MySQLi connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        // Define an array of planet data
        $planetData = array(
            array("Mercury", 4879, 57909000, "88 days", "59 days", 0, -180, false),
            array("Venus", 12104, 108209000, "225 days", "243 days", 0, 471, false),
            array("Earth", 12742, 149596000, "365 days", "24 hours", 1, 15, false),
            array("Mars", 6779, 22792000, "687 days", "24.6 hours", 2, -28, false),
            array("Jupiter", 139822, 778570000 , "12 years", "9.9 hours", 95, -108, false),
            array("Saturn", 120536, 1433530000, "29.5 years", "10.7 hours", 146, -138, false),
            array("Uranus", 50724, 2872460000, "84 years", "17.2 hours", 27, -195, false),
            array("Neptune", 49244 , 4495060000, "165 years", "16.1 hours", 14, -201, false),
            array("Pluto", 2376, 5869656000, "248 years", "6.4 days", 5, -233, true),
            array("Ceres", 939, 4142610000, "4 years, 222 days", "9 hours", 0, -106, true)
        );

        // SQL query to insert data into the table
        $insertSql = "INSERT INTO planets (planet_name, diameter_km, distance_from_sun_km, time_to_orbit_sun, time_to_spin_on_axis, moons_count, average_temp_celsius, dwarf_planet) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Create a prepared statement
        $stmt = $conn->prepare($insertSql);

        // Loop through the planet data and execute the prepared statement for each planet
        foreach ($planetData as $planet) {
            list(
                $planetName,
                $diameterKm,
                $distanceFromSunKm,
                $timeToOrbitSun,
                $timeToSpinOnAxis,
                $moonsCount,
                $averageTempCelsius,
                $isDwarfPlanet
            ) = $planet;

            // Check if the planet with the same name already exists
            $checkSql = "SELECT id FROM planets WHERE planet_name = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $planetName);
            $checkStmt->execute();

            // If a record with the same name exists, skip insertion
            if ($checkStmt->fetch()) {
                $responseMessage .= "Data for $planetName already exists.<br>";
                $alertClass = "alert-danger"; // Set an error CSS class
            } else {
                // Bind values to the prepared statement and execute it to insert data
                $stmt->bind_param("sddssidi", $planetName, $diameterKm, $distanceFromSunKm, $timeToOrbitSun, $timeToSpinOnAxis, $moonsCount, $averageTempCelsius, $isDwarfPlanet);
                if ($stmt->execute()) {
                    $responseMessage .= "Data for $planetName inserted successfully.<br>";
                    $alertClass = "alert-success"; // Set a success CSS class
                } else {
                    throw new Exception("Error inserting data for $planetName: " . $conn->error);
                }
            }

            // Close the check statement (left out of finally as it will be only created or closed inside each loop)
            $checkStmt->close();
        }

    } catch (Exception $e) {
        $responseMessage = "An error occurred: " . $e->getMessage();
        $alertClass = "alert-danger"; // Set an error CSS class

    } finally { // Make use of finally block for better resource closure in case of error
        // Close the prepared statement
        if (isset($stmt)) {
            $stmt->close();
        }

        // Close the database connection
        if (isset($conn)) {
            $conn->close();
        }
    }
}
?>
