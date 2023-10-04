<!--
process_form.php
Module 7 Assignment
Name: Brittany Kyncl
Date: 9.10.23
Course: CSD440
This script serves as the backend processing script for user registration. 
It handles data validation and processing of the user-submitted registration form from "BrittForm.php."
The script includes functions to generate CSS styles based on the selected display color, validate form fields, 
and generate appropriate error messages. It also checks for various field validations, including user name,
email, password, date of birth, and language selection.
If the form is submitted with errors, this script populates the 'errors' array with corresponding error messages. 
If the form is submitted successfully, it generates CSS styles based on the selected color, 
as well as a well-formatted table displaying the user's entered data.
-->
<?php
// Function to generate CSS styles based on selected color
function generateStyles($selectedColor) {
    // Define color settings in an associative array
    $colors = array(
        'blue' => array(
            'backgroundColor' => '#CCE7F4',
            'headerColor' => '#0D2130',
            'bordercolor' => '#376068',
            'tableHeaderColor' => '#376068',
            'tableRowColorEven' => '#F7FAF8',
            'tableRowColorOdd' => '#E0F0F2',
            'buttoncolor' => '#0D2130'
        ),
        'red' => array(
            'backgroundColor' => '#e28989',
            'headerColor' => '#ae3333',
            'bordercolor' => '#3c1111',
            'tableHeaderColor' => '#3c1111',
            'tableRowColorEven' => '#fffdfd',
            'tableRowColorOdd' => '#e7cfcc',
            'buttoncolor' => '#3c1111'
        ),
        'green' => array(
            'backgroundColor' => '#c4e5c1',
            'headerColor' => '#295f48',
            'bordercolor' => '#18392b',
            'tableHeaderColor' => '#18392b',
            'tableRowColorEven' => '#e5f2c4',
            'tableRowColorOdd' => '#eeeeee',
            'buttoncolor' => '#18392b'
        ),
        'purple' => array(
            'backgroundColor' => '#d5c7d6',
            'headerColor' => '#563b8a',
            'bordercolor' => '#3a3144',
            'tableHeaderColor' => '#563b8a',
            'tableRowColorEven' => '#f8f2f6',
            'tableRowColorOdd' => '#e5d0ff',
            'buttoncolor' => '#3a3144'
        )
    );

    // Default to blue if the selected color is not found
    $colorSettings = $colors[$selectedColor] ?? $colors['blue'];

    // Generate and return inline CSS styles
    return "
        <style>
            body {
                background-color: {$colorSettings['backgroundColor']};
            }
            .header {
                background-color: {$colorSettings['headerColor']};
                border-color: {$colorSettings['bordercolor']};
            }
            table.input-table th {
                background-color: {$colorSettings['tableHeaderColor']};
            }
            .input-table tr:nth-child(even) {
                background-color: {$colorSettings['tableRowColorEven']};
            }
            .input-table tr:nth-child(odd) {
                background-color: {$colorSettings['tableRowColorOdd']};
            }
            .input-table button {
                background-color: {$colorSettings['buttoncolor']};
            }
        </style>
    ";
}


// Initialize an empty result array to store styles, displayed data, and errors
$result = array(
    'styles' => '',
    'displayed_data' => array(),
    'errors' => array(),
);

// Function to validate a field and add an error message if validation fails
function validateField($fieldName, $errorMessage = null, $customValidation = null) {
    global $result;
    if (!isset($_POST[$fieldName]) || empty($_POST[$fieldName]) || ($customValidation && !$customValidation($_POST[$fieldName]))) {
        $result['errors'][$fieldName] = $errorMessage ?? ucfirst($fieldName) . ' is required.';
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation checks for various form fields (user name, email, password, etc.)
    
    validateField("user_name"); // Validate User Name
   
    validateField("user_email", "Invalid email format.", function($value) {  // Validate Email
        // Use FILTER_VALIDATE_EMAIL to check if the email format is valid
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    });
    
    // Validate Password
    validateField("user_password", "Password must be at least 8 characters long and contain at least one letter and one digit.", function($value) {
        return strlen($value) >= 8 && (preg_match("/[a-zA-Z]/", $value) && preg_match("/\d/", $value));
    });

    // Validate Re-Type Password
    validateField("user_password_match", "Passwords do not match.", function($value) {
        return isset($_POST['user_password']) && $value === $_POST['user_password'];
    });

    validateField("date_of_birth", "Date of Birth is required.", function($value) { // Validate Date of Birth
        $dob = new DateTime($value);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dob)->y;
        return $age >= 18;
    });

    
    validateField("checkbox_group", "Please select at least one language.", function($value) { // Validate Selected Language(s)
        return is_array($value) && count($value) > 0;
    });

    // Check if there are any validation errors
    if (empty($result['errors'])) {
        // Create an associative array to map form field names to labels
        $field_labels = array(
            "user_name" => "User Name",
            "user_email" => "Email",
            "user_password" => "Password",
            "country" => "Country",
            "gender" => "Gender",
            "date_of_birth" => "Date of Birth",
            "radio_group" => "Selected Color",
            "checkbox_group" => "Selected Language(s)"
        );

        // Check if a color option was selected
        if (isset($_POST["radio_group"])) {
            $selectedColor = $_POST["radio_group"];
            // Generate the CSS styles based on the selected color
            $result['styles'] = generateStyles($selectedColor);
        }

        // Create an empty array to store the displayed form data
        $displayed_data = array();

        // Iterate through the field labels and retrieve and display the form data
        foreach ($field_labels as $field_name => $label) {
            if (isset($_POST[$field_name])) {
                $value = $_POST[$field_name];
                // Handle checkbox selections
                if ($field_name == "checkbox_group" && is_array($value)) {
                    $displayed_data[] = "<tr><td><strong>$label:</strong></td><td>" . implode(", ", array_map('htmlspecialchars', $value)) . "</td></tr>";
                } else {
                    $displayed_data[] = "<tr><td><strong>$label:</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
                }
            }
        }

        // Store the displayed form data in the result array
        $result['displayed_data'] = $displayed_data;
    
    }
}

// Return the result array containing styles, displayed data, and errors
return $result;
?>