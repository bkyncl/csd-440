<?php
// inclusion of FPDF library file
require('lib/fpdf.php');

class PDF extends FPDF {
  
    // Page header
    function Header() {
          
        // Add logo to page
        $this->Image('gfg1.png',10,8,33);
          
        // Set font family to Arial bold 
        $this->SetFont('Arial','B',20);
          
        // Move to the right
        $this->Cell(80);
          
        // Header
        $this->Cell(50,10,'Heading',1,0,'C');
          
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
            $this->PageNo() . '/{nb}',0,0,'C');
    }
}

// create a FPDF object with default values used for the constructor
$pdf = new FPDF();
$pdf->AddPage('L');

// Set font
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Topic: General Information', 0, 1, 'C');

// Display general information
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 10, 'This is some general information about the topic.', 0, 'L');
$pdf->Ln(10); // Add some space


// connection parameters
$dsn = "mysql:host=localhost;dbname=baseball_01";
$username = "student1";
$password = "pass";

try {

    // Attempt to create a new PDO database connection 
    $conn = new PDO($dsn, $username, $password);
    // Set PDO error mode to throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to fetch data from the "planets" table
    $query = "SELECT * FROM planets";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create a PDF table
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(25, 10, 'Planet Name', 1);
    $pdf->Cell(25, 10, 'Diameter (km)', 1);
    $pdf->Cell(40, 10, 'Distance from Sun (km)', 1);
    $pdf->Cell(30, 10, 'Time to Orbit Sun', 1);
    $pdf->Cell(40, 10, 'Time to Spin on Axis', 1);
    $pdf->Cell(20, 10, 'Moons', 1);
    $pdf->Cell(30, 10, 'Average Temp (°C)', 1);
    $pdf->Cell(25, 10, 'Dwarf Planet', 1);
    $pdf->Ln();

    foreach ($result as $row) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(25, 10, $row['planet_name'], 1);
        $pdf->Cell(25, 10, $row['diameter_km'], 1);
        $pdf->Cell(40, 10, $row['distance_from_sun_km'], 1);
        $pdf->Cell(30, 10, $row['time_to_orbit_sun'], 1);
        $pdf->Cell(40, 10, $row['time_to_spin_on_axis'], 1);
        $pdf->Cell(20, 10, $row['moons_count'], 1);
        $pdf->Cell(30, 10, $row['average_temp_celsius'], 1);
        $pdf->Cell(25, 10, $row['dwarf_planet'] ? 'Yes' : 'No', 1);
        $pdf->Ln();
    }

    // Footer
    $pdf->SetY(-15);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');

    // Output the PDF
    $pdf->Output();

} catch (PDOException $e) {
    // Throw an exception with the error message
    throw new PDOException("Connection failed: " . $e->getMessage());
}

?>