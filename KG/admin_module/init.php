<?php
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["hallticketNumber"])) {
        // If the hallticket number is submitted via AJAX, insert it into the database
        $hallticketNumber = $_POST["hallticketNumber"];
        
        // Sanitize and escape the hallticket number
        $hallticketNumber = $conn->real_escape_string($hallticketNumber);
        
        $sql = "INSERT INTO exam_schedule (ht_no) VALUES ('$hallticketNumber')";
        if ($conn->query($sql) === TRUE) {
            echo "Hallticket number saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        exit; // Stop further execution after handling the AJAX request
    }
}

// Check if the exam_schedule table is empty
$sql = "SELECT COUNT(*) AS count FROM exam_schedule";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$count = $row['count'];

// Set a variable to indicate if the button should be enabled or disabled
$buttonStatus = ($count == 0) ? "" : "disabled";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initialize Hallticket</title>
</head>
<body>
    <button id="initializeButton" <?php echo $buttonStatus; ?>>Initialize Hallticket</button>

    <div id="hallticketInput" style="display: none;">
        <label for="hallticketNumber">Hallticket Number:</label>
        <input type="text" id="hallticketNumber" name="hallticketNumber">
        <button id="saveHallticketButton">Save Hallticket</button>
    </div>

    <script>
        // Function to handle button click
        function handleClick() {
            document.getElementById("hallticketInput").style.display = "block";
            document.getElementById("initializeButton").disabled = true;
        }

        // Function to handle save hallticket button click
        function handleSaveHallticket() {
            var hallticketNumber = document.getElementById("hallticketNumber").value;
            
            // Send AJAX request to save hallticket number
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // Send to the same URL
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send("hallticketNumber=" + hallticketNumber);
        }

        // Attach click event listener to the button
        document.getElementById("initializeButton").addEventListener("click", handleClick);

        // Attach click event listener to the save hallticket button
        document.getElementById("saveHallticketButton").addEventListener("click", handleSaveHallticket);
    </script>
</body>
</html>

<?php
$conn->close();
?>
