<!--
BrittMyIntegerClass.php
Module 6 Assignment
Name: Brittany Kyncl
Date: 9.3.23
Course: CSD440
Defines the 'BrittanyMyInteger' class, which is designed for handling integer operations. 
It includes methods to check if the stored integer is even, odd, or prime, with getters and setters for the value. 

The 'BrittanyMyInteger' class methods are described as follows:
- 'isEven()': Checks if the stored integer is even.
- 'isOdd()': Checks if the stored integer is odd.
- 'isPrime()': Checks if the stored integer is prime.
- 'getValue()': Gets the stored integer value.
- 'setValue()': Sets the integer value.

Additional created array of 'BrittanyMyInteger' objects for testing
-->
<?php
/**
 * MyInteger Class for handling integer operations.
 */
class BrittanyMyInteger {
    private $value;

    /**
     * Constructor to initialize the MyInteger object with an integer.
     *
     * @param int $value The integer value to be stored.
     */
    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * Check if the stored integer is even.
     *
     * @return bool True if the integer is even, false otherwise.
     */
    public function isEven() {
        return $this->value % 2 === 0;
    }

    /**
     * Check if the stored integer is odd.
     *
     * @return bool True if the integer is odd, false otherwise.
     */
    public function isOdd() {
        return $this->value % 2 !== 0;
    }

    /**
     * Check if the stored integer is prime.
     *
     * @return bool True if the integer is prime, false otherwise.
     */
    public function isPrime() {
        if ($this->value <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($this->value); $i++) {
            if ($this->value % $i === 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the stored integer value.
     *
     * @return int The stored integer value.
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Set the integer value.
     *
     * @param int $value The new integer value to set.
     */
    public function setValue($value) {
        $this->value = $value;
    }
}

// Create an array of BrittanyMyInteger objects for testing
$myIntObjs = array ( 
    $intObj_0 = new BrittanyMyInteger(7),
    $intObj_1 = new BrittanyMyInteger(12),
    $intObj_2 = new BrittanyMyInteger(20),
    $intObj_3 = new BrittanyMyInteger(5),
    $intObj_4 = new BrittanyMyInteger(8),
    $intObj_5 = new BrittanyMyInteger(13),
    $intObj_6 = new BrittanyMyInteger(14),
    $intObj_7 = new BrittanyMyInteger(18),
    $intObj_8 = new BrittanyMyInteger(20),
    $intObj_9 = new BrittanyMyInteger(30)
);

// Initialize variables for form 1
$userIntObj = null;
$errorMessageObjCreation = null;

// Initialize variables for form 2
$userIntObjSetting = null;
$errorMessageObjSetting = null;
// Initialize the selected index variable
$selectedObjectIndex = null;

// Check which form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Form 1: Object Creation and Testing
    if (isset($_POST['submitObjCreation'])) {
        // Validate and process form 1 data
        $userInput = $_POST['userInput'];
        
        if (!is_numeric($userInput) || $userInput != (int)$userInput) {
            $errorMessageObjCreation = "Input must be a valid integer.";
        } else {
            $userIntObj = new BrittanyMyInteger($userInput);
        }
    }
    
    // Form 2: Object Value Setting and Testing
    if (isset($_POST['submitObjSetting'])) {
        // Validate and process form 2 data
        $selectedObjectIndex = $_POST['selectedObject'];
        $newIntValue = $_POST['newIntValue'];
        
        if (!is_numeric($newIntValue) || $newIntValue != (int)$newIntValue) {
            $errorMessageObjSetting = "Input must be a valid integer.";
        } else {
            // Set the new value for the selected object
            if (isset($myIntObjs[$selectedObjectIndex])) {
                $myIntObjs[$selectedObjectIndex]->setValue($newIntValue);
                $userIntObjSetting = $myIntObjs[$selectedObjectIndex];
            }
        }
    }
}

?>