<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABOUT</title>
    <style>
   
    
        




body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin-top:0px;
            padding: 0;
        }

        .containers {
            width: 80%;
            margin: 20px auto;
            background-color: #a0b6d8;
            padding: 20px;
            
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top:50px;
        }

        .important-dates {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
           
            
        }

        .date-box {
            width: 30%;
            padding: 12px;
            margin-bottom: 40px;
            border: 3px solid #000033;
            border-radius: 5px;
        }

        .date-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .date-value {
            font-weight: bold;
            margin-bottom: 5px;
        }
      

        </style>


    
</head>
<body>
    

<?php include 'header.php'; ?>

   
    <div class="containers">
        <h2>Important Dates</h2>
        <div class="important-dates">
            <?php
            // Establish database connection (replace with your own credentials)
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

            // SQL query to fetch dates from the database
            $sql = "SELECT * FROM important_dates WHERE id = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='date-box'>
                            <div class='date-label'>Registration Open</div>
                            <div class='date-value'>" . date('d/m/Y', strtotime($row['registration_opening_date'])) . "</div>
                        </div>
                        <div class='date-box'>
                            <div class='date-label'>Last Registration</div>
                            <div class='date-value'>" . date('d/m/Y', strtotime($row['registration_closing_date'])) . "</div>
                        </div>
                        <div class='date-box'>
                            <div class='date-label'>Hall Ticket Release</div>
                            <div class='date-value'>" . date('d/m/Y', strtotime($row['hall_ticket_release_date'])) . "</div>
                        </div>
                        <div class='date-box'>
                            <div class='date-label'>Result Release</div>
                            <div class='date-value'>" . date('d/m/Y', strtotime($row['results_release_date'])) . "</div>
                        </div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>
        
<div name="space">
    <?php include 'footer.php'; ?>
        </div>
</body>
</html>
