<?php
/*
BrittPopTable.php
Module 11 Assignment
Name: Brittany Kyncl
Date: 10.2.23
Course: CSD440
Handles the population of a database table named "planets" with predefined planet data. It establishes a database connection using PDO, 
inserts planet data into the table, and displays a response message
Key Components:
    - Database connection using PDO with MySQL.
    - Defines an array of planet data to be inserted into the table.
    - Prepared statements for secure data insertion.
    - Checks for existing data to avoid duplicates.
    - Displays success or error messages for each planet's insertion.
    - DB connect funtion that returns PDO connection.
*/
if (isset($_POST['BrittPopTable'])) {
    // Initialize an empty response message
    $responseMessage = "";

    try {
        // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
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
            array("Ceres", 939, 4142610000, "4 years, 222 days", "9 hours", 0, -106, true),
            array("Haumea", 1632, 6450100000, "283 years, 44 days", "4 hours", 2, -240, true),
            array("Makemake", 1434, 6796200000, "306 years, 77 days", "23 hours", 1, -243, true),
            array("Eris", 2326, 10152000000, "559 years, 25 days", "26 hours", 1, -217, true)
        );

        // SQL query to insert data into the table
        $insertSql = "INSERT INTO planets (planet_name, diameter_km, distance_from_sun_km, time_to_orbit_sun, time_to_spin_on_axis, moons_count, average_temp_celsius, dwarf_planet) 
                    VALUES (:planet_name, :diameter_km, :distance_from_sun_km, :time_to_orbit_sun, :time_to_spin_on_axis, :moons_count, :average_temp_celsius, :dwarf_planet)";

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
            $checkStmt->execute(array($planetName));

            // If a record with the same name exists, skip insertion
            if ($checkStmt->rowCount()> 0) {
                $responseMessage .= "Data for $planetName already exists.<br>";
                $alertClass = "alert-danger"; // Set an error CSS class
            } else {
                // Bind values to named placeholders and execute the prepared statement to insert data
                $stmt->bindParam(":planet_name", $planetName);
                $stmt->bindParam(":diameter_km", $diameterKm);
                $stmt->bindParam(":distance_from_sun_km", $distanceFromSunKm);
                $stmt->bindParam(":time_to_orbit_sun", $timeToOrbitSun);
                $stmt->bindParam(":time_to_spin_on_axis", $timeToSpinOnAxis);
                $stmt->bindParam(":moons_count", $moonsCount);
                $stmt->bindParam(":average_temp_celsius", $averageTempCelsius);
                $stmt->bindParam(":dwarf_planet", $isDwarfPlanet, PDO::PARAM_BOOL);

                // Execute the prepared statement to insert data
                if ($stmt->execute()) {
                    $responseMessage .= "Data for $planetName inserted successfully.<br>";
                    $alertClass = "alert-success"; // Set an error CSS class

                } else {
                    throw new PDOException("Error inserting data for $planetName: " . implode(" ", $stmt->errorInfo()));
                }
            }

            // Close the check statement (left out of finally as it will be only created or closed inside each loop)
            $checkStmt= null;
        }

    } catch (PDOException $e) {
        $responseMessage = "An error occurred: " . $e->getMessage();
        $alertClass = "alert-danger"; // Set an error CSS class

    }finally { // Make use of finally block for better resource closure in case of error
        // Close the statement
        if (isset($stmt)) {
            $stmt = null;
        }

        // Close the database connection
        if (isset($conn)) {
            $conn = null;
        }
    }
}
?>
