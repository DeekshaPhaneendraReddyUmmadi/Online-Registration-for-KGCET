<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "lokesh";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an empty array to store table data
$tableData = array();

// SQL query to fetch all data from the exam_schedule table
$sql = "SELECT id, reg_no, ht_no, name, DATE_FORMAT(dob, '%d-%m-%Y') as dob, district, DATE_FORMAT(exam_date,'%d-%m-%Y') as exam_date, exam_time FROM exam_schedule";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data row by row and add it to the $tableData array
    while($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
}

// Close the database connection
$conn->close();

// Encode the table data array as JSON and output it
echo json_encode($tableData);
?>
