<!--
edit_form.php
Planet CRUD app
Name: Brittany Kyncl
Date: 9.26.23
Course: CSD440
Handles updating existing planet records requested by form submission from BrittEditForms.php
It establishes a database connection using PDO,
executes SQL querie to return requested planet to update details, and provides response messages for success and error cases.
-->
<?php
session_start(); // Start the session

// Include the db connection file using require_once
require_once("britt_utility/db_connect.php");

// Inlcude other functional files
require_once("db_operations.php");

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // send back to login
    header("Location: user_login.php");
    exit();
}

// Logout function
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: user_login.php");
    exit();
}

// Check is the Edit button was clicked 
if (isset($_POST['edit-planet'])) {
    try {
        // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
        $conn = connectToDatabase();

        try {
            // Retrieve the planet's ID from the form submission
            if (isset($_POST['id'])) { // Check if the key exists
                $planetIdToUpdate = $_POST['id'];
    
                // Prepare and execute a query to retrieve the requested planet data by ID
                $sql = "SELECT * FROM planets WHERE id = :planet_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':planet_id', $planetIdToUpdate, PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the planet data as an associative array
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Check if data was found
                if ($result) {
                    // Set the values for form input fields based on the planet data
                    $editPlanetName = htmlspecialchars($result['planet_name']);
                    $editDiameterKm = htmlspecialchars($result['diameter_km']);
                    $editDistanceFromSunKm = htmlspecialchars($result['distance_from_sun_km']);
                    $editTimeToOrbitSun = htmlspecialchars($result['time_to_orbit_sun']);
                    $editTimeToSpinOnAxis = htmlspecialchars($result['time_to_spin_on_axis']);
                    $editMoonsCount = htmlspecialchars($result['moons_count']);
                    $editAverageTempCelsius = htmlspecialchars($result['average_temp_celsius']);
                    $editIsDwarfPlanet = htmlspecialchars($result['dwarf_planet'] == 1 ? '1' : '0');

                } else {
                    // Handle the case when the requested planet ID was not found
                    $responseMessage = "Planet with ID $requestedToEditID not found.";
                    $alertClass = "alert-danger"; // Set an error CSS class
                    // Redirect the user back to the form page with an error message
                    header("Location: BrittEditForms.php?successMessage=" . urlencode($responseMessage) . "&alertClass=" . urlencode($alertClass));
                }
    
            } else {
                // Handle the case when 'id' is not set in $_POST
                $responseMessage = "Invalid: 'planet_id' is missing in edit request form submission.";
                $alertClass = "alert-danger"; // Set an error CSS class
                // redirect the user back to the form page with an error message
                header("Location: BrittEditForms.php?successMessage=" . urlencode($responseMessage) . "&alertClass=" . urlencode($alertClass));
            }
        } catch (PDOException $e) {
            // Handle cases of error in record retrieval
            $responseMessage = "Error retrieving requested record for edit: " . $e->getMessage();
            $alertClass = "alert-danger"; // Set an error CSS class
            // redirect the user back to the form page with error message
            header("Location: BrittEditForms.php?successMessage=" . urlencode($responseMessage) . "&alertClass=" . urlencode($alertClass));
        }

    } catch (PDOException $e) {
        // Handle cases of error in record retrieval
        $responseMessage = "Error: " . $e->getMessage();
        // redirect the user back to the form page with error message
        header("Location: BrittEditForms.php?successMessage=" . urlencode($responseMessage) . "&alertClass=" . urlencode($alertClass));
    } finally { // close resources 
        //close resultset
        if(isset($result)) {
            $result = null;
        }
        // Close the statement
        if (isset($stmt)) {
            $stmt = null;
        }
        // Close the database connection
        if (isset($conn)) {
            $conn = null;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Mod 9 Assignment</title>
 
</head>
<body class="bg-dark text-light"> <!-- Apply dark theme to the entire body -->
    <?php include("britt_utility/navbar.php"); ?> <!-- Include the navbar -->
    <div class="container mt-10" style="padding-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card bg-light text-dark"> <!-- Apply dark theme to the card -->
                    <div class="card-body">
                        <div class="text-center" style="padding-bottom: 10px;">
                            <h5 class="card-title">Edit Record: <?php echo (isset($planetIdToUpdate) ? htmlspecialchars($planetIdToUpdate) : '') . " " . (isset($editPlanetName) ? htmlspecialchars($editPlanetName) : '') ?></h5>
                        </div>
                        <form action="" method="POST">
                            <input type="hidden" name="planet_id" value="<?php echo (isset($planetIdToUpdate) ? htmlspecialchars($planetIdToUpdate) : '') ?>">
                            <div class="mb-3">
                                <label for="planet_name" class="form-label">Planet Name</label>
                                <input type="text" class="form-control" id="planet_name" name="planet_name" 
                                value="<?php echo isset($editPlanetName) ? htmlspecialchars($editPlanetName) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="diameter_km" class="form-label">Diameter (km)</label>
                                <input type="text" class="form-control" id="diameter_km" name="diameter_km" 
                                value="<?php echo isset($editDiameterKm) ? htmlspecialchars($editDiameterKm) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="distance_from_sun_km" class="form-label">Distance from Sun (km)</label>
                                <input type="text" class="form-control" id="distance_from_sun_km" name="distance_from_sun_km" 
                                value="<?php echo isset($editDistanceFromSunKm) ? htmlspecialchars($editDistanceFromSunKm) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="time_to_orbit_sun" class="form-label">Time to Orbit Sun</label>
                                <input type="text" class="form-control" id="time_to_orbit_sun" name="time_to_orbit_sun" 
                                value="<?php echo isset($editTimeToOrbitSun) ? htmlspecialchars($editTimeToOrbitSun) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="time_to_spin_on_axis" class="form-label">Time to Spin on Axis</label>
                                <input type="text" class="form-control" id="time_to_spin_on_axis" name="time_to_spin_on_axis" 
                                value="<?php echo isset($editTimeToSpinOnAxis) ? htmlspecialchars($editTimeToSpinOnAxis) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="moons_count" class="form-label">Number of Moons</label>
                                <input type="number" class="form-control" id="moons_count" name="moons_count" 
                                value="<?php echo isset($editMoonsCount) ? htmlspecialchars($editMoonsCount) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="average_temp_celsius" class="form-label">Average Temperature (Celsius)</label>
                                <input type="text" class="form-control" id="average_temp_celsius" name="average_temp_celsius" 
                                value="<?php echo isset($editAverageTempCelsius) ? htmlspecialchars($editAverageTempCelsius) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Is it a Dwarf Planet?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_dwarf_planet" id="is_dwarf_planet_yes" value="1" <?php echo isset($editIsDwarfPlanet) && $editIsDwarfPlanet === '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_dwarf_planet_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_dwarf_planet" id="is_dwarf_planet_no" value="0" <?php echo isset($editIsDwarfPlanet) && $editIsDwarfPlanet === '0' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="is_dwarf_planet_no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="edit_planet_record_submit">Submit Record Edit</button>
                            </div>
                            <div class="text-center" style="padding-top: 10px;">
                                <a href="BrittEditForms.php" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                        <div class="text-center" style="padding: 10px;">
                            <!-- Display success or error message if available -->
                            <?php if (!empty($responseMessage)): ?>
                                <div class="alert <?php echo $alertClass; ?>" role="alert">
                                    <?php echo $responseMessage; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($validationErrors)): ?>
                                <div class="alert <?php echo $alertClass; ?>" role="alert">
                                    <?php echo $validationErrors; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>