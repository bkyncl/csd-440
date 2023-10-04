<?php
// Initialize an empty errors array
$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate User Name
    if (empty($_POST["user_name"])) {
        $errors["user_name"] = "User Name is required.";
    }

    // Validate Email
    if (empty($_POST["user_email"])) {
        $errors["user_email"] = "Email is required.";
    } elseif (!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) {
        $errors["user_email"] = "Invalid email format.";
    }

    // Validate Password
    $user_password = $_POST["user_password"];
    if (empty($user_password)) {
        $errors["user_password"] = "Password is required.";
    } elseif (strlen($user_password) < 8) {
        $errors["user_password"] = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[a-zA-Z]/", $user_password) || !preg_match("/\d/", $user_password)) {
        $errors["user_password"] = "Password must contain at least one letter and one digit.";
    }

    // Check if there are any validation errors
    if (empty($errors)) {
        // Redirect to BrittResponse.php with form data
        header("Location: BrittResponse.php?" . http_build_query($_POST));
        exit;
    } else {
        // If there are errors, redirect back to the form page (BrittForm.php) with errors
        header("Location: BrittForm.php?" . http_build_query(['errors' => $errors]));
        exit;
    }
}
?>