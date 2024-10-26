<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Your database connection code
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

// Process registration form data
$name = trim($_POST['name']);
$fname = trim($_POST['fname']);
$intermediate_hallticket = trim($_POST['intermediate_hallticket']);
$gender = trim($_POST['gender']);
$dob = trim($_POST['dob']);
$address = trim($_POST['address']);
$category = trim($_POST['category']);
$email = trim($_POST['email']);
$mobile = trim($_POST['mobile']);
$reg_no = 'TS' . rand(99, 10) . time();
$folder = "admin_module/uploads/";

// Validate input
if (empty($name) || empty($email)) {
    die("Error: Name and email are required.");
}

// Sanitize input
$name = mysqli_real_escape_string($conn, $name);
$fname = mysqli_real_escape_string($conn, $fname);
$intermediate_hallticket = mysqli_real_escape_string($conn, $intermediate_hallticket);
$gender = mysqli_real_escape_string($conn, $gender);
$dob = mysqli_real_escape_string($conn, $dob);
$address = mysqli_real_escape_string($conn, $address);
$category = mysqli_real_escape_string($conn, $category);
$email = mysqli_real_escape_string($conn, $email);
$mobile = mysqli_real_escape_string($conn, $mobile);

// Check if the roll number already exists
$checkRollNoQuery = "SELECT * FROM registrations WHERE intermediate_hallticket = '$intermediate_hallticket'";
$result = $conn->query($checkRollNoQuery);

if ($result->num_rows > 0) {
    // Roll number already exists, display alert message
    echo "<script>alert('Roll number already exists.'); window.location.href = 'form.php';</script>";
    // You can redirect the user or display a message as needed
} else {
    // Roll number is unique, proceed with registration

    // Handle file uploads and other registration processes here

    // Upload photo
    $image_file = $_FILES['image']['name'];
    $file = $_FILES['image']['tmp_name'];
    $new_image_name = 'photo_' . rand() . '.' . pathinfo($image_file, PATHINFO_EXTENSION);
    move_uploaded_file($file, $folder . $new_image_name);

    // Upload hall ticket
    $simage_file = $_FILES['simage']['name'];
    $sfile = $_FILES['simage']['tmp_name'];
    $snew_image_name = 'sign_' . rand() . '.' . pathinfo($simage_file, PATHINFO_EXTENSION);
    move_uploaded_file($sfile, $folder . $snew_image_name);

    // Generate reference ID
    //$reference_id = generateReferenceID();

    // Insert registration data into database using prepared statement
    $sql = "INSERT INTO registrations (name, fname, intermediate_hallticket, gender, dob, address, category, email, mobile, reg_no, image, sign) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Bind parameters
    $stmt->bind_param('ssssssssssss', $name, $fname, $intermediate_hallticket, $gender, $dob, $address, $category, $email, $mobile, $reg_no, $new_image_name, $snew_image_name);

    if ($stmt->execute()) {
        // Registration successful
        $message = "Registration successful!<br>Your Reference ID is: " . $reg_no;
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
        $color = 'green';

        // Send confirmation email
        $mail = new PHPMailer(true);
        // Server settings
        $mail->isSMTP(); // Send using SMTP
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'kuppanikiransai@gmail.com'; // SMTP username
        $mail->Password   = 'cucupxrwtknrbzyc'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        // Recipients
        $mail->setFrom('kuppanikiransai@gmail.com', 'KGCET'); // Sender Email and name
        $mail->addAddress($email); // Add a recipient email
        $mail->addReplyTo($email, $name); // Reply to sender email

        // Content
        $body = "
            <img src='https://www.ksrmce.ac.in/data1/images/s2.jpg' alt='Sample Image' style='max-width: 100%; height: 50%;'>
            <h1>Thank you for registering!</h1>
            <p>Dear $name , </p>
            <p>You are successfully registered for the KGCET. Your reference ID is: <h3> $reg_no</h3></p>
           <p>Note: This Reference id will helpfull for your future reference</p>
            
           
            
        "; // Example image with max-width set to ensure it fits in the email

        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "Registration successful"; // Email subject heading
        $mail->Body = $body; // Email message

        // Send email
        $mail->send();
    } else {
        // Registration failed
        $message = "Error: " . $conn->error;
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4l-8 8-4-4 1.5-1.5L4 10V3h8v4h4V3h8v7l2 2V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0 1v18c0 .55.45 1 1 1h22c.55 0 1-.45 1-1V6l-2-2-2 2V4z"/></svg>';
        $color = 'green';
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .message-container {
            text-align: center;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .icon {
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff; /* Blue background color */
            color: white; /* White text color */
            border: none; /* No border */
            padding: 10px 20px; /* Padding */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Cursor on hover */
            margin: 5px; /* Margin */
        }

        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>

<body>
    <div class="message-container">
        <div class="icon"><?php echo $icon; ?></div>
        <h1 style="color: <?php echo $color; ?>"><?php echo $message; ?></h1>
        <button type="submit" class="back-button" onclick="goBack()" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin: 5px;">Back</button>

        <button onclick="window.location.href='index.php'" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin: 5px;">HOME</button>
    </div>

    <script>
        function goBack() {
            window.location.replace(document.referrer);
        }
    </script>
</body>

</html>


