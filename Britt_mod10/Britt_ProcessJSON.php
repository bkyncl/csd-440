<?php
/*
Britt_ProcessJSON.php
Module 10 Assignment
Name: Brittany Kyncl
Date: 10.1.23
Course: CSD440
Description:
Script to process user-submitted data from BrittJSON.php form. 
It performs validation and sanitization of the submitted data and stores it in JSON format for later display.

Data Processing Steps:
1. Initialize an empty errors array to capture validation errors.
2. Define an array of required field names.
3. Initialize an associative array, $formData, to store form data.
4. Check if all required fields are filled out, setting $allFieldsFilled accordingly.
5. If all required fields are filled, proceed with data validation.
6. Validate and sanitize the First Name, Last Name, Age, Date of Birth, Email, Phone Number, Street Address, City, State, Zip Code, and Country fields.
7. Store validated and sanitized values in the $formData array.
8. If any required fields are empty, add a single 'All fields must be filled out.' error message to the errors array.
9. If there are no validation errors, remove trailing spaces from each value in $formData.
10. Encode the sanitized form data as JSON using JSON_PRETTY_PRINT for readability.

*/
if (isset($_POST['JSON_form_submit'])) {
    // Initialize the errors array
    $errors = [];   

    // Required field names
    $requiredFields = ['firstname', 'lastname', 'age', 'dob', 'email', 'phone', 'street', 'city', 'state', 'zip', 'country'];

    // Initialize an associative array to store form data
    $formData = array();
    
    // Check if all required fields are filled out
    $allFieldsFilled = true;
    foreach ($requiredFields as $fieldName) {
        if (empty($_POST[$fieldName])) {
            $allFieldsFilled = false;
            break; // No need to check further if one field is empty
        }
    }

    // All required fields are filled out, proceed with data validation
    if ($allFieldsFilled) {
        // Validate and sanitize First Name
        $firstname = $_POST['firstname'];
        if (!preg_match("/^[a-zA-Z]+$/", $firstname)) {
            $errors[] = 'First Name should only contain letters.';
        } else {
            $formData['firstname'] = htmlspecialchars($firstname); // Add to formData
        }

        // Validate and sanitize Last Name
        $lastname = $_POST['lastname'];
        if (!preg_match("/^[a-zA-Z]+$/", $lastname)) {
            $errors[] = 'Last Name should only contain letters.';
        } else {
            $formData['lastname'] = htmlspecialchars($lastname); // Add to formData
        }

        // Validate and sanitize Age
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        if ($age === false || $age < 1) {
            $errors[] = 'Age must be a positive number.';
        } else {
            $formData['age'] = htmlspecialchars($age); // Add to formData
        }

        // Validate and sanitize Date of Birth
        $dob = $_POST['dob'];
        if (!strtotime($dob) || strtotime($dob) >= time()) {
            $errors[] = 'Date of Birth must be a valid date before today.';
        } else {
            $formData['dob'] = htmlspecialchars($dob); // Add to formData
        }

        // Validate and sanitize Email
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            $errors[] = 'Invalid email format.';
        } else {
            $formData['email'] = filter_var($email, FILTER_SANITIZE_EMAIL); // Add to formData
        }

        // Validate and sanitize Phone Number
        $phoneNumber = $_POST['phone'];
        if (!preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $phoneNumber)) {
            $errors[] = 'Invalid phone number format.';
        } else {
            $formData['phone'] = htmlspecialchars($phoneNumber); // Add to formData
        }

        $formData['street'] = htmlspecialchars($_POST['street']); // Add to formData

        // Validate and sanitize City
        $city = $_POST['city'];
        if (!preg_match("/^[a-zA-Z\s\-]+$/", $city)) {
            $errors[] = 'Invalid City format. Please use only letters, spaces, and hyphens.';
        } else {
            $formData['city'] = htmlspecialchars($city); // Add to formData
        }

        $formData['state'] = htmlspecialchars($_POST['state']); // Add to formData

        // Validate and sanitize Zip Code
        $zip = $_POST['zip'];
        if (!preg_match("/^\d{5}(?:-\d{4})?$/", $zip)) {
            $errors[] = 'Invalid Zip Code format.';
        } else {
            $formData['zip'] = htmlspecialchars($zip); // Add to formData
        }

        $formData['country'] = htmlspecialchars($_POST['country']); // Add to formData


    } else {
        // If any of the required fields are empty, add a single error message
        $errors[] = 'All fields must be filled out.';
    }
  

    // If there are no errors, proceeding with form processing
    if (empty($errors)) {

        // jsonErrorMessage testing value flagging false return
        // $data = ["invalid_utf8" => "\xB1\x31"];

        // Remove trailing spaces from each value in $formData
        foreach ($formData as &$value) {
            $value = trim($value);
        }

        // Encode form data as JSON
        $jsonData = json_encode($formData, JSON_PRETTY_PRINT);

        // Check if JSON encoding was successful
        if ($jsonData === false) {
            // JSON encoding failed, display an error message
            $jsonErrorMessage = json_last_error_msg();
            $jsonErrors[] = 'Error encoding data into JSON format: ' . $jsonErrorMessage;
        }
            
    } 
}
?>