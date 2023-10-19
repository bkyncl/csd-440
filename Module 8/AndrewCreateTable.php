<!--

Andrew McCloud

September 14, 2023

Professor Voelcker

Module 8 Coding Assignment

-->

<?php
// Include the file for connecting to the database
include 'databaseConnection.php';

// If the 'Create Table' button was clicked
if(isset($_POST['createTableBtn'])){

    // Create an sql statement to create a table in the database
    $sqlCreate = "CREATE TABLE golfers (
        firstName VARCHAR(70),
        lastName VARCHAR(70),
        age INT,
        birthCountry VARCHAR(100),
        dateOfBirth DATE
    );";

    // Use try/catch to catch any errors with executing the sql statement
    try{

        // Execute the sql statement in the table
        $conn->query($sqlCreate);

        ?>
            <!-- Display a success status -->
            <h2>Table has been successfully created</h2>

        <?php

    // If there is an error executing the sql statement, the code will go here
    }catch (Exception $e){

        ?>
        <!-- Display an error status -->
        <h2>There was an error creating the table</h2>

        <?php

    }

}

?>