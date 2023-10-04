<!--
BrittMyInteger.php
Module 6 Assignment
Name: Brittany Kyncl
Date: 9.3.23
Course: CSD440
Demonstrates the usage of the 'BrittMyInteger' class by allowing users to input integer values. 
It then instantiates objects of the 'BrittMyInteger' class or sets a new value for a selected object with the user-input values and tests the class methods on these objects.
Class methods: 'isEven,' 'isOdd,' and 'isPrime,' results testing displayed in table.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mod 6 Assignment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <p>
            Brittany Kyncl<br>
            9.3.23<br>
            CSD 440 Module 6 Assignment
        </p>
    </div>
    <h1>PHP BrittMyInteger Class Tester</h1>
    <div class="content">
        <table class="input-table">
            <!-- Form for user input obj creation and testing- -->
            <form method="POST">
                <th>Input a integer value to instantiate a 'BrittanyMyInteger' object with.</th>
                <tr>
                    <td>
                        <!-- User input field for obj value-->
                        <input type="text" name="userInput" placeholder="Enter a value">
                        <?php if (isset($errorMessageObjCreation)) { ?>
                            <!-- Display error message if any -->
                            <p class="error-message"><?php echo "<br>" . $errorMessageObjCreation; ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit" name="submitObjCreation">Enter</button></td>
                </tr>
            </form>            
        </table>
        <?php if (isset($userIntObj)) { ?>
            <!-- Display user input object creation testing results table if available -->
            <table class="output-table" id="user-table">
                <tr><th colspan="2">YourInteger Obj Testing Results</th></tr>
                <tr>
                    <th>Your Integer Obj Value</th>
                    <th>Class Methods & Results</th>
                </tr>
                <tr>
                    <td>
                        <span style="font-weight: bold;" ><?php echo "\$yourIntObj = " . $userIntObj->getValue()?></span>
                    </td>
                    <td>
                        <div class="output-row">
                            <div class="label-container align-right">
                                <span class="label">isEven():</span>
                                <span class="label">isOdd():</span>
                                <span class="label">isPrime():</span>
                            </div>
                            <div class="result-container">
                                <span class="result"><?php echo ($userIntObj->isEven() ? "Yes" : "No"); ?></span>
                                <span class="result"><?php echo ($userIntObj->isOdd() ? "Yes" : "No"); ?></span>
                                <span class="result"><?php echo ($userIntObj->isPrime() ? "Yes" : "No"); ?></span>
                            </div>
                        </div>
                    </td>
                </tr> 
            </table>
        <?php } ?>
    </div>
    <div class="content">
        <table class="input-table">
            <!-- Form for user input obj value setting and testing-->
            <form method="post">
                <th>Select a predefined 'BrittanyMyInteger' object to set a new value.</th>
                <tr>
                    <td>
                        <!-- Dropdown menu for selecting a predefined object -->
                        <select name="selectedObject">
                            <?php foreach ($myIntObjs as $index => $intObj) : ?>
                                <option value="<?php echo $index; ?>"><?php echo "\$intObj_$index"; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- User input field for a new integer value -->
                        <input type="text" name="newIntValue" placeholder="Enter a value">
                        <?php if (isset($errorMessageObjSetting)) { ?>
                            <!-- Display error message if any -->
                            <p class="error-message"><?php echo "<br>" . $errorMessageObjSetting; ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit" name="submitObjSetting">Set Value</button></td>
                </tr>
            </form>            
        </table>
        <?php if (isset($userIntObjSetting)) { ?>
            <!-- Display user input object value setting testing results table if available -->
            <table class="output-table" id="user-table">
                <tr><th colspan="2">New Value IntObj Testing Results</th></tr>
                <tr>
                    <th>New Integer Obj Value</th>
                    <th>Class Methods & Results</th>
                </tr>
                <tr>
                    <td>
                        <span style="font-weight: bold;" ><?php echo "\$IntObj_$selectedObjectIndex = " . $userIntObjSetting->getValue()?></span>
                    </td>
                    <td>
                        <div class="output-row">
                            <div class="label-container align-right">
                                <span class="label">isEven():</span>
                                <span class="label">isOdd():</span>
                                <span class="label">isPrime():</span>
                            </div>
                            <div class="result-container">
                                <span class="result"><?php echo ($userIntObjSetting->isEven() ? "Yes" : "No"); ?></span>
                                <span class="result"><?php echo ($userIntObjSetting->isOdd() ? "Yes" : "No"); ?></span>
                                <span class="result"><?php echo ($userIntObjSetting->isPrime() ? "Yes" : "No"); ?></span>
                            </div>
                        </div>
                    </td>
                </tr> 
            </table>
        <?php } ?>
    </div>
    <div class="content">
        <!-- Display MyInteger testing results table -->
        <table class="output-table" id="example-table">
            <tr><th colspan="2">MyInteger Obj Testing Results</th></tr>
            <tr>
                <th>Integer Obj Value</th>
                <th>Class Methods & Results</th>
            </tr>
            <?php foreach ($myIntObjs as $index => $intObj) : ?>
                <tr>
                    <td>
                        <span style="font-weight: bold;" ><?php echo "\$intObj_$index = " . $intObj->getValue()?></span>
                    </td>
                    <td>
                        <div class="output-row">
                            <div class="label-container align-right">
                                <span class="label">isEven():</span>
                                <span class="label">isOdd():</span>
                                <span class="label">isPrime():</span>
                            </div>
                            <div class="result-container">
                                <span class="result"><?php echo ($intObj->isEven() ? "Yes" : "No"); ?></span>
                                <span class="result"><?php echo ($intObj->isOdd() ? "Yes" : "No"); ?></span>
                                <span class="result"><?php echo ($intObj->isPrime() ? "Yes" : "No"); ?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>