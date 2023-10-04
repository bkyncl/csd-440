<!--
user_login.php
Module 9 Assignment
Name: Brittany Kyncl
Date: 9.23.23
Course: CSD440
Serves as inital interface for database operations prompting users to enter in credentials to log into database.
If there is an error message passed via the query parameter 'error', it will be displayed to the user to provide feedback on any authentication issues.
Upon submitting the credentials, the form action redirects to the 'index.php' file, initiating the database management functionality.
-->
<?php

// Check if there's an error message in the query parameter
$error = isset($_GET['error']) ? urldecode($_GET['error']) : "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mod 9 Assignment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-dark text-light"> <!-- Apply dark theme to the entire body -->
    <?php include("britt_utility/navbar.php"); ?> <!-- Include the navbar -->
    <div class="container mt-10">
        <div class="row justify-content-center">
            <div class="col-md-8" style="max-width: 670px;">
                <div class="card bg-light text-dark"> <!-- Apply dark theme to the card -->
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">Please Enter Your Connection Credentials</h5>
                        </div>                     
                        <form action="index.php" method="POST">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group mb-3">
                                <!-- user name input -->
                                <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username">
                                <div class="input-group-append">
                                    <span class="input-group-text">@</span>
                                </div>
                                <!-- server host input (static set) -->
                                <input type="text" class="form-control" id="serverInput" name="server" value="localhost" aria-label="Server" disabled>
                            </div>
                            <div class="mb-3">
                                <!-- password input -->
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="mb-3">
                                <label for="database" class="form-label">Database</label>
                                <select class="form-control" id="database" name="database">
                                    <option value="baseball_01">baseball_01</option>
                                </select>
                            </div>
                            <!-- Display errors if present -->
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            <div class="text-center"> <!-- Add text-center class here -->
                                <button type="submit" class="btn btn-success" name="user_login">Connect to Databse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>