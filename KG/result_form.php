<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <title>Registration Form</title>
    <style>
         
        .container1 {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-left: 60px;
        }

        h2 {
            text-align: center;
        }

      
       
        .centered-text {
            text-align: center;
        }

       

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .back-button {
      position: relative;
      bottom: 15px;
      right: 25px;
      background-color: transparent;
      border: none;
      cursor: pointer;
      font-size: 20px;
      color: #333;
      padding: 10px;
    }
        #ht{
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #menu{
        background-color: #154360;
            padding-top:0px;
            
            overflow: hidden;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id=menu>
    <?php include 'header.php'; ?>
    </div>

<div class="container-fluid">
    <div class="row">
   

    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 mt-5">
                    <div class="container1">
                        <form action="result_sub.php" method="post">
                            <button class="back-button" onclick="window.location.href='index.php'">
                                <i class="fas fa-angle-double-left"></i> Back<!-- Font Awesome left arrow icon -->
                            </button>
                            <div class="form-group">
                                <label for="reg_no">Hallticket Number:</label>
                                <input type="text" id="reg_no" name="reg_no" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" id="dob" name="dob" required>
                            </div>
                            <button type="submit" name="form_submit"  id="ht" style="align-items: center;">Download Result</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

</body>
</html>
