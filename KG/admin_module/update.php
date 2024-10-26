<?php
$update=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection (replace with your own credentials)
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lokesh";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $reg_id = $_POST['reg_id'];
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $category = $_POST['category'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // Prepare SQL statement to update the important_dates table
    // Step 3: Handle file uploads if any
if ($_FILES['image']['name']) {
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
} else {
    // If no new image uploaded, keep the existing image
    $sql = "SELECT image FROM registrations WHERE reg_id=$reg_id";
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
    $sql = "SELECT sign FROM registrations WHERE reg_id=$reg_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $sign = $row['sign'];
}
$sql = "UPDATE registrations SET 
name='$name', 
fname='$fname', 
gender='$gender', 
dob='$dob', 
address='$address', 
category='$category', 
email='$email', 
mobile='$mobile', 
image='$image', 
sign='$sign' 
WHERE reg_id=$reg_id";

if ($conn->query($sql) === TRUE) {
  $update=true;
  //exit();
} else {
echo "Error updating record: " . $conn->error;
}

$conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Candidate</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php
    if($update)
    {
        echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Details Updated</strong> Successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container mt-5">
        <h2>Edit Candidate</h2>
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

        // Step 2: Retrieve the serial number from the URL
        if($update==false)
        {
        $reg_id = $_GET['reg_id'];
        }

        // Step 3: Fetch the record to be edited
        $sql = "SELECT * FROM registrations WHERE reg_id=$reg_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <!-- Step 4: Display a form pre-filled with the record's data -->
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="reg_id" value="<?php echo $reg_id; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="fname" class="form-label">Father's Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['fname']; ?>">
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $row['gender']; ?>">
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $row['dob']; ?>">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">District</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" value="<?php echo $row['category']; ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <img src="uploads/<?php echo $row['image']; ?>" alt="Current Image" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                </div>
                <div class="mb-3">
                    <label for="sign" class="form-label">Signature</label>
                    <input type="file" class="form-control" id="sign" name="sign">
                    <img src="uploads/<?php echo $row['sign']; ?>" alt="Current Signature" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <?php
        } else {
            echo "Record not found.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
