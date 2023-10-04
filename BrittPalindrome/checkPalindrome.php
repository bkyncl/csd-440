<!--
checkPalindrome.php
Module 4 Assignment
Name: Brittany Kyncl
Date: 8.27.23
Course: CSD440
Defines functions to check if a string is a palindrome and generate palindromeData, a custom display based on isPalindrome($str) results. 
It also handles form submission to display palindrome results for user input.
-->
<?php
/**
 * Checks if a given string is a palindrome.
 * 
 * @param string $str The input string to check.
 * @return bool True if the string is a palindrome, false otherwise.
 */
function isPalindrome($str) {
    // Convert the input string to lowercase and remove non-alphanumeric characters
    $cleanedStr = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($str));
    
    // Compare the cleaned string with its reverse
    return $cleanedStr === strrev($cleanedStr);
}
/**
 * Generates display data (palindromeData) based on returned 'isPalindrome()' result for an array of input strings.
 * 
 * @param mixed $input An array of input strings or a single input string.
 * @return array An array of data containing original string, reverse string, and palindrome result.
 */
function generatePalindromeData($input) {
    if (!is_array($input)) {
        $input = [$input]; // Convert single input to an array for uniform processing
    }

    $data = [];

    foreach ($input as $testString) {
        // generate output result for each test string
        $data[] = [
            'string' => $testString,
            'reverseString' => strtolower(strrev($testString)),
            'isPalindrome' => isPalindrome($testString) ? 'Yes' : 'No'
        ];
    }

    return $data;
}
// 8 test strings for static palindrome example display
$testStrings = array(
    'Deified',
    'Racecar',
    'Elephant',
    'Madam',
    'Fantastic',
    'Radar',
    'Computer',
    'Basketball'

);

// handle form submission of user input
if (isset($_POST['submit'])) {
    $userInput = isset($_POST['userInput']) ? trim($_POST['userInput']) : '';

    if (!empty($userInput)) {
        // Validate and sanitize the user input if needed
        // Process the input and generate palindrome data
        $palindromeData = generatePalindromeData($userInput);
    } else {
        // dipslay an error message if the user input is empty
        $errorMessage = "Please enter a valid word or phrase.";
    }
}

?>