<?php
/*
BrittPDF.php
Planet CRUD app
Name: Brittany Kyncl
Date: 10.2.23
Course: CSD440
Script for generating custom PDF document containing a table of planet data.
    - It utilizes the FPDF library for PDF generation.
    - The table includes information such as planet names, diameters, distances from the Sun, and more.
    - A header with img and title, a footer with page numbers, and general information about the table are included.
    - Database connectivity is established using PDO to retrieve planet data from the "planets" table.
    - The table's header and footer styles are customized with background colors.
    - The script handles errors exiting script execution and displaying an error message if an exception occurs.
*/
// inclusion of FPDF library file
require('lib/fpdf.php');

// Include the db connection file using require_once
require_once("britt_utility/db_connect.php");

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
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 6, 'The Planets table is a database table designed to store essential information about celestial bodies, specifically planets. This table plays a fundamental role in astronomical research, education, and exploration, providing a structured repository of data about various planets.It includes key attributes such as the planets name, diameter in kilometers, distance from the Sun in kilometers, time taken to orbit the Sun, time taken to spin on its axis, the number of moons it has, average temperature in Celsius, and whether it is classified as a dwarf planet or not.', 0, 'L');
$pdf->Ln(4); // Add some space
$pdf->MultiCell(0, 6, 'Adding new planets to the table is fun way to track and expand your knowledge of the solar system and the universe at large. This process involves collecting data from observations, research, and scientific sources, and then inserting this data you findinto the database. Each planets unique characteristics, such as its size, composition, climate, and orbital dynamics, contribute to our understanding of the broader cosmos. By documenting accurate and up-to-date information we uncover about clestial bodies, scientists, astronomers, and almost anyone can  have access to a valuable resource for studying planetary science.', 0, 'L');
$pdf->Ln(4); // Add some space
$pdf->MultiCell(0, 6, 'By continually updating this table with accurate information, we not only enhance our understanding of the cosmos but also enable a wide range of educational and scientific activities. Furthermore, knowledge about the planets can inspire and engage students in the fields of science, technology, engineering, and mathematics (STEM). Teachers can utilize the planets table to create interactive lessons, charts, and visualizations that make learning about the solar system an engaging and informative experience.', 0, 'L');
$pdf->Ln(4); // Add some space
$pdf->MultiCell(0, 8, "Some examples of interactive lessons using the Planets databse include:\n" , 0, 'L');

// Create an array of items for the bulleted list
$overviewItems = array(
    "Creating a 3D or 2D model of the solar system using the plantets data. Allowing students to grasp the relative positions and scales of planets",
    "Create comparative charts or infographics that compare the planets side by side. Helping students to understand the diversity within our solar system",
    "Design quizzes or flashcards based on the data in the planets table. Students can test their knowledge about the planets.",
    "Generate heatmaps or climate maps of each planet using average temperature data. Students can explore the temperature variations of planets.",
    "Develop a timeline that highlights signifigant space missions and explorations related to each planet. Providing historical context of planet exploration.",
);

// Add the bulleted list
foreach ($overviewItems as $item) {
    $pdf->Cell(15, 6, '', 0, 0, 'L'); // no bullet symbol
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
        echo "No data available in 'Planets' table. Please populate table first.";
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
            $pdf->Cell($width, 9, $cellValue, 1, 0, 'C', $fill); // Use 'C' to center text, $fill to fill with background color
        }
        
        $pdf->Ln();
        $fill = !$fill; // Toggle the fill flag for the next row
    }

    // Call the TableFooter function to add the table footer
    TableFooter($pdf, $columnData);

    // Output the PDF
    $pdf->Output();

} catch (PDOException $e) {
    echo"Error generating PDF: " . $e->getMessage();
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