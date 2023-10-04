<!--
index.php
Planet CRUD app
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Main page index for managing a database, handling user authentication, session management, and providing options for database table creation, 
dropping, population, generating a pdf of the table, and queries. It incorporates user-friendly interface elements using Bootstrap for styling and navigation bar to other pages.
Key Components:
    - Initiates and manages user sessions to maintain login state.
    - Handles user login and logout, including validation of user credentials.
    - Inlcusion of db connect file that contains the PDO connection function.
    - Includes functionality of BrittPDF.php to generate a pdf containing the planets table.
    - Inlcusion of BrittCreateTable file that handles 'planet' table creation.
    - Inlcusion of BrittPopTable file that handles data insertion into 'planets' table.
    - Inlcusion of BrittDropTable file that handles dropping of 'planets' talbe.
    - Inlcusion of BrittQueryTable file that selects * from 'planets' table and generates table display.
    - Inclusion of navbar file which generates navbar header display and functionality.
    - Inclusion of functions file for checkCredentials().
    - User-friendly interface using Bootstrap for styling.
-->
<?php
session_start(); // Start the session

// Include the db connection file using require_once
require_once("britt_utility/db_connect.php");

// Inlcude other functional files
include("britt_utility/functions.php");
include("tbl_creation/BrittCreateTable.php");
include("tbl_creation/BrittPopTable.php");
include("tbl_creation/BrittDropTable.php");
include("tbl_creation/BrittQueryTable.php");

if (isset($_POST['user_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Password entered in the form
    $database = $_POST['database'];

    // Check credentials using the checkCredentials function
    if (checkCredentials($username, $password, $database)) {
        // Credentials are valid, set the user session and redirect to index.php
        $_SESSION['user_id'] = $username;
        header("Location: index.php");
        exit();
    } else {
        // Credentials are not valid, show an error message
        $error = "Authentication failed. Incorrect username or password.";
        header("Location: user_login.php?error=" . urlencode($error));
        exit();
    }
}

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // send back to login
    header("Location: user_login.php");
    exit();
}

// Logout user
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
<script>
    function getPDF(filename) {
        window.open(filename);
    }
</script>
<body class="bg-dark text-light"> <!-- Apply dark theme to the entire body -->
    <?php include("britt_utility/navbar.php"); ?> <!-- Include the navbar -->
    <div class="container mt-10" style="padding-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card bg-light text-dark"> <!-- Apply dark theme to the card -->
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">Welcome, <?php echo $_SESSION['user_id']?>!</h5>
                        </div>
                        <div class="mb-9">
                            <form method="POST" action="">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Click to create the "Planets" table
                                        <button type="submit" name="BrittCreateTable" class="btn btn-success center">Create Table</button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Click to populate the "Planets" table
                                        <button type="submit" name="BrittPopTable" class="btn btn-primary center">Populate Table</button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Click to drop the "Planets" table
                                        <button type="submit" name="BrittDropTable" class="btn btn-danger center">Drop Table</button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Click to query the "Planets" table
                                        <button type="submit" name="BrittQueryTable" class="btn btn-info center">Query Table</button>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Click to generate PDF of "Planets" Table
                                        <button onclick="getPDF('BrittPDF.php');" target="_blank" class="btn btn-success center">Generate PDF</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="text-center">
                            <!-- Display success or error message if available -->
                            <?php if (!empty($responseMessage)): ?>
                                <div class="alert <?php echo $alertClass; ?>" role="alert">
                                    <?php echo $responseMessage; ?>
                                </div>
                            <?php endif; ?>
                        </div>
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
                                <h5 class="card-title">Query Response:</h5>
                            </div>
                            <div class="mb-3 text-center">
                                <!-- Display the table if $tableContent is not empty -->
                                <div class="text-center">
                                    <h6 class="card-title">Displaying: SELECT * FROM 'planets'</h6>
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