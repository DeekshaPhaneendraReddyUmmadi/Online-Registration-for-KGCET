<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <style>
        body {
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

header {
    width: 100%; /* Set the width to 100% */
    height: 140px; /* Adjust the height as needed */
    background: url('banner.jpg') center/cover no-repeat; /* Replace 'your-banner-image.jpg' with your actual image path */
    text-align: center;
    color: #fff;
    padding-top: 50px;
    box-sizing: border-box; /* Include padding and border in the width calculation */
}

nav a {
    float: left;
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    margin-right: 50px; /* Adjust the margin as needed to increase the space between navigation buttons */
}

nav a:hover {
    background-color: #f39c12;
    color: black;
}

nav {
    background-color: #154360;
    overflow: hidden;
    height: 45px;
}




    </style>
</head>
<body>
<header>
        

        </header>
    

    <nav>
        <a href="admin_home.php">Home</a>
        <a href="students_fetch.php">Student Details</a>
        <a href="date_updates.php">Dates Updates</a>
        <a href="schedule.php">Hallticket Arrange</a>
        <a href="upload_results.php">Results</a>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>
