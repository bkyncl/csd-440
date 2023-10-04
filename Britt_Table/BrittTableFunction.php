<!--
BrittTableFunction.php
Module 3 Assignment
Name: Brittany Kyncl
Date: 8.26.23
Course: CSD440
File contains custom functions intented for use in 'BrittTable3.php'
A function with generates and returns the sum of two number parameters
A function that generates and returns HTML code for table header columns 
with the specified number of columns.
-->
<?php
/**
 * This function takes two numbers as parameters and returns their sum.
 *
 * @param int $num1 The first number.
 * @param int $num2 The second number.
 * @return int The sum of the two input numbers.
 */
function generateSum($num1, $num2) {
    return $num1 + $num2;
}

/**
 * This function generates and returns HTML code for table header columns based on the
 * specified number of columns.
 *
 * @param int $numColumns The number of columns for the table.
 * @return string HTML code for table header columns.
 */
function generateColumnNumbers($numColumns) {
    $headerColumn = '<tr><th></th>';
    
    for ($column = 1; $column <= $numColumns; $column++) {
        $headerColumn .= "<th>Col: $column</th>";
    }
    
    $headerColumn .= '</tr>';
    return $headerColumn;
}

?>
