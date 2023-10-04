<!--
brittPalindrome.php
Module 4 Assignment
Name: Brittany Kyncl
Date: 8.26.23
Course: CSD440
This HTML and PHP page serves as a Palindrome Checker application. 
It allows users to input a word or phrase, checks if it's a palindrome using the checkPalindrome.php script, and displays the results in a table format.
It also display static palindrome examples in the same table format.
Imports: 
'checkPalindrome.php' script to handle palindrome checking logic, form submission, and palindromeData display.
'style.css' external styling
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Table Example</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'checkPalindrome.php' ?>
    <div class="header">
        <p>
            Brittany Kyncl<br>
            8.27.23<br>
            CSD 440 Module 4 Assignment
        </p>
    </div>
    <h1>Palindrome Checker!</h1>
    <div class="content">
        <table class="input-table">
            <!-- Form for user input -->
            <form method="post">
                <th>Enter a word or phrase to check if it is a palindrome.</th>
                <tr>
                    <td>
                        <!-- User input field -->
                        <input type="text" name="userInput" placeholder="Enter a word or phrase">
                        <?php if (isset($errorMessage)) { ?>
                            <!-- Display error message if any -->
                            <p class="error-message"><?php echo "<br>" . $errorMessage; ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit" name="submit">Enter</button></td>
                </tr>
            </form>            
        </table>
        <?php if (isset($palindromeData)) { ?>
            <!-- Display user input palindrome results table if available -->
            <table class="output-table" id="user-table">
                <tr><th colspan="3">Results</th></tr>
                <?php foreach ($palindromeData as $item) { ?>
                    <tr>
                        <td>
                            <div class="output-row">
                                <div class="label-container align-right">
                                    <span class="label">Your String:</span>
                                    <span class="label">Reverse String:</span>
                                    <span class="label">Is Palindrome:</span>
                                </div>
                                <div class="result-container">
                                    <span class="result"><?php echo $item['string']; ?></span>
                                    <span class="result"><?php echo $item['reverseString']; ?></span>
                                    <span class="result"><?php echo $item['isPalindrome']; ?></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>               
            </table>
        <?php } ?>
    </div>
    <div class="content">
        <!-- Display static palindrome examples table -->
        <table class="output-table" id="example-table">
            <tr><th colspan="3">Palindrome Examples</th></tr>
            <?php foreach (generatePalindromeData($testStrings) as $item) { ?>
                <tr>
                    <td>
                        <div class="output-row">
                            <div class="label-container align-right">
                                <span class="label">String:</span>
                                <span class="label">Reverse String:</span>
                                <span class="label">Is Palindrome:</span>
                            </div>
                            <div class="result-container">
                                <span class="result"><?php echo $item['string']; ?></span>
                                <span class="result"><?php echo $item['reverseString']; ?></span>
                                <span class="result"><?php echo $item['isPalindrome']; ?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>