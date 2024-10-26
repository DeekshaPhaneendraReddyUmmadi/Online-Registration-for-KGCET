<?php
// Include the TCPDF library
require_once('TCPDF/tcpdf.php');

// Fetch data from the database
$server='localhost';
$username='root';
$password='';
$database='lokesh';                     
$conn=mysqli_connect($server,$username,$password,$database);
if($conn->connect_error){
    die("connection failed".$conn->connect_error);
}

$sql = "SELECT name,fname,gender FROM registrations";
$result = mysqli_query($conn, $sql);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Student Data');
$pdf->SetSubject('Student Data');
$pdf->SetKeywords('Student, Data, PDF');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Header
$header = array('name', 'fName', 'gender');

// Set fixed width for each column
$columnWidth = 30;

// Output header row
foreach ($header as $heading) {
    $pdf->Cell($columnWidth, 10, $heading, 1, 0, 'C');
}

$pdf->Ln();

// Table data
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $value) {
        // Output each value in a cell with fixed width
        $pdf->Cell($columnWidth, 10, $value, 1, 0, 'C');
    }
    $pdf->Ln();
}

// Close and output PDF
$pdf->Output('student_data.pdf', 'D');
?>
