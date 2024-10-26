<?php 
$alert=false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-lBmEXe3VNZd1VLRKIB5s6trG/I7N+hFHDanLP61BUVZaj2p+9O3/d6uVGTtA/QMYgj0B3S/QZfAAxS1GUhzy0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Upload CSV File</title>
    <style>
       
        .containerr {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .upload-icon {
            font-size: 36px;
            color: #007bff;
        }
        .upload-input {
            display: none;
            
        }
        .upload-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 18px;
            margin-bottom: 10px; /* Add margin bottom to create gap */
        }
        .upload-btn:hover {
            background-color: #0056b3;
        }
        .success-icon {
            color: green;
            font-size: 36px;
        }
        .show-schedule-button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .show-schedule-button:hover {
            background-color: #45a049; /* Darker green */
        }
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
    <?php include'header1.php'?>
    </div>
    <div class="row">
        
    </div>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="row mt-5">
    <div class="containerr">
        
        <h1>Upload CSV File</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="csv-file" class="upload-btn">
                <span class="upload-icon">&#x1F4C2;</span> Choose File
            </label>
            <input type="file" id="csv-file" name="csv_file" class="upload-input" accept=".csv"><br><br>
            <button type="submit" class="submit-btn">Upload</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['csv_file'])) {
            if ($_FILES['csv_file']['size'] == 0) {
                echo "<br>Please upload the CSV file.";
            } else {
                // Validate CSV file against table structure
                $file = $_FILES['csv_file']['tmp_name'];
                $handle = fopen($file, "r");
                $header = fgetcsv($handle, 1000, ","); // Read the header row and discard it
                fclose($handle);

                $expected_columns = array("reg_no","ht_no","name", "maths", "physics", "chemistry","total","rank");

                if ($header !== $expected_columns) {
                    echo "<br>Error: CSV file column names do not match the expected format.";
                } else {
                    // Perform database insertion
                    $conn = new mysqli('localhost', 'root', '', 'lokesh');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $handle = fopen($file, "r");
                    fgetcsv($handle, 1000, ","); // Skip the header row
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Skip empty rows
                        if (empty(array_filter($data))) {
                            continue;
                        }

                        $reg_no = $data[0];
                        $ht_no = $data[1];
                        $name = $data[2];
                        $maths = $data[3];
                        $physics = $data[4];
                        $chemistry = $data[5];
                        $total = $data[6];
                        $rank = $data[7];

                        $sql = "INSERT INTO results (reg_no,ht_no,name, maths, physics, chemistry,total,rank) 
                                VALUES ('$reg_no','$ht_no','$name','$maths', '$physics', '$chemistry','$total', '$rank')";
                        if ($conn->query($sql) === FALSE) {
                            echo "Error inserting data: " . $conn->error;
                        }
                    }

                    fclose($handle);
                    $conn->close();

                    echo '<span class="success-icon">&#10004;</span>';
                }
            }
        }
        ?>
        </div>
        </div>
        
    </div>
    <div class="col-sm-4"></div>
    <div class="row">
    <div style="text-align: right;">
        <button class="show-schedule-button" onclick="showSchedule()">Show Results</button>
    </div>
    </div>
        </div>
    </div>
    <script>
        function showSchedule() {
            window.location.href = 'results_fetch.php';
        }
    
    </script>
</body>
</html>
