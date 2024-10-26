<?php
session_start();
if(!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <title>Database Table</title>
    <style>
        /* General table styles */
table {
    border: 1px solid black;
    border-collapse: collapse;
    width: 100%;
    min-width:max-content;
    text-align-last: center;
    border-spacing: 0px;
    overflow-y: auto;
}

/* Sticky header styles */
thead {
    position: sticky;
    top: 0px;
    background-color:teal;
    color: wheat;
    z-index: 1; /* Ensure the header stays above other content */
    overflow-y: auto;
}
       
th, td {
    position: relative;
    align-content: center;
    border: 1px solid black;
    padding: 30px;
    text-align: center;
   
}


/* Image styles */
img {
    max-width: 100px;
    max-height: 100px;
}

/* Table wrapper styles */
.table-wrapper {
    max-height: 500px;
    overflow: auto; /* Use 'auto' to show scrollbar only when necessary */
    margin: 30px;
}
/* Sticky header styles */
.middle{
    text-align: center;
   
}

/* Responsive styles */
@media only screen and (max-width: 600px) {
    table {
        overflow-x: auto; /* Add horizontal scroll for small screens */
    }
}



    </style>
</head>
<body>
    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="students_fetch.php" method="POST">
                <div class="modal-body">
                    <!-- Form fields will be dynamically filled here -->
                    <input type="hidden" name="edit_reg_id" id="editRegId">
                    <!-- Add other fields as necessary -->
                    <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="form-lable">Name</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="editName" name="name" class="form-control" required  >
                                <div id="nameError" class="text-danger" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="form-lable">Name</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="editFatherName" name="fathername" class="form-control" required  >
                                <div id="fathernameError" class="text-danger" style="display:none;"></div>
                            </div>
                        </div>
                    
                    <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">Registration_id:- </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="editRegistration" name="Registration_id" class="form-control" required disabled >
                                <div id="registrationError" class="text-danger" style="display:none;"></div>
                            </div>
                        </div>
                    <div class="mb-3 row">
                        <div class="col-sm-4">
                            <label class="lable">District:- </label>
                        </div>
                        <div class="col-sm-8">
                            <select id="editDistrict" name="district" class="form-control" required>
                                <option value="">Select District</option>
                                <option value="kadapa">Kadapa</option>
                                <option value="chittor">Chittor</option>
                                <option value="anathapuram">Anathapuram</option>
                                <option value="kurnool">Kurnool</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">Intermediate Hallticket :- </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="editintermediate_hallticket" name="intermediate_hallticket" class="form-control" required >
                                <div id="intermediateHallticketError" class="text-danger" style="display:none;"></div>
                            </div>
                    </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">Gender :- </label>
                            </div>
                            <div class="col-sm-8">
                                <select id="editgender" name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">DOB:- </label>
                            </div>
                            <div class="col-sm-8" required>
                                <input type="date" id="editdob" name="dob" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">Category:- </label>
                            </div>
                            <div class="col-sm-8">
                                <select id="editcategory" name="category" class="form-control" required>
                                    <option value="">Select your category</option>
                                    <option value="SC">ST</option>
                                    <option value="ST">SC</option>
                                    <option value="OBC">OBC</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">Email:- </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="editemail" name="email" class="form-control" required>
                                <div id="emailError" class="text-danger" style="display:none;"></div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label class="lable">Mobile No:- </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="editmobile" name="mobile" maxlength="10" class="form-control" required>
                                <div id="mobileError" class="text-danger" style="display:none;"></div>
                            </div>
                        </div>
                        
                    <!-- Repeat for other fields -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

                

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<?php include 'header1.php'; ?>

<!-- Step 1: Connect to your database -->
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

// Step 2: Execute a query to fetch the desired data
// Step 2: Execute a query to fetch the desired data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch data from form
    $regId = $_POST['edit_reg_id'];
    $name = $_POST['name'];
    $fathername = $_POST['fathername'];
    $district = $_POST['district'];
  //  $reg = $_POST['Registration_id'];
    $inter=$_POST['intermediate_hallticket'];
    $gender=$_POST['gender'];
    $dob=$_POST['dob'];
    $category=$_POST['category'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];

    // Perform necessary sanitation and validation here

    // Prepare your SQL update statement
$sql = "UPDATE registrations SET name=?, fname=?, address=?, intermediate_hallticket=?, gender=?, dob=?, category=?, email=?, mobile=? WHERE reg_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssi", $name, $fathername, $district, $inter, $gender, $dob, $category, $email, $mobile, $regId);

if ($stmt->execute()) {
    // Redirect or inform of success
    echo "<script>alert('Update successful'); window.location.href='students_fetch.php';</script>";
} else {
    echo "Error updating record: " . $conn->error;
}
}


// Step 3: Handle deletion request
// Step 3: Handle deletion request
// Step 3: Handle deletion request
// Step 3: Handle deletion request
// Step 3: Handle deletion request
if (isset($_POST['delete_reg_id'])) {
    $deleteId = $_POST['delete_reg_id'];
    $deleteSql = "DELETE FROM registrations WHERE reg_id=?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $deleteId);
    if ($deleteStmt->execute()) {
        // Deletion successful
        // Return a specific message upon successful deletion
        echo "Record deleted successfully";
        exit; // Ensure that nothing else is echoed after this point
    } else {
        // Handle deletion failure
        // Optionally, you can provide feedback to the user here
        echo "Error deleting record";
        exit; // Ensure that nothing else is echoed after this point
    }
}



?>

<!-- Step 4: Output the HTML table -->
<div style="overflow-x: auto;" class="table-wrapper">
    <table class="table" id="myTable">
        <thead>
            <tr >
               
                <th scope="col" style="text-align: center;" >Sno</th>
                <th scope="col" style="text-align: center;">Application Id</th>
                <th scope="col" style="text-align: center;" >Name</th>
                <th scope="col" style="text-align: center;">Father Name</th>
                <th scope="col" style="text-align: center;">Intermediate Hallticket</th>
                <th scope="col" style="text-align: center;">Gender</th>
                <th scope="col" style="text-align: center;">Date of Birth</th>
                <th scope="col" style="text-align: center;">District</th>
                <th scope="col" style="text-align: center;">Category</th>
                <th scope="col" style="text-align: center;">Photo</th>
                <th scope="col" style="text-align: center;">Signature</th>
                <th scope="col" style="text-align: center;">Email</th>
                <th scope="col" style="text-align: center;">Phone</th>
                <th style="text-align: center;">Action</th>
                
            </tr>
        </thead>
        <tbody class="middle">
            <?php
            $sql = "SELECT * FROM registrations";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $counter=1;
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$counter."</td>";
                    echo "<td>" . $row["reg_no"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["fname"] . "</td>";
                    echo "<td>" . $row["intermediate_hallticket"] . "</td>";
                    echo "<td>" . $row["gender"] . "</td>";
                    echo "<td>" . $row["dob"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td><img src='uploads/" . $row["image"] . "' alt='Image'></td>";
                    echo "<td><img src='uploads/" . $row["sign"] . "' alt='Signature'></td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["mobile"] . "</td>";
                    // Updated "Edit" button with data attribute for modal
                    echo "<td>";
                    echo "<a href='#' class='btn btn-warning editBtn' data-bs-toggle='modal' data-bs-target='#editModal' data-reg-id='" . $row["reg_id"] . "' data-name='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-fathername='" . htmlspecialchars($row["fname"], ENT_QUOTES) . "' data-district='" . htmlspecialchars($row["address"], ENT_QUOTES) . "' data-reg='" . htmlspecialchars($row["reg_no"], ENT_QUOTES) .  "' data-inter='" . htmlspecialchars($row["intermediate_hallticket"], ENT_QUOTES) . "' data-gender='" . htmlspecialchars($row["gender"], ENT_QUOTES) . "' data-dob='" . htmlspecialchars($row["dob"], ENT_QUOTES) .  "' data-category='" . htmlspecialchars($row["category"], ENT_QUOTES) .  "' data-email='" . htmlspecialchars($row["email"], ENT_QUOTES) .  "' data-mobile='" . htmlspecialchars($row["mobile"], ENT_QUOTES) . "'><i class='fas fa-edit'></i> Edit</a>";
                    echo "<span style='margin: 0 5px;'></span>"; // Adjust spacing
                    echo "<button type='button' class='btn btn-danger deleteBtn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-delete-id='" . $row["reg_id"] . "'><i class='fas fa-trash-alt'></i> Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                    $counter++;
                }
            } else {
                // If no rows are found
                echo "<tr><td colspan='14'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div style="text-align: center; margin-top: 20px;">
    
    <div style="display: inline-block;">
        <form action="export_to_excel.php" method="post" style="display: inline;">
            <button type="submit" class="btn btn-success">Export to Excel</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $('.editBtn').on('click', function() {
            // Extract data attributes from the button
            const regId = $(this).data('reg-id');
            const name = $(this).data('name');
            const fathername = $(this).data('fathername');
            const district = $(this).data('district');
            const reg = $(this).data('reg');
            const inter = $(this).data('inter');
            const gender = $(this).data('gender');
            const dob = $(this).data('dob');
            const category = $(this).data('category');
            const email = $(this).data('email');
            const mobile = $(this).data('mobile');
            // Populate the form fields in the modal
            $('#editRegId').val(regId);
            $('#editName').val(name);
            $('#editFatherName').val(fathername);
            $('#editDistrict').val(district);
            $('#editRegistration').val(reg);
            $('#editintermediate_hallticket').val(inter);
            $('#editgender').val(gender);
            $('#editdob').val(dob);
            $('#editcategory').val(category);
            $('#editemail').val(email);
            $('#editmobile').val(mobile);

            // You can add more fields here as needed
        });
    });
</script>

<script>
  // JavaScript for handling delete confirmation
  document.addEventListener('DOMContentLoaded', function () {
    var deleteButtons = document.querySelectorAll('.deleteBtn');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    deleteButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        var regId = e.currentTarget.getAttribute('data-delete-id');
        confirmDeleteBtn.setAttribute('data-delete-id', regId); // Store regId in the confirmation button
      });
    });

    confirmDeleteBtn.addEventListener('click', function() {
      var regId = this.getAttribute('data-delete-id');
      // Send an AJAX request to delete the record
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'students_fetch.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Handle the response, e.g., reload the page or update the UI
          console.log(xhr.responseText); // Log response for debugging
          window.location.reload(); // Reload the page after deletion
        }
      };
      xhr.send('delete_reg_id=' + regId);
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#myTable').DataTable();
  });
</script>


</body>
</html>