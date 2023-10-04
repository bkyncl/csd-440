<?php
/*
BrittPDF.php
Module 11 Assignment
Name: Brittany Kyncl
Date: 10.2.23
Course: CSD440
Script for generating custom PDF document containing a table of planet data.
    - It utilizes the FPDF library for PDF generation.
    - The table includes information such as planet names, diameters, distances from the Sun, and more.
    - A header with img and title, a footer with page numbers, and general information about the table are included.
    - Database connectivity is established using PDO to retrieve planet data from the "planets" table.
    - The table's header and footer styles are customized with background colors.
    - The script handles errors by redirecting to the index page with an error message if an exception occurs.
*/
// inclusion of FPDF library file
require('lib/fpdf.php');

// Include the db connection file using require_once
require_once("tbl_creation/db_connect.php");

// Custom PDF class extends FPDF lib to create customized header and footer
class PDF extends FPDF {
    // Page header
    function Header() {
        // Add logo to page
        $this->Image('images/img_7.jpg', 10, 8, 277); // Your logo image
        $this->Ln(6);
        // Set font family to Arial bold 
        $this->SetFont('Arial','B',30);

        // Set text color to white
        $this->SetTextColor(255, 255, 255); // RGB color values for white
        // Header
        $this->Cell(0,10,'Planets Table',0,0,'C');
          
        // Line break
        $this->Ln(20);
    }
    // Page footer
    function Footer() {
          
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
          
        // Arial italic 8
        $this->SetFont('Arial','I',8);
          
        // Page number
        $this->Cell(0,10,'Page ' . 
            $this->PageNo(),0,0,'C');
    }
}

// create a PDF object 
$pdf = new PDF();
$pdf->AddPage('L');

// Set font
$pdf->SetFont('Arial', 'B', 16);

// Set title of document
$pdf->SetTitle('Planets Table PDF');

// Display general information
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0,10,'Planets Table Description',0,'C');
$pdf->Ln(2); // Add some space
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, 'This table contains data about planets. This data provides valuable information about each planet , including its name, diameter in kilometers, distance from the Sun in kilometers, time to orbit the Sun, time to spin on its axis, number of moons, average temperature in Celsius, and whether it is classified as a dwarf planet. These celestial bodies vary greatly in size, composition, and characteristics, making them fascinating.', 0, 'L');
$pdf->Ln(2); // Add some space
$pdf->MultiCell(0, 8, "Here's a brief overview of the data for each celestial body:\n" , 0, 'L');

// Create an array of items for the bulleted list
$overviewItems = array(
    "Mercury: The smallest planet, closest to the Sun, with a very short year and day.",
    "Venus: Known for its thick atmosphere and extreme temperatures, Venus has a long day and year.",
    "Earth: Our home planet, with a single moon and moderate temperatures.",
    "Mars: The Red Planet, with a thin atmosphere and evidence of past water.",
    "Jupiter: The largest planet, known for its numerous moons and powerful storms.",
    "Saturn: Famous for its stunning ring system and diverse moons.",
    "Uranus: A unique planet that rotates on its side, with a blue-green color.",
    "Neptune: The farthest known planet from the Sun, with a stormy atmosphere.",
    "Pluto: A dwarf planet in the Kuiper Belt, which used to be classified as the ninth planet.",
    "Ceres: The largest object in the asteroid belt between Mars and Jupiter, also a dwarf planet.",
    "Haumea: A dwarf planet in the Kuiper Belt with a peculiar elongated shape.",
    "Makemake: Another Kuiper Belt dwarf planet, notable for its brightness.",
    "Eris: A distant dwarf planet with a highly elliptical orbit."
);

// Add the bulleted list
foreach ($overviewItems as $item) {
    $pdf->Cell(20, 8, '', 0, 0, 'L'); // no bullet symbol
    $pdf->MultiCell(0, 8, $item, 0, 'L'); 
}

$pdf->Ln(20); // Add some space

// Define cell widths according to column names
$columnData = array(
    'ID' => 8,
    'Planet Name' => 28,
    'Diameter (km)' => 31,
    'Distance from Sun (km)' => 48,
    'Time to Orbit Sun' => 37,
    'Time to Spin on Axis' => 43,
    'Moons' => 16,
    'Average Temp (C)' => 38,
    'Dwarf Planet' => 28
);

// Define the header for the table
function TableHeader($pdf, $columnData) {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(173, 216, 230); // Light blue for header
    $pdf->SetDrawColor(64, 64, 64); // set to dark grey for borders
    foreach ($columnData as $header => $width) {
        $pdf->Cell($width, 10, $header, 1, 0, 'C', true);
    }
    $pdf->Ln();
}
// Define the footer for the table
function TableFooter($pdf, $columnData) {
    $pdf->SetFillColor(173, 216, 230); // Light blue color
    // Calculate the total width based on column widths
    $totalWidth = 0;
    foreach ($columnData as $width) {
        $totalWidth += $width;
    }
    // Create a cell that spans the entire width
    $pdf->Cell($totalWidth, 10, '', 1, 1, 'C', true);
}
try {

    // Get the returned PDO connection using the connectToDatabase() function from db_connect.php
    $conn = connectToDatabase();
    
    // Query to fetch data from the "planets" table using custom column names
    $query = "SELECT 
                id AS 'ID',
                planet_name AS 'Planet Name',
                diameter_km AS 'Diameter (km)',
                distance_from_sun_km AS 'Distance from Sun (km)',
                time_to_orbit_sun AS 'Time to Orbit Sun',
                time_to_spin_on_axis AS 'Time to Spin on Axis',
                moons_count AS 'Moons',
                average_temp_celsius AS 'Average Temp (C)',
                dwarf_planet AS 'Dwarf Planet'
            FROM planets";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are no results
    if (empty($result)) {
        $errorMessage = urlencode("No data available in 'Planets' table. Please populate table first.");

        // Redirect back to the index with an error message
        header("Location: index.php?errorMessage=$errorMessage");
        exit;
    }

    // Call the TableHeader function to add the table header
    TableHeader($pdf, $columnData);

    // Create table data with alternating row background colors
    $fill = false; // Initialize fill flag
    $pdf->SetFillColor(220, 220, 220); // light gray for row alternate
    // Set font
    $pdf->SetFont('Arial', '', 11);
    foreach ($result as $row) {
        foreach ($columnData as $columnName => $width) {
            // Check if the column represents a boolean value for dwarf planet
            if ($columnName === 'Dwarf Planet') {
                $cellValue = $row[$columnName] ? 'True' : 'False';
            } else {
                $cellValue = $row[$columnName];
            }
            // Use the fill flag to set alternating row background colors
            $pdf->Cell($width, 10, $cellValue, 1, 0, 'C', $fill); // Use 'C' to center text, $fill to fill with background color
        }
        
        $pdf->Ln();
        $fill = !$fill; // Toggle the fill flag for the next row
    }

    // Call the TableFooter function to add the table footer
    TableFooter($pdf, $columnData);

    // Output the PDF
    $pdf->Output();

} catch (PDOException $e) {
    $errorMessage = urlencode("Error generating PDF: " . $e->getMessage());

    // Redirect back to the index with error message
    header("Location: index.php?errorMessage=$errorMessage");
    exit;

}finally { // Make use of finally block for better resource closure in case of error
    // Close the statement
    if (isset($stmt)) {
        $stmt = null;
    }

    // Close the result set
    if (isset($result)) {
        $result = null;
    }
    // Close the database connection
    if (isset($conn)) {
        $conn=null;
    }
}

?>