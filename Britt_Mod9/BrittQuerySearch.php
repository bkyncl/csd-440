<!--
BrittQuerySearch.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Interface for searching and querying the 'planets' database table.
Users can enter search keywords or select a planet from the dropdown menu to find specific planet records.
Dropdown menu dynamically generated through query to reflect current options.
Keyword search input data is validated and displays successfull search, error messages, or not found message based on result.
It also handles user authentication and session management.
Key Components:
   - Starts a session to maintain user login state.
   - Includes the necessary files for database connection and operations.
   - Provides a search form with options to search by keyword or select a planet from the dropdown menu.
   - Displays search results in a table format.
-->
<?php
session_start(); // Start the session

// Include the db connection file using require_once
require_once("britt_utility/db_connect.php");

// Inlcude other functional files
require_once("db_operations.php");
require_once("britt_utility/functions.php");

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
                            <h5 class="card-title">Search for Planets by Entry or Selection</h5>
                        </div>                     
                        <form action="" method="POST">
                            <div class="mb-3">
                                <!-- password input -->
                                <label for="keyword" class="form-label">Enter Search Value</label>
                                <input type="test" class="form-control" id="keyword" name="keyword" placeholder="Search for...">
                            </div>
                            <div class="mb-3">
                                <label for="selectPlanet" class="form-label">Select From All Planets</label>
                                <select class="form-control" id="selectPlanet" name="selectPlanet">
                                    <option value="" disabled selected>Select a planet..</option>
                                    <?php
                                    $planetOptions = generateAllPlanets();

                                    // Check if the result contains an error
                                    if (strpos($planetOptions, "Error") !== false) {
                                        echo $planetOptions;
                                    } else {
                                        echo $planetOptions;
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Display errors if present -->
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            <div class="text-center"> <!-- Add text-center class here -->
                                <button type="submit" class="btn btn-success" name="search_planets">Search Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Display the table if tableContent is present -->
    <?php if (!empty($tableContent)): ?>
        <div class="container mt-14" style="padding-bottom: 50px;">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card bg-light text-dark">
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="card-title">Search Results:</h5>
                            </div>
                            <div class="mb-3 text-center">
                                <!-- Display the table if $tableContent is not empty -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Planet Name</th>
                                                <th>Diameter (km)</th>
                                                <th>Distance from Sun (km)</th>
                                                <th>Time to Orbit Sun</th>
                                                <th>Time to Spin on Axis</th>
                                                <th>Moons Count</th>
                                                <th>Average Temp (Celsius)</th>
                                                <th>Dwarf Planet</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php echo $tableContent; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>