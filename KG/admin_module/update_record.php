<?php
// Database connection details
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

// Get data from POST request
$id = $_POST['id'];
$name = $_POST['name'];
$ht_no = $_POST['ht_no'];
$dob = $_POST['dob'];
$district = $_POST['district'];
$exam_date = $_POST['exam_date'];
$exam_time = $_POST['exam_time'];

// Prepare SQL query to update record
$sql = "UPDATE exam_schedule SET name=?, ht_no=?, dob=?, district=?, exam_date=?, exam_time=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $name, $ht_no, $dob, $district, $exam_date, $exam_time, $id);

// Execute the update statement
if ($stmt->execute() === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// Close connection
$conn->close();
?>
