<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            padding: 3px;
            background-color: #ffcc00;
        }

        .banner {
            background-color: #ffcc00;
            color: #fff;
            text-align: center;
            position: relative;
        }

        .banner img {
            max-width: 100%;
            height: auto;
        }

        .banner h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        nav {
            background-color: #154360;
            overflow: hidden;
            display: flex;
            align-items: center;
            
        }

        nav a {
            color: white;
            text-align: center;
            padding: 14px 50px; 
            text-decoration: none;
        }

        nav a:hover {
            background-color: #f39c12;
            color: black;
        }

        .menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 20px;
            color: white;
            display: none;
        }

        .menu-links {
            display: none;
            background-color: #154360;
            text-align: left;
            padding-top: 10px;
            width: 50%;
        }

        .menu-links a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
        }

        @media only screen and (max-width: 768px) {
            .menu-btn {
                display: block;
                margin-left: auto;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav a {
                display: none;
            }

            .menu-links.active {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="banner">
      <img src="banner.jpg" alt="Banner Image">
      
    </div>
</header>

<nav>
    <button class="menu-btn" onclick="toggleMenu()">☰</button>
    <div class="menu-links" id="menuLinks">
        <a href="index.php">HOME</a>
        <a href="about_us.php">ABOUT US</a>
        <a href="important_dates.php">IMPORTANT DATES</a>
        <a href="contact.php">CONTACT US</a>
    </div>
    <!-- These links will be hidden on screens smaller than 768px -->
        <a href="index.php">HOME</a>
        <a href="about_us.php">ABOUT US</a>
        <a href="important_dates.php">IMPORTANT DATES</a>
        <a href="contact.php">CONTACT US</a>
</nav>

<script>
    function toggleMenu() {
        var menuLinks = document.getElementById("menuLinks");
        menuLinks.classList.toggle("active");
    }
</script>

</body>
</html>
