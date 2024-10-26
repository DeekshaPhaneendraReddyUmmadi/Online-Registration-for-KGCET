<?php
session_start();
if(!isset($_SESSION['loggedin']))
{
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
         .dashboard {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
         .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s;
            margin: 10px;
            width: 400px;
            text-align: center;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h2 {
            color: #3498db;
        }

        .card p {
            font-size: 24px;
            margin: 10px 0;
            color: #555;
        }

        .card a {
            text-decoration: none; /* Remove underline */
            color: inherit;
            display: block;
            padding: 10px;
        }
    </style>
</head>
<body>
<?php include 'header1.php'; ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "lokesh";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the number of students registered
$sql_students = "SELECT COUNT(*) as total_students FROM registrations";
$result_students = $conn->query($sql_students);

if ($result_students->num_rows > 0) {
    $row_students = $result_students->fetch_assoc();
    $totalStudents = $row_students['total_students'];
} else {
    $totalStudents = 0;
}

// Query to get the number of students in exam schedule
$sql_exams = "SELECT COUNT(*) as total_exams FROM exam_schedule";
$result_exams = $conn->query($sql_exams);

if ($result_exams->num_rows > 0) {
    $row_exams = $result_exams->fetch_assoc();
    $totalExams = $row_exams['total_exams'];
} else {
    $totalExams = 0;
}

$conn->close();
?>

<div class="dashboard">
    <div class="card">
        <a href="students_fetch.php">
        <h2>Total Registered Students</h2>
        <p><?php echo $totalStudents; ?></p>
    </div>
    <div class="card">
        <a href="show_schedule.php">
            <h2>Total Scheduled students</h2>
            <p><?php echo $totalExams; ?></p>
        </a>
    </div>
</div>

</body>
</html>
