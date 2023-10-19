<!--

Andrew McCloud

September 14, 2023

Professor Voelcker

Module 8 Coding Assignment

-->

<?php
// Include the database connection file to connect to the database
include 'databaseConnection.php';

// If the 'Query Table' button is clicked
if(isset($_POST['queryTableBtn'])){

    // Create an sql statement to query the table data
    $sqlQuery = "SELECT * FROM golfers";

    // Use try/catch to catch any errors with executing the sql statement
    try{

        // Run the sql statement on the database and assign the values to a results variable
        $results = $conn->query($sqlQuery);

        ?>
        <!-- Create a table to display the results -->
        <table class="table table-bordered table-striped">

            <!-- Give the table headers -->
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Birth County</th>
                <th>Date of Birth</th>

            </tr>

        <?php

        // If there is atleast 1 row in the results
        if($results->num_rows > 0){

            // Use a while loop to run through all of the results
            while($row = mysqli_fetch_assoc($results)){

                ?>
                <!-- Display the results -->
                <tr>
                    <td><?php echo $row['firstName']?></td>
                    <td><?php echo $row['lastName']?></td>
                    <td><?php echo $row['age']?></td>
                    <td><?php echo $row['birthCountry']?></td>
                    <td><?php echo $row['dateOfBirth']?></td>
                </tr>

                <?php

            }

        }

        ?>

        </table>

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