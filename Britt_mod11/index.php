<!--
index.php
Module 11 Assignment
Name: Brittany Kyncl
Date: 10.2.23
Course: CSD440
This script serves as the main interface for interacting with the "Planets" table.
    - It includes functionality to create, populate, drop, query, and generate a PDF of the table.
    - Bootstrap is used for styling and responsiveness.
    - Messages about the status of operations and error messages are displayed to the user.
-->
<?php
// Include the db connection file using require_once
require_once("tbl_creation/db_connect.php");

// Inlcude other functional files
include("tbl_creation/BrittCreateTable.php");
include("tbl_creation/BrittPopTable.php");
include("tbl_creation/BrittDropTable.php");
include("tbl_creation/BrittQueryTable.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Mod 11 Assignment</title>
    <style>
        .list-group-item button {
            min-width: 130px;
            margin-left: 10px;
        }
    </style>
</head>
<script>
    function getPDF(filename) {
        window.open(filename);
    }
</script>
<body class="bg-dark text-light"> <!-- Apply dark theme to the entire body -->
    <nav class="navbar navbar-expand-lg fs-3 mb-5" style="background-color: black; min-height: 65px;">
        <div class="d-flex mr-auto">
            <h5 style="padding-left: 25px;" class="m-0">PLANET DATABASE</h5>
        </div>
        <div class="d-flex ml-auto">
            <h5 style="padding-right: 25px;" class="m-0">CSD-440 MOD 11</h5>
        </div>
    </nav>
    <div class="container mt-10" style="padding-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card bg-light text-dark"> <!-- Apply dark theme to the card -->
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title" style="padding: 20px;">Welcome, use this menu to create, populate, drop, query, and generate a PDF of the "Planets" table</h5>
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
                            <?php elseif (isset($_GET['errorMessage'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo urldecode($_GET['errorMessage']); ?>
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