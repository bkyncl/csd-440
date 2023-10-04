<!--
BrittJSON>php
Module 10 Assignment
Name: Brittany Kyncl
Date: 10.1.23
Course: CSD440
Form for collecting user data, validates and processes the submitted data, 
and displays it in JSON format. The form includes fields for first name, last name, age, date of birth, email, phone number, street address, city, state, zip code, and country.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mod 10 Assignment</title>
</head>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include form processing script
    include('Britt_ProcessJSON.php');
}
?>
<body class="bg-dark text-light">
<div class="container mt-10">
    <div class="row justify-content-center" style="padding: 50px;">
        <div class="col-md-7">
            <div class="card bg-light text-dark">
                <div class="card-body">
                    <div class="text-center">
                        <h5 class="card-title">JSON Form</h5>
                        <p>Please enter and submit the following information</p>
                    </div>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="age" id="age" placeholder="Age">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="dob" id="dob">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="tel" class="form-control" name="phone" id="phone" oninput="formatPhoneNumber(this)" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="street" name="street" placeholder="Street Address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control" id="state" name="state">
                                        <option value="" disabled selected>Select a State</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="CA">California</option>
                                        <option value="CO">Colorado</option>
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="HI">Hawaii</option>
                                        <option value="ID">Idaho</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IN">Indiana</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MD">Maryland</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NV">Nevada</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="OH">Ohio</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="OR">Oregon</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="TX">Texas</option>
                                        <option value="UT">Utah</option>
                                        <option value="VT">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="WA">Washington</option>
                                        <option value="WV">West Virginia</option>
                                        <option value="WI">Wisconsin</option>
                                        <option value="WY">Wyoming</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select class="form-control" id="country" name="country">
                                        <option value="" disabled selected>Select a Country</option>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <?php
                            if (isset($errors) && !empty($errors)) {
                                echo '<div class="alert alert-danger">';
                                foreach ($errors as $error) {
                                    echo htmlspecialchars($error) . "<br>";
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="JSON_form_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        if (isset($jsonData)) {?>
            <div class="container mt-10">
                <div class="row justify-content-center" style="padding: 50px;">
                    <div class="col-md-7">
                        <div class="card bg-light text-dark">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="card-title">JSON Return</h5>
                                    <p>Input displayed in JSON format</p>
                                </div>
                                <?php
                                if (isset($jsonErrors) && !empty($jsonErrors)) {
                                    echo '<div class="alert alert-danger">';
                                    foreach ($jsonErrors as $jsonError) {
                                        echo htmlspecialchars($jsonError) . "<br>";
                                    }
                                    echo '</div>';
                                } else {
                                    echo "<pre>" .$jsonData. "</pre>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php }?>
</div>
<script>
    // function to format phone number input
    function formatPhoneNumber(input) {
        // Remove all non-numeric characters
        const phoneNumber = input.value.replace(/\D/g, '');

        // Check if the phone number is empty or too long
        if (phoneNumber.length === 0) {
            input.value = '';
        } else if (phoneNumber.length <= 10) {
            // Format as (XXX) XXX-XXXX
            input.value = `(${phoneNumber.slice(0, 3)}) ${phoneNumber.slice(3, 6)}-${phoneNumber.slice(6, 10)}`;
        } else {
            // If longer than 10 digits, truncate extra digits
            input.value = `(${phoneNumber.slice(0, 3)}) ${phoneNumber.slice(3, 6)}-${phoneNumber.slice(6, 10)}`;
        }
    }
</script>
</body>
</html>