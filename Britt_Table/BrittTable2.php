<!--
BrittTable2.php
Module 2 Assignment
Name: Brittany Kyncl
Date: 8.8.23
Course: CSD440
Generates a two dimensional table (11X11 grid including col/row headers) of random numbers using a nested PHP forloop
Outer row and column headers numbers are generated dynamically from PHP for loop counter variables
Inner table data random numbers (10X10) grid generated within nested loops where each outer loop
generates each data row and each inner loop generates each td cell. Inner loop call rand() function bound 1-100
within td cell to create random number.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Table Example</title>
    <style>
        body {
            margin: 0 auto;
            font-family: Arial, sans-serif;
            background-color: #ffefd5;
        }
        .header {
            font-size: 18px;
            color: #ffff;
            padding: 20px 0px 5px 40px;
            background-color: #3b3c36;
            border-bottom: 10px solid;
            border-color: #b0bf1a;
        }
        h1 {
            text-align: center;
        }
        .content {
            display: flex;
            justify-content: center;
            margin: 0 auto;
            text-align: center;
            padding: 15px;
        }
        #num-table {
            border-collapse: separate;
            border-spacing: 3px;
            border: 3px solid;
            border-radius: 10px;
            border-color:#3b3c36
        }
        #num-table th {
            background-color: #3b3c36;
            color: #ffff;
        }
        #num-table td,th{
            border-radius: 10px;
            padding: 15px;
        }
        #num-table tr:nth-child(even) {
            background-color: #b0bf1a;
        }
        #num-table tr:nth-child(odd) {
            background-color: white;
        }
    </style>
</head>
<body>

    <div class="header">
        <p>
        Brittany Kyncl<br>
        8.8.23<br>
        CSD 440 Module 2 Assignment</p>
    </div>

    <h1>Table of Randomly Generated Numbers</h1>

    <div class="content">
        <table id="num-table">
            <tr>
                <th></th> <!-- Empty cell for the top-left corner -->
                <?php for ($column = 1; $column <= 10; $column++) { // Create table header cells for column numbers using for loop ?>
                    <th>Col: <?= $column ?></th>
                <?php } ?>
            </tr>

            <?php for ($row = 1; $row <= 10; $row++) { // Outer loop of nested for loop that creates each data row ?>
                <tr>
                    <th>Row: <?= $row ?></th> <!-- Table header cell for row number -->
                    <?php for ($column = 1; $column <= 10; $column++) { // Nested inner loop that creates each data cell in the row ?>
                        <td><?= rand(0, 100); // Generate random number using rand() funtion with range of 0-100 ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>

        </table>
    </div>

</body>
</html>