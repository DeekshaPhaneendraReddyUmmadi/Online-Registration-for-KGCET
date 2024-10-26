<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lokesh";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['form_submit'])){
    $sql = "SELECT * FROM admin_password where sno=1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $email = $row['username'];
    $otp = rand(10000, 99999);

    $currentTimestamp = time();
    $otpExpiresInMinutes = 3;

    $otpGeneratedAt = date('Y-m-d H:i:s', $currentTimestamp);
    $otpExpiresAt = date('Y-m-d H:i:s', $currentTimestamp + ($otpExpiresInMinutes * 60));

    $sql = "UPDATE admin_password SET otp=?, otp_generated_at=?, otp_expires_at=?, otp_used=0 WHERE sno=1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param('iss', $otp, $otpGeneratedAt, $otpExpiresAt);
    if ($stmt->execute()) {
        $message = "OTP sent successfully!<br>Your OTP is: " . $otp;
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
        $color = 'green';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kuppanikiransai@gmail.com';
        $mail->Password   = 'cucupxrwtknrbzyc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('kuppanikiransai@gmail.com', 'ADMIN');
        $mail->addAddress($email);
        $mail->addReplyTo($email);

        $mail->isHTML(true);
        $mail->Subject = "OTP sent successfully";
        $mail->Body = "<h3>Your OTP is $otp </h3>";

        if (!$mail->send()) {
            $message .= "Mailer Error: " . $mail->ErrorInfo;
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4l-8 8-4-4 1.5-1.5L4 10V3h8v4h4V3h8v7l2 2V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0 1v18c0 .55.45 1 1 1h22c.55 0 1-.45 1-1V6l-2-2-2 2V4z"/></svg>';
            $color = 'red';
        }
    } else {
        $message = "Error: " . $conn->error;
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4l-8 8-4-4 1.5-1.5L4 10V3h8v4h4V3h8v7l2 2V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0
        // .5 0 1v18c0 .55.45 1 1 1h22c.55 0 1-.45 1-1V6l-2-2-2 2V4z"/></svg>';
        // $color = 'red';
    }
}

if(isset($_POST['submit'])){
    $enteredOTP = $_POST["otp"];
    $newPassword = $_POST["new_password"];
    $confirmPassword=$_POST["confirm_password"];
    if($newPassword===$confirmPassword)
    {
        $currentTimestamp = time();

        $sql = "SELECT * FROM admin_password WHERE otp = ? AND otp_used = 0";
        $stmt = $conn->prepare($sql);
                // Binding parameters
                $stmt->bind_param("s", $enteredOTP);

                // Executing the prepared statement
                $stmt->execute();
        
                // Fetching result
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $otpGeneratedAt = strtotime($row['otp_generated_at']);
                    $otpExpiresAt = strtotime($row['otp_expires_at']);
        
                    if ($otpGeneratedAt <= $currentTimestamp && $currentTimestamp <= $otpExpiresAt) {
                        // Mark OTP as used
                        $updateSql = "UPDATE admin_password SET otp_used = 1 WHERE otp = ?";
                        $stmt = $conn->prepare($updateSql);
                        $stmt->bind_param("s", $enteredOTP);
                        $stmt->execute();
        
                        // Update password
                        $updateSql = "UPDATE admin_password SET password = ? WHERE otp = ?";
                        $stmt = $conn->prepare($updateSql);
                        $stmt->bind_param("ss", $newPassword, $enteredOTP);
        
                        if ($stmt->execute()) {
                            $successMessage = "Password changed successfully.";
                        } else {
                            $errorMessage = "Error updating password: " . $conn->error;
                        }
                    } else {
                        // OTP is expired
                        $errorMessage = "OTP has expired. ";
                    }
                } else {
                    // Invalid OTP
                    $errorMessage = "Invalid OTP.";
                }
            } else {
                // Passwords do not match
                $errorMessage = "Passwords do not match.";
            }
        }
        
        // Resend OTP logic
        if (isset($_POST['resend'])) {
            $sql = "SELECT * FROM admin_password WHERE sno = 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['username'];
        
                $currentTimestamp = time();
                $otp = rand(10000, 99999);
                $otpGeneratedAt = date('Y-m-d H:i:s', $currentTimestamp);
                $otpExpiresAt = date('Y-m-d H:i:s', $currentTimestamp + (3 * 60)); // 1 minute expiration
        
                $updateSql = "UPDATE admin_password SET otp = ?, otp_generated_at = ?, otp_expires_at = ?, otp_used = 0 WHERE sno = 1";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("iss", $otp, $otpGeneratedAt, $otpExpiresAt);
                if ($stmt->execute()) {
                    // Send confirmation email
                    // Rest of the email sending logic...
        
                    $message = "New OTP sent successfully!<br>Your OTP is: " . $otp;
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';
                    $color = 'green';
        
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
                    $mail->setFrom('kuppanikiransai@gmail.com', 'ADMIN'); // Sender Email and name
                    $mail->addAddress($email); // Add a recipient email
                    $mail->addReplyTo($email); // Reply to sender email
        
                    $mail->isHTML(true);
                    $mail->Subject = "OTP sent successfully";
                    $mail->Body = "<h3>Your OTP is $otp </h3>";
        
                    if (!$mail->send()) {
                        $message .= " Mailer Error: " . $mail->ErrorInfo;
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4l-8 8-4-4 1.5-1.5L4 10V3h8v4h4V3h8v7l2 2V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0 1v18c0 .55.45 1 1 1h22c.55 0 1-.45 1-1V6l-2-2-2 2V4z"/></svg>';
                        $color = 'red';
                    }
                } else {
                    $message = "Error: " . $conn->error;
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="48px" height="48px"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4l-8 8-4-4 1.5-1.5L4 10V3h8v4h4V3h8v7l2 2V1c0-.55-.45-1-1-1H1C.45 0 0 .45 0.5 0 1v18c0 .55.45 1 1 1h22c.55 0 1-.45 1-1V6l-2-2-2 2V4z"/></svg>';
                    // Continue from where we left off
                }
            }
        }
        ?>
        
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Change Password</title>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
          
          <style>
            /* Your CSS styles */
            body {
              margin: 0;
              padding: 0;
              font-family: Arial, sans-serif;
              background: linear-gradient(to right, #141e30, #243b55);
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
            }
        
            .change-password-container {
              width: 350px;
              background-color: rgba(255, 255, 255, 0.9);
              padding: 40px;
              border-radius: 10px;
              box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
              animation: fadeIn 0.5s ease-in-out;
            }
        
            @keyframes fadeIn {
              from {
                opacity: 0;
                transform: translateY(-20px);
              }
              to {
                opacity: 1;
                transform: translateY(0);
              }
            }
        
            h2 {
              text-align: center;
              margin-bottom: 20px;
              color: #333;
            }
        
            input[type="text"],
            input[type="password"],
            button {
              width: 100%;
              padding: 10px;
              margin-bottom: 20px;
              border: none;
              border-radius: 5px;
              font-size: 16px;
              animation: slideIn 1s forwards;
            }
        
            input[type="text"],
            input[type="password"] {
              background-color: #f5f5f5;
            }
        
            button {
              background-color: #007bff;
              color: #fff;
              cursor: pointer;
              transition: background-color 0.3s;
            }
        
            button:hover {
              background-color: #0056b3;
            }
        
            .error-message {
              color: red;
              text-align: center;
              margin-top: 10px;
              display: <?php echo isset($errorMessage) ? 'block' : 'none'; ?>;
            }
        
            .success-message {
              color: green;
              text-align: center;
              margin-top: 10px;
              display: <?php echo isset($successMessage) ? 'block' : 'none'; ?>;
            }
            .success-message i {
              color: green;
              font-size: 24px;
              margin-right: 5px;
              animation: zoomIn 0.5s ease-in-out;
            }
        
            @keyframes zoomIn {
              from {
                transform: scale(0);
              }
              to {
                transform: scale(1);
              }
            }
            .error-message {
              color: red;
              text-align: center;
              margin-top: 10px;
              display: <?php echo isset($errorMessage) ? 'block' : 'none'; ?>;
            }
        
            .error-message i {
              color: red;
              font-size: 24px;
              margin-right: 5px;
              animation: shake 0.5s ease-in-out;
            }
        
            @keyframes shake {
              0% { transform: translateX(0); }
              25% { transform: translateX(-5px); }
              50% { transform: translateX(5px); }
              75% { transform: translateX(-5px); }
              100% { transform: translateX(0); }
            }
            .back-button {
  position: absolute;
 /* Adjust as needed */
 top: 95px;
  left: 500px; /* Adjust as needed */
  background-color: transparent;
  border: none;
  cursor: pointer;
  font-size: 20px;
  color: black;
  padding: 0; /* Remove default padding */
  width: 40px; /* Adjust to match the size of the arrow icon */
  height: 40px; /* Adjust to match the size of the arrow icon */
  display: flex;
  justify-content: center;
  align-items: center;
}

.back-button i {
  margin: 0;
  padding: 0;
}

.back-button:hover {
  background-color: transparent; /* Remove hover effect */
}

          </style>
        </head>
        <body>
      
         
          
        <div class="change-password-container">
            <!-- Your PHP code for error and success messages here -->
            <?php if (isset($errorMessage)) { ?>
                <div class="error-message"><i class="fas fa-exclamation-circle"></i><?php echo $errorMessage; ?></div>
            <?php } ?>
            <?php if (isset($successMessage)) { ?>
                <div class="success-message"><i class="fas fa-check-circle"></i><?php echo $successMessage; ?></div>
            <?php } ?>
           

        
            <h2>Change Password</h2>
            
            <form action="change_psw.php" id="change-password-form"  method="POST">
            <button class="back-button" onclick="goBack()">
            <i class="fas fa-arrow-left"></i> <!-- Font Awesome left arrow icon -->
          </button>
              <!-- Your form fields -->
              <input type="text" id="otp" name="otp" placeholder="OTP" required>
              <input type="password" id="new_password" name="new_password" placeholder="New Password" required>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
              <button type="submit" name="submit">Submit</button>
            

              
            </form>
            <form method="post" action="change_psw.php">
            <button type="submit" id="resend-btn" name="resend" <?php if (isset($otpExpiresAt) && strtotime($otpExpiresAt) > time()) echo 'disabled'; ?>>Resend OTP</button>
            <span id="timer"></span>
    </form>
</div>

<script>
  // JavaScript code to calculate timer and handle resend button

  // Function to update the timer
  function updateTimer(otpExpirationTimestamp) {
    // Get current timestamp
    var currentTimestamp = Math.floor(Date.now() / 1000);

    // Calculate remaining seconds
    var remainingSeconds = otpExpirationTimestamp - currentTimestamp;

    // If remaining seconds are less than or equal to 0, OTP has expired
    if (remainingSeconds <= 0) {
      document.getElementById("timer").innerText = "OTP expired";
      document.getElementById("resend-btn").disabled = false; // Enable resend button
    } else {
      // Format remaining time
      var minutes = Math.floor(remainingSeconds / 60);
      var seconds = remainingSeconds % 60;
      document.getElementById("timer").innerText = "Resend OTP in: " + minutes + "m " + seconds + "s";
      document.getElementById("resend-btn").disabled = true; // Disable resend button
    }
  }

  // Call updateTimer initially to start the timer if OTP expiration timestamp is available
  <?php if (isset($otpExpiresAt)) { ?>
    var otpExpirationTimestamp = <?php echo strtotime($otpExpiresAt); ?>;
    updateTimer(otpExpirationTimestamp);
    // Update the timer every second
    var timerInterval = setInterval(function() {
      updateTimer(otpExpirationTimestamp);
    }, 1000);
  <?php } ?>
</script>


<script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>
        
