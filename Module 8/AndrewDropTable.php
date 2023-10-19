<!--

Andrew McCloud

September 14, 2023

Professor Voelcker

Module 8 Coding Assignment

-->

<?php
// Include the database connection file to connect to the database
include 'databaseConnection.php';

// If the 'Drop Table' button is clicked
if(isset($_POST['dropTableBtn'])){

    // Create an sql statement to be ran on the database
    $sqlDrop = "DROP TABLE IF EXISTS golfers";

    // Use try/catch to catch any errors with executing the sql statement
    try{

        // Execute the sql statement in the table
        $conn->query($sqlDrop);

        ?>
            <!-- Display a success message -->
            <h2>Table has been successfully dropped</h2>

        <?php

    // If there is an error executing the sql statement, the code will go here
    }catch (Exception $e){

        ?>
        <!-- Display an error message -->
        <h2>There was an error dropping the table</h2>

        <?php

    }

}

?>