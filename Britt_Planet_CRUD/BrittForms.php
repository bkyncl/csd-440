<!--
BrittForms.php
Planet CRUD app
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Interface for inserting new planet data into the 'planets' database table.
Users can enter input into planet data fields for insertion. Data for insertion is validated and displays success or error messages based on result.
It also handles user authentication and session management.

Key Components:
    - Starts a session to maintain user login state.
    - Includes the necessary files for database connection and operations.
    - Validates user authentication and redirects to the login page if not logged in.
    - Provides a form to input planet data, including name, diameter, distance, time to orbit, time to spin,
        moon count, average temperature, and whether it's a dwarf planet.
    - Displays success or error messages after submitting the form.
-->
<?php
session_start(); // Start the session

// Include the db connection file using require_once
require_once("britt_utility/db_connect.php");

// Inlcude other functional files
include("db_operations.php");


// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // send back to login
    header("Location: user_login.php");
    exit();
}

// Logout function
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: user_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Mod 9 Assignment</title>
 
</head>
<body class="bg-dark text-light"> <!-- Apply dark theme to the entire body -->
    <?php include("britt_utility/navbar.php"); ?> <!-- Include the navbar -->
    <div class="container mt-10" style="padding-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card bg-light text-dark"> <!-- Apply dark theme to the card -->
                    <div class="card-body">
                        <div class="text-center" style="padding-bottom: 10px;">
                            <h5 class="card-title">Insert a New Planet Into the Planets Table</h5>
                        </div>                     
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="planet_name" class="form-label">Planet Name</label>
                                <input type="text" class="form-control" id="planet_name" name="planet_name" placeholder="Enter planet name" >
                            </div>
                            <div class="mb-3">
                                <label for="diameter_km" class="form-label">Diameter (km)</label>
                                <input type="text" class="form-control" id="diameter_km" name="diameter_km" placeholder="Enter diameter in kilometers" >
                            </div>
                            <div class="mb-3">
                                <label for="distance_from_sun_km" class="form-label">Distance from Sun (km)</label>
                                <input type="text" class="form-control" id="distance_from_sun_km" name="distance_from_sun_km" placeholder="Enter distance from Sun in kilometers" >
                            </div>
                            <div class="mb-3">
                                <label for="time_to_orbit_sun" class="form-label">Time to Orbit Sun</label>
                                <input type="text" class="form-control" id="time_to_orbit_sun" name="time_to_orbit_sun" placeholder="Enter time to orbit the Sun in days and/or years" >
                            </div>
                            <div class="mb-3">
                                <label for="time_to_spin_on_axis" class="form-label">Time to Spin on Axis</label>
                                <input type="text" class="form-control" id="time_to_spin_on_axis" name="time_to_spin_on_axis" placeholder="Enter time to spin on its axis in hours and/or days" >
                            </div>
                            <div class="mb-3">
                                <label for="moons_count" class="form-label">Number of Moons</label>
                                <input type="number" class="form-control" id="moons_count" name="moons_count" placeholder="Enter the number of moons" >
                            </div>
                            <div class="mb-3">
                                <label for="average_temp_celsius" class="form-label">Average Temperature (Celsius)</label>
                                <input type="text" class="form-control" id="average_temp_celsius" name="average_temp_celsius" placeholder="Enter average temperature in Celsius" >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Is it a Dwarf Planet?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_dwarf_planet" id="is_dwarf_planet_yes" value="1">
                                    <label class="form-check-label" for="is_dwarf_planet_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_dwarf_planet" id="is_dwarf_planet_no" value="0" checked>
                                    <label class="form-check-label" for="is_dwarf_planet_no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="insert_planet">Insert New Planet</button>
                            </div>
                        </form>
                        <div class="text-center" style="padding: 10px;">
                            <!-- Display success or error message if available -->
                            <?php if (!empty($responseMessage)): ?>
                                <div class="alert <?php echo $alertClass; ?>" role="alert">
                                    <?php echo $responseMessage; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($validationErrors)): ?>
                                <div class="alert <?php echo $alertClass; ?>" role="alert">
                                    <?php echo $validationErrors; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>