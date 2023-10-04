<!--
brittCustomers.php
Module 5 Assignment
Name: Brittany Kyncl
Date: 9.2.23
Course: CSD440
This HTML/PHP file serves as display/user interaction component of customer search system.
It provides a user interface for searching and displaying customer data.
Users can search for customers by various criteria.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mod 5 Assignment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'customer_manage.php' ?>
    <div class="header">
        <p>
            Brittany Kyncl<br>
            9.2.23<br>
            CSD 440 Module 5 Assignment
        </p>
    </div>
    <div class="content">
        <form class="entry-form" method="POST">
            <table class="input-table">
                <!-- Form for user input -->
                <th colspan="2">Search For Customer</th>
                <tr>
                    <td>Search Key:</td>
                    <td>
                        <select class="drop-down" name="search_key">
                            <option value="first_name">First Name</option>
                            <option value="last_name">Last Name</option>
                            <option value="age">Age</option>
                            <option value="phone">Phone</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Search Value:</td>
                    <td>
                        <input type="text" name="search_value">
                        <?php if (!empty($errors)) : ?>
                            <ul class="error-list">
                                <?php foreach ($errors as $error) : ?>
                                    <li class="error"><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" name="search_submit">Search Customer</button></td>
                </tr>
            </table>
        </form>
        <?php
            // Check if the search results are available (after form submission)
            // call displayAllCustomers with returned search results array
            if (isset($searchResults)) {
                ?>
                <table class="output-table" id="user-table">
                    <tr><th colspan="4">Search Results</th></tr>
                    <tbody>                       
                        <?php displayAllCustomers($searchResults); ?>
                    </tbody>            
                </table>
                <?php
            }
        ?>
    </div>
    <div class="content">
        <!-- Display all customers -->
        <table class="output-table" id="example-table">
            <tr><th colspan="4">All Customers</th></tr>
            <tbody>
                <?php // Call displayAllCustomers with full customers array
                displayAllCustomers($customers); ?>
            </tbody>
        </table>
    </div>
</body>
</html>