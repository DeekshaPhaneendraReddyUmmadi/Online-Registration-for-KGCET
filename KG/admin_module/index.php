<?php
session_start();
if(isset($_SESSION['loggedin']))
{
    header("Location: admin_home.php");
    exit;
}

// Replace these with your actual database credentials
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
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Query to retrieve user from the database
    $sql = "SELECT * FROM admin_password WHERE username = '$enteredUsername' AND password = '$enteredPassword'";
    $result = $conn->query($sql);

    // Check if the query returned any rows (user found)
    if ($result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();
          //session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['password'] = $userData['password'];
        $_SESSION['username']=$userData['username'];
        // Redirect to admin_interface.php
        header("Location: admin_home.php");
        exit();
    } else {
        $errorMessage = "Invalid username or password.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Animated Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
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

    .login-container {
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

    .admin-icon {
      text-align: center;
      margin-bottom: 20px;
    }

    .admin-icon i {
      font-size: 48px;
      color: #007bff;
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
      width: 105%;
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

    .change-password {
      text-align: center;
      margin-top: 20px;
    }

    .change-password button {
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 8px 16px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .change-password button:hover {
      background-color: #218838;
    }

  </style>
</head>
<body>

  <div class="login-container">
    <div class="admin-icon">
      <i class="fas fa-user-shield"></i>
    </div>
    <h2>ADMIN</h2>
    <form  method="POST" action="index.php">
      <input type="text" id="username" name="username" placeholder="Username" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div class="error-message" id="error-message"><?php echo isset($errorMessage) ? $errorMessage : ''; ?></div>
    <div class="change-password">
    <form method="post" action="change_psw.php">
    <!-- Your form fields here -->
    <button type="submit" name="form_submit"><i class="fas fa-key"></i> Change Password</button>
</form>
    </div>
  </div>

</body>
</html>
