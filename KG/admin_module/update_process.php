<?php
// Step 1: Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lokesh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Retrieve form data
$sno = $_POST['sno'];
$name = $_POST['name'];
$fname = $_POST['fname'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$district = $_POST['district'];
$category = $_POST['category'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];

// Step 3: Handle file uploads if any
if ($_FILES['image']['name']) {
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
} else {
    // If no new image uploaded, keep the existing image
    $sql = "SELECT image FROM registrations WHERE sno=$sno";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $image = $row['image'];
}

if ($_FILES['sign']['name']) {
    $sign = $_FILES['sign']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["sign"]["name"]);
    move_uploaded_file($_FILES["sign"]["tmp_name"], $target_file);
} else {
    // If no new signature uploaded, keep the existing signature
    $sql = "SELECT sign FROM registrations WHERE sno=$sno";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $sign = $row['sign'];
}

// Step 4: Update record in the database
$sql = "UPDATE registrations SET 
        name='$name', 
        fname='$fname', 
        gender='$gender', 
        dob='$dob', 
        district='$district', 
        category='$category', 
        email='$email', 
        mobile='$mobile', 
        image='$image', 
        sign='$sign' 
        WHERE sno=$sno";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
