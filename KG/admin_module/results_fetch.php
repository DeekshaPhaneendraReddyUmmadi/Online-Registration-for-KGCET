<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results and Graph</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Import Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        canvas {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <?php include'header1.php'?>
        </div>
    
    <h1>Results</h1>

    <!-- Display table of results -->
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'lokesh');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch all data from the table
    $sql = "SELECT * FROM results";
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table><tr><th>Registration Number</th><th>Ht_no</th><th>Name</th><th>Maths</th><th>Physics</th><th>Chemistry</th><th>total</th><th>Rank</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["reg_no"]."</td><td>".$row["ht_no"]."</td><td>".$row["name"]."</td><td>".$row["maths"]."</td><td>".$row["physics"]."</td><td>".$row["chemistry"]."</td><td>".$row["total"]."</td><td>".$row["rank"]."</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No results found";
    }

    // Close database connection
    $conn->close();
    ?>

    <!-- Display graph -->
    <canvas id="myChart"></canvas>
    </div>
   
</body>
</html>
