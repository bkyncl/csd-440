<!--
BrittForm.php
Module 7 Assignment
Name: Brittany Kyncl
Date: 9.10.23
Course: CSD440
This file represents a user registration form including username, email, password, country, gender, date of birth, 
display color preference, and language selection.
Upon submission, the form data is sent to "BrittResponse.php" for processing. 
The form processing and validation are done in the external "process_form.php" file, 
which is included in "BrittResponse.php." The form processing validation to ensure that all fields are populated correctly. 
If any errors occur during validation, appropriate error messages are displayed. Otherwise, a well-formatted user profile is shown.
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
    <div class="content">
        <form class="entry-form" action="BrittResponse.php" method="POST">
            <table class="input-table">
                <!-- Form for user input -->
                <th colspan="2">User Account Registration</th>
                <tr>
                    <td><strong>Enter User Name:</strong></td>
                    <td><input type="text" name="user_name"></td>
                </tr>
                <tr>
                    <td><strong>Enter Email:</strong></td>
                    <td><input type="text" name="user_email"></td>
                </tr>
                <tr>
                    <td><strong>Enter Passowrd:<br>
                                -8 Characters <br>
                                -At least 1 letter & 1 digit</strong></td>
                    <td><input type="password" name="user_password"></td>
                </tr>
                <tr>
                    <td><strong>Re-Type Passowrd:</strong></td>
                    <td><input type="password" name="user_password_match"></td>
                </tr>
                <tr>
                    <!-- Dropdown Menu -->
                    <td><strong>Country:</strong></td>
                    <td>
                        <select class="drop-down" name="country">
                            <?php
                            // Array of countries 
                            $countries = array(
                                "None",
                                "Russia",
                                "Canada",
                                "China",
                                "United States",
                                "Brazil",
                                "Australia",
                                "India",
                                "Argentina",
                                "Kazakhstan",
                                "Algeria",
                                "Democratic Republic of the Congo",
                                "Greenland (Denmark)",
                                "Saudi Arabia",
                                "Mexico",
                                "Indonesia",
                                "Sudan",
                                "Libya",
                                "Iran",
                                "Mongolia",
                                "Peru"
                            );
                            // Generate <option> elements for each country
                            foreach ($countries as $country) {
                                echo "<option value=\"" . htmlspecialchars($country) . "\">" . htmlspecialchars($country) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <!-- Dropdown Menu -->
                <tr>
                    <td><strong>Gender:</strong></td>
                    <td>
                        <select class="drop-down" name="gender">
                            <option value="None">None</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Non-Binary">Non-Binary</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Date of Birth:</strong></td>
                    <td><input type="date" name="date_of_birth" max="<?php echo date('Y-m-d'); ?>"></td>
                </tr>
                <!-- Radio Button Selection Group -->
                <tr>
                    <td><strong>Select Display Color:</strong></td>
                    <td>
                        <input type="radio" name="radio_group" value="blue" checked> Blue
                        <input type="radio" name="radio_group" value="red"> Red
                        <input type="radio" name="radio_group" value="green"> Green
                        <input type="radio" name="radio_group" value="purple"> Purple
                    </td>
                </tr>
                <!-- Checkbox Selection Group -->
                <tr>
                    <td><strong>Select Language(s):</strong></td>
                    <td class="checkbox-container">
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Chinese"> Chinese (Mandarin)</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Spanish"> Spanish</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="English"> English</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Hindi"> Hindi</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Arabic"> Arabic</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Bengali"> Bengali</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Portuguese"> Portuguese</div>
                        <div class="checkbox"><input type="checkbox" name="checkbox_group[]" value="Russian"> Russian</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" name="registration_submit">Register</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>