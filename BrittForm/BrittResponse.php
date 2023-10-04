<!--
BrittResponse.php
Module 7 Assignment
Name: Brittany Kyncl
Date: 9.10.23
Course: CSD440
This file serves as the response page for user registration. 
It processes the data submitted from the "BrittForm.php" registration form.
Upon form submission, this script includes the "process_form.php" script to handle data processing 
and validation. It captures the result of the processing, which includes CSS styles, displayed data, 
and potential validation errors.
If there are validation errors, this script displays them to the user.
If there are no errors, this script displays a well-formatted user profile.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mod 7 Assignment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <p>
            Brittany Kyncl<br>
            9.10.23<br>
            CSD 440 Module 7 Assignment
        </p>
    </div>
    <?php
    // Include the process_form.php script and capture its result
    $result = include('process_form.php');

    // Display the styles
    echo $result['styles'];

    // Check if there are any errors
    if (!empty($result['errors'])) {
        // Handle and display errors
        echo "<div class='content'>";
        echo "<form class='entry-form' method='POST'>";
        echo "<table class='input-table'>";
        echo "<th colspan='2'>Validation Errors!</th>";
        echo "<tr><td colspan='2'><ul class='validation-errors'>";
        foreach ($result['errors'] as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></td></tr>";
        echo '<tr><td colspan="2"><button type="button" onclick="location.href=\'BrittForm.php\'">Back to Registration Form</button></td></tr>';
        echo "</table>";
        echo "</form>";
        echo "</div>";
    } else {
        // Display the data
        echo $result['styles']; // Output the generated styles
        echo "<div class='content'>";
        echo "<form class='entry-form' method='POST'>";
        echo "<table class='input-table'>";
        echo "<th colspan='2'>User Profile</th>";
        foreach ($result['displayed_data'] as $data) {
            echo $data;
        }
        echo '<tr><td colspan="2"><button type="button" onclick="location.href=\'BrittForm.php\'">Back to Registration Form</button></td></tr>';
        echo "</table>";
        echo "</form>";
        echo "</div>";
    }
    ?>
</body>
</html>