<?php
// edit_record.php
$update=false;
$alert=false;

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

// Retrieve the record ID from the URL
$id = $_GET["id"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form input (you may add more validation)
    $exam_date = $_POST["exam_date"];
    $exam_time = $_POST["exam_time"];
    $hallticket_number = $_POST["hallticket_number"]; // Adding the hallticket number field

    // Update the record in the database
    $sql = "UPDATE exam_schedule SET exam_date='$exam_date', exam_time='$exam_time', ht_no='$hallticket_number' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $update=true;
    } else {
        $alert=true;
    }
}

// Retrieve the record based on the ID from the URL
$sql = "SELECT * FROM exam_schedule WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the record details
    $row = $result->fetch_assoc();

    // Check the count of records in the table
    $sql_count = "SELECT COUNT(*) AS count FROM exam_schedule";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $count = $row_count['count'];

    // Display the form for editing the date and time
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>Edit Exam Schedule</title>
        <style>
            /* Your CSS styles */
            body {
            font-family: Arial, sans-serif;
            margin: 0px;
            background-color: #f5f5f5;
        }
        </style>
    </head>
    <body >
        <?php include 'header1.php' ?>
        <?php
        if($update)
        {
            echo'<div class="alert alert-success" role="alert">
            Exam Date and Time Updated Successfully!
          </div>';
        }
        if($alert)
        {
            echo'<div class="alert alert-Danger" role="alert">
            Exam Date and Time  Not Updated !
          </div>';
        }
        ?>
        <div class="container">
        <h2>Edit Exam Schedule</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $id); ?>">
            <!-- Display additional details -->
            <label for="reg_no">Registration Number:</label>
            <input type="text" id="reg_no" name="reg_no" value="<?php echo $row['reg_no']; ?>" readonly><br><br>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" readonly><br><br>
            
            <label for="district">District:</label>
            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" readonly><br><br>
            
            <!-- Editable fields -->
            <label for="exam_date">Exam Date:</label>
            <input type="date" id="exam_date" name="exam_date" value="<?php echo $row["exam_date"]; ?>"><br><br>
            
            <label for="exam_time">Exam Time:</label>
            <input type="time" id="exam_time" name="exam_time" value="<?php echo $row["exam_time"]; ?>"><br><br>

            <!-- Hallticket Number -->
            <label for="hallticket_number">Hallticket Number:</label>
            <input type="text" id="hallticket_number" name="hallticket_number" value="<?php echo $row["ht_no"]; ?>" <?php echo ($count == 1) ? '' : 'readonly'; ?>><br><br>
            
            <input type="submit" value="Update">
        </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
    </html>

    <?php
} else {
    echo "Record not found";
}

// Close the database connection
$conn->close();
?>
