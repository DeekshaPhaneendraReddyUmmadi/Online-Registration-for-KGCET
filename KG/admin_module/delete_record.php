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

// Check if ID parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete record from the exam_schedule table based on the provided ID
    $sql = "DELETE FROM exam_schedule WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID parameter is missing.";
}

// Close the database connection
$conn->close();
?>
