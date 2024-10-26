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
  $reg_no = $_POST['reg_no'];
  $dob = $_POST['dob']; 
}
else{
    header('Location: down_sample.html');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <title>KGCET HALLTICKET 2024</title>
    <style>
              @page {
            size: auto;
            margin: 10mm;
            margin-right: -100px;
            margin-left: -90px;
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
        
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .body-media {
            border: 2px solid #333;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 88%;
            margin: 0 auto;
            text-align: center;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .main-heading {
                font-size: 30px !important;
            }
        td:nth-child(1)
        {
            background-color: lightgray;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: lightgray;
        }
        .instruction-box {
            border: 2px solid #333;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .centered-text {
            text-align: center;
        }
        .click{
            position: relative;
            top:1px;
        }
       
    </style>
</head>
<body>
<?php
   
    // Step 2: Execute a query to fetch the desired data
    $sql = "SELECT * from registrations WHERE reg_no='$reg_no' and dob='$dob'";
    $result = $conn->query($sql);
    if($result->num_rows == 0)
    {
        echo 'invalid registration id and dob  <a href="down_sample.html">DownloadHallticket</a>..';
    }
    else
    {
        ?>
   
    
    <div class="body-media">
    <div class="row">
                        <div class="col-2">
                            <img src="logo.jpg" class="img-fluid">
                        </div>
                        <div class="col">
                            <div class="main-heading">KSRM COLLEGE OF ENGINEERING-KGCET</div>
                            <div class="autonomous">
                                <p class="sub-heading"> (Autonomous)</p>
                            </div>
                            <div class="address centered-text"> Kadapa,Andhra Pradesh,India-516003</div>
                            <p class="email centered-text"> Approved by AICTE,New Delhi & Affiliated byJNTUA,Anathapuram</p>
                        </div>
                        <div class="col-sm-12">
                            <hr class="hrcls">
                        </div>
                    </div>
        <center>
        <table>
            <?php $row = $result->fetch_assoc(); ?>
            <tr >
                <td width="30%" >Name:</td>
                <td><?php echo $row['name']?></td>
                <td width="30%" align="center">Hallticket Number</td>
            </tr>
            <tr>
                <td >Registration no</td>
                <td ><?php echo $row['reg_no']?></td>
                <td align="center">2419867541</td>
            </tr>
            <tr>
                <td>Father Name</td>
                <td><?php echo $row['fname']?></td>
                <td rowspan="8" width="0%" style="padding-left:180px"><div class="col-6">
  <div class="row">
    <div class="col-12">
    <div class="form-group" style="float: right;">
         <label class="lable"> Photo </label>
   <div style="width: 150px; ">
      <img src="admin_module/uploads/<?php echo $row['image']; ?> "  width="150" height="150">
  </div>

  </div>
  </div>
  </div>  
  
  <div class="row">
    <div class="col-12">
      <div class="form-group" style="float: right;">
         <label class="lable">Signature</label>
   <div style=" width: 150px; ">
      <img src="admin_module/uploads/<?php echo $row['sign']; ?>"  width="151" height="120" />
  </div>
  </div>  
    </div>
  </div>

    </div>

</div>  </td>
            </tr>
            <tr>
                <td>Date of Birth</td>
                <td><?php echo $row['dob']?></td>
            </tr>
            <tr>
                <td>Intermediate Hallticket</td>
                <td><?php echo $row['intermediate_hallticket']?></td>
            </tr>
            <tr>
                <td>District</td>
                <td><?php echo $row['address']?></td>
            </tr>
            <tr>
                <td>Email id</td>
                <td><?php echo $row['email']?></td>
            </tr>
            <tr>
                <td>Mobile No</td>
                <td><?php echo $row['mobile']?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><?php echo $row['gender']?></td>
                
            </tr>
            <tr>
                <td>Category</td>
                <td><?php echo $row['category']?></td>
                
            </tr>
        </table>
        <br>
        <?php 
        $sql = "SELECT exam_date, exam_time FROM exam_schedule where reg_no='$reg_no'";

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <table>
            <tr>
                <th colspan="3">Test Details</th>
            </tr>
            <tr>
                <td>Date of the Test</td>
                <td colspan="2"><?php echo $row['exam_date']?></td>
            </tr>
            <tr>
                <td>Test Time </td>
                <td colspan="2"><?php echo $row['exam_time']?></td>
            </tr>
            <tr>
                <td>Test City</td>
                <td colspan="2">KADAPA</td>
            </tr>
            <tr>
                <td>Test Center</td>
                <td>ksrm college</td>
                <td style="background-color: beige;"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
                
                <td align="center">Signature of the invigilator</td>
            </tr>
        </table>
        
        </center>
    
    
        <h3>Guidelines and instructions to the candidates:</h3>
        <ol style="text-align: left;">
            <li>Arrive early.</li>
            <li>Read instructions carefully.</li>
            <li>Manage time wisely.</li>
            <li>Answer clearly and follow guidelines.</li>
            <li>Follow special instructions.</li>
            <li>Ask for clarification if needed.</li>
            <li>Review answers if time allows.</li>
            <li>Stop writing when instructed.</li>
            <li>Exit quietly when done.</li>
            <li>Await further instructions for results.</li>
        </ol>
        <br>
     <center>
    <button class="click" id="printbtn" onclick="window.location.href='index.php'" style="background-color: #007bff; color: white; border: none; padding: 6px 20px; border-radius: 5px; cursor: pointer; margin: 5px;">HOME</button>
    <button type="button" class="btn btn-warning no-print" id="printbtn" onclick="window.print()">Download</button></center>
        <br>
    
     <?php } ?>
    </div>
 
       
</body>
</html>