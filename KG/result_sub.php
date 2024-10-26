<?php
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
if(isset($_POST['form_submit'])){ // Check if form is submitted
  $ht_no = $_POST['reg_no'];
  $dob = $_POST['dob']; 
}
else{
    header('Location: result_form.html');
  exit();
}


   
   // Step 2: Execute a query to fetch the desired data
   $sql = "SELECT * from exam_schedule WHERE ht_no='$ht_no' and dob='$dob'";
   $result = $conn->query($sql);
   if($result->num_rows == 0)
   {
       echo 'invalid Hallticket number and Date of Birth  <a href="result_form.html">DownloadHallticket</a>..';
       exit();
   }
    $row = $result->fetch_assoc(); 
   $reg_no=$row['reg_no'];

  
       ?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Admission form with PDF preview able..</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <style>
   
    
    .hallticket-info {
            text-align: center;
            margin-bottom: 20px;
        }

        
     .header {
            background-color: #ffcc00;
            color: white;
            padding: 1px;
            text-align: center;
        }
        .image-container {
  display: flex;
  justify-content: center; /* Center the image horizontally */
}

.image-container img {
  width: auto; /* Allow the image to adjust its width */
  max-width: 100%; /* Ensure the image doesn't exceed its container's width */
  margin: 0 20px; /* Increase left and right side edges */
}
@media print {
            a[href]:after {
                content: none !important;
            }

            #printbtn {
                display: none !important;
            }

            .main-heading {
                font-size: 30px !important;
            }

            .underline {
                line-height: 27px !important;
                text-decoration-style: dotted !important;
            }
        }
.click{
            position: relative;
            top:0px;
        }
  </style>
</head>
<body>

  <div class="container">
    <div class="row">
      
      <div class="col-sm-12" style="border: 2px solid black;padding:5px; text-align: center;">
      <div class="header">
        <div class="image-container">
            <img src="banner.jpg" alt="Description">
          </div>
          
    </div>
      </div>
      
    </div>
    
    <div class="row" style="border: 1px solid black; padding:10px;margin-top:7px">
        <div class="col-sm-1">

        </div>
        <div class="col-sm-10" >
            <div class="row">
                <div class="col-sm-12">
            
                <h3 style="text-align:center">Results</h3>
            
        </div>
        </div>
   
        <div class="row" style="padding-top:30px">
            <div class="col-sm-8" style="padding-top:20px">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="lable">Registration No </label>

                    </div>
                    <div class="col-sm-6"> <?php echo $row['reg_no']?></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="lable">Hallticket No  </label>

                    </div>
                    <div class="col-sm-6"> <?php echo $row['ht_no']?></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="lable">Candidate Name  </label>

                    </div>
                    <div class="col-sm-6"> <?php echo $row['name']?></div>
                </div>
                <?php
                $sql = "SELECT * from registrations WHERE reg_no='$reg_no'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc(); 
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="lable">Father Name  </label>

                    </div>
                    <div class="col-sm-6"> <?php echo $row['fname']?></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="lable">Date of Birth(yyyy/mm/dd) </label>

                    </div>
                    <div class="col-sm-6"> <?php echo $row['dob']?></div>
                </div>
                <div class="row">
                <?php
                $sql = "SELECT * from results WHERE ht_no='$ht_no'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc(); 
                ?>
                    <div class="col-sm-6">
                        <label class="lable">Rank  </label>

                    </div>
                    <div class="col-sm-6"> <?php echo $row['rank']?></div>
                </div>
            </div>
            <div class="col-sm-4">
            <?php
                $sql = "SELECT * from registrations WHERE reg_no='$reg_no'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc(); 
                ?>
                    <div class="form-group" style="float: right;">
                         <label class="lable"> Photo </label>
                   <div style="width: 150px; ">
                      <img src="admin_module/uploads/<?php echo $row['image']; ?> "  width="150" height="150">
                  </div>
                
                  </div>
                  
            </div>
            <hr>
            <?php
                $sql = "SELECT * from results WHERE ht_no='$ht_no'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc(); 
                ?>
            <table class="table">
                <thead>
                  <tr>
                    
                    <th scope="col">Subject</th>
                    <th scope="col">Total Marks</th>
                    <th scope="col">Achieved Marks</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    
                    <th>Maths</th>
                    <td>60</td>
                    <td><?php echo $row['maths']?></td>
                  </tr>
                  <tr>
                    
                    <th>Physics</th>
                    <td>60</td>
                    <td><?php echo $row['physics']?></td>
                  </tr>
                  <tr>
                    <th>Chemistry</th>
                    <td>60</td>
                    <td><?php echo $row['chemistry']?></td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td>180</td>
                    <td><?php echo $row['total']?></td>
                  </tr>
                </tbody>
              </table>
        </div>
        
            
        
        </div>
        <div class="col-sm-1"></div>

    </div>
    <br>
<center>
<button class="click" id="printbtn" onclick="window.location.href='index.php'" style="background-color: #007bff; color: white; border: none; padding: 6px 21px; border-radius: 5px; cursor: pointer; margin: 5px;top:2px;">HOME</button>
<button type="button" class="btn btn-warning" id="printbtn" onclick="window.print()">Print Form</button></center>
<br>
  </div>
  
</body>
</html>