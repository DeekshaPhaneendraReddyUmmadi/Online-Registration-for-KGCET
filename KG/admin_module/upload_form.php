<?php
$update=false;
$alert=false;
// Database connection parameters
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if ($_FILES["fileToUpload"]["error"] == 0) {
        $file = $_FILES["fileToUpload"]["tmp_name"];
        $handle = fopen($file, "r");
        // Loop through the file line-by-line
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Assuming the CSV structure: sno, hallticket, maths, physics, chemistry, total_marks
            $sno = $data[0];
            $hallticket = $data[1];
            $maths = $data[2];
            $physics = $data[3];
            $chemistry = $data[4];
            $total_marks = $data[5];

            // Insert data into database
            $sql = "INSERT INTO results ( hallticket, maths, physics, chemistry, total_marks) VALUES ( '$hallticket', '$maths', '$physics', '$chemistry', '$total_marks')";
            if ($conn->query($sql) === TRUE) {
                //echo "Record inserted successfully.<br>";
            } else {
               // echo "Error inserting record: " . $conn->error . "<br>";
            }
        }
        fclose($handle);
       $update=true;
    } else {
        echo "Error uploading file.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0px;
            background-color: #f5f5f5;
        }
        </style>
</head>
<body>
<?php include 'header1.php' ?>
        <?php
        if($update)
        {
            echo'<div class="alert alert-success" role="alert">
            Results Uploaded Successfully!
          </div>';
        }
        ?>
    <h2>Upload CSV File</h2>
    <form action="upload_form.php" method="post" enctype="multipart/form-data">
        Select CSV file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload CSV" name="submit">
    </form>
</body>
</html>
