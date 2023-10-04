<!--
BrittTable3.php
Module 3 Assignment
Name: Brittany Kyncl
Date: 8.26.23
Course: CSD440
Table displays the sum of two random numbers in each cell of the table. 
The table includes column and row headers, and uses an external PHP function to generate the sum of two 
randomly generated numbers in 'BrittTableFunction.php'
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
            background-color: #CCE7F4
        }
        .header {
            font-size: 18px;
            color: #ffff;
            padding: 20px 0px 5px 40px;
            background-color: #0D2130;
            border-bottom: 10px solid;
            border-color: #376068;
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
            border-radius: 4px;
        }
        #num-table th {
            background-color: #376068;
            color: #ffff;
        }
        #num-table td,th{
            border-radius: 3px;
            padding: 15px;
        }
        #num-table tr:nth-child(even) {
            background-color: #F7FAF8;
        }
        #num-table tr:nth-child(odd) {
            background-color: #E0F0F2;
        }
    </style>
</head>
<body>

    <div class="header">
        <p>
        Brittany Kyncl<br>
        8.26.23<br>
        CSD 440 Module 3 Assignment</p>
    </div>

    <h1>Function to Display the Sum of Two Randomly Generated Numbers</h1>

    <?php
    include 'BrittTableFunction.php'; // include the external functions file
    ?>
    <div class="content">
        <table id="num-table">
            <?php echo generateColumnNumbers(10); //call function to generate header row with column numbers ?>

            <?php for ($row = 1; $row <= 10; $row++) { // Outer loop of nested for loop that creates each data row ?>
                <tr>
                    <th>Row: <?= $row ?></th> <!-- Table header cell for row number -->
                    <?php for ($column = 1; $column <= 10; $column++) { // Nested inner loop that creates each data cell in the row ?>
                        <td>
                            <?php                           
                            // call and display generateSum function with mt_rand(1,100) as both parameters to return sum to two random numbers
                            echo generateSum(mt_rand(1,100), mt_rand(1,100));
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>