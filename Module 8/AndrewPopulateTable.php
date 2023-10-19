<!--

Andrew McCloud

September 14, 2023

Professor Voelcker

Module 8 Coding Assignment

-->

<?php
// Include the database connection file to connect to the database
include 'databaseConnection.php';

// If the 'Populate Table' button is clicked
if(isset($_POST['populateTableBtn'])){

    // Create an sql statement to be ran on MySQL to populate the table
    $sqlPopulate = "INSERT INTO golfers VALUES 
    ('Jordan', 'Spieth', 30, 'Unites States', '1993-07-27'),
    ('Rory', 'Mcllroy', 34, 'United Kingdom', '1989-05-04'),
    ('Cameron', 'Smith', 30, 'Australia', '1993-08-18');";

    // Use Try/Catch to try and run the SQL statement and catch if any errors occurred
    try{

        // Run the sql statement on the database
        $conn->query($sqlPopulate);

        ?>
            <!-- Display a success message -->
            <h2>Table has been successfully populated</h2>

        <?php

    // If an error was caught with running the sql statement on the database
    }catch (Exception $e){

        ?>
        <!-- Display an error message -->
        <h2>There was an error populating the table</h2>

        <?php

    }

}

?>