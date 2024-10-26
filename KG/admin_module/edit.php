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
        $sno = $_GET['sno'];

        // Step 3: Fetch the record to be edited
        $sql = "SELECT * FROM registrations WHERE sno=$sno";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <!-- Step 4: Display a form pre-filled with the record's data -->
            <form action="update_process.php" method="POST">
                <input type="hidden" name="sno" value="<?php echo $sno; ?>">
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
                <!-- Add input fields for other columns you want to update -->
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
