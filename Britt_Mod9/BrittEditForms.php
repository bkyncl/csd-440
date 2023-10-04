<!--
BrittEditForms.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Interface for veiewing and managing planets table. It provides the functionality to
display the entire 'planets' table and allows users to delete planets via ID# with "delete" form button
generated inside table content returned by queryDatabaseAndGetTableContent().
Key Components:
    - Starts a session to maintain user login state.
    - Includes the necessary files for database connection and operations.
    - Checks user authentication and redirects to the login page if not logged in.
    - Displays the 'planets' table with options to delete planets.
-->
<?php
session_start(); // Start the session

// Include the db connection file using require_once
require_once("britt_utility/db_connect.php");

// Inlcude other functional files
require_once("db_operations.php");

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

// Call the query function to get the planets table content or error message
$tableContentOrError = queryDatabaseAndGetTableContent();

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
        <!-- Display the table if tableContent is present -->
        <div class="container mt-14" style="padding-bottom: 50px;">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card bg-light text-dark">
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="card-title">Planets Table:</h5>
                            </div>
                            <?php if (!empty($tableContentOrError) && strpos($tableContentOrError, "Error:") === false): ?>
                                <div class="mb-3 text-center">
                                    <!-- Display the table if $tableContent is not empty -->
                                    <div class="text-center">
                                        <h6 class="card-title">Showing All Planets</h6>
                                    </div>
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
                                                    <th>Action</th> <!-- Column for Actions -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php echo $tableContentOrError; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="text-center" style="padding: 10px;">
                                    <!-- Display success or error message if available -->
                                    <?php if (!empty($responseMessage)): ?>
                                        <div class="alert <?php echo $alertClass; ?>" role="alert">
                                            <?php echo $responseMessage; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center">
                                    <!-- Display an error message if $tableContentOrError contains an error -->
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $tableContentOrError; ?>
                                    </div>
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