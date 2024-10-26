<?php
session_start();
if(!isset($_SESSION['loggedin']))
{
    header("Location: index.php");
    exit;
}

?>
<?php
$date=false;
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
    $openingDate = $_POST["openingDate"];
    $closingDate = $_POST["closingDate"];
    $hallTicketDate = $_POST["hallTicketDate"];
    $resultsDate = $_POST["resultsDate"];

    // Prepare SQL statement to update the important_dates table
    $sql = "UPDATE important_dates SET 
            registration_opening_date = '$openingDate',
            registration_closing_date = '$closingDate',
            hall_ticket_release_date = '$hallTicketDate',
            results_release_date = '$resultsDate'
            WHERE id = 1"; // Assuming there is only one record in the table

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
       $date=true;
    } else {
        echo "Error updating important dates: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Interface - Update Important Dates</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<style>
/* CSS styles for the form */

body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
}

.container {
    max-width: 500px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error-message {
    color: red;
    font-style: italic;
    margin-top: 5px;
}

</style>
<script>
function validateForm() {
    var openingDate = document.getElementById("openingDate").value;
    var closingDate = document.getElementById("closingDate").value;
    var hallTicketDate = document.getElementById("hallTicketDate").value;
    var resultsDate = document.getElementById("resultsDate").value;

    // Validate date format (YYYY-MM-DD)
    var dateFormat = /^\d{4}-\d{2}-\d{2}$/;

    if (!openingDate.match(dateFormat) || !closingDate.match(dateFormat) || !hallTicketDate.match(dateFormat) || !resultsDate.match(dateFormat)) {
        alert("Please enter dates in the format YYYY-MM-DD");
        return false;
    }

    // Convert dates to Date objects for comparison
    var opening = new Date(openingDate);
    var closing = new Date(closingDate);

    // Validate closing date is after opening date
    if (closing <= opening) {
        alert("Closing date must be after opening date");
        return false;
    }

    return true;
}
</script>
</head>
<body>
<?php include 'header1.php'; ?>
<?php 
if($date)
{
    echo'<div class="alert alert-success" role="alert">
    Dates have been successfully updated!
  </div>';
}
?>

<div class="container">
    <h2>Update Important Dates</h2>
    <form action="date_updates.php" method="post" onsubmit="return validateForm()">
        <label for="openingDate">Registration Opening Date:</label>
        <input type="text" id="openingDate" name="openingDate" placeholder="YYYY-MM-DD" required>

        <label for="closingDate">Registration Closing Date:</label>
        <input type="text" id="closingDate" name="closingDate" placeholder="YYYY-MM-DD" required>

        <label for="hallTicketDate">Hall Ticket Release Date:</label>
        <input type="text" id="hallTicketDate" name="hallTicketDate" placeholder="YYYY-MM-DD" required>

        <label for="resultsDate">Results Release Date:</label>
        <input type="text" id="resultsDate" name="resultsDate" placeholder="YYYY-MM-DD" required>

        <input type="submit" value="Submit">
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
