<?php 

$al=false;
 ?>
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



// Step 3: Handle deletion request
// Step 3: Handle deletion request
// Step 3: Handle deletion request
// Step 3: Handle deletion request
// Step 3: Handle deletion request
if (isset($_POST['delete_reg_id'])) {
    $deleteId = $_POST['delete_reg_id'];
    $deleteSql = "DELETE FROM exam_schedule WHERE id=?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $deleteId);
    if ($deleteStmt->execute()) {
        $al=true;
        // Deletion successful
        // Return a specific message upon successful deletion
        echo "Record deleted successfully";
        // Ensure that nothing else is echoed after this point
    } else {
        // Handle deletion failure
        // Optionally, you can provide feedback to the user here
        echo "Error deleting record";
        exit; // Ensure that nothing else is echoed after this point
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
  
    
    <style>
              
table {
    border: 1px solid black;
    border-collapse: collapse;
    width: 100%;
    min-width: max-content;
    text-align-last:center ;
    border-spacing: 0px;
    overflow-y: auto;
}

 
/* Table wrapper styles */
.table-wrapper {
    max-height: 500px; /* Set the maximum height for the table */
    overflow-y: scroll; /* Add vertical scroll bar */
    margin: 20px;
    
}




/* Responsive styles */
@media only screen and (max-width: 600px) {
    table {
        overflow-x: auto; /* Add horizontal scroll for small screens */
    }
}

 /* Sticky header styles */
thead {
    position: sticky;
    top: 0px;
    background-color:teal;
    color: wheat;
    z-index: 1; /* Ensure the header stays above other content */
    overflow-y: auto;
    text-align: center;
}

 th, td {
    border: 1px solid black;
    padding: 20px;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Alternate row color */
}
tbody tr:hover {
    background-color: #e0e0e0; /* Hover color */
}
.action-buttons {

    justify-content: center;
    align-items: center;
}
.edit-btn, .delete-btn {
    padding: 6px 12px;
    margin: 0 5px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.edit-btn {
    position: relative;
    top: 3px;
    background-color: #4CAF50;
    color: white;
}
.delete-btn {
    background-color: #f44336;
    color: white;
}
/* Styling for colorful icons */
.filter-icon {
    color: #007bff; /* Blue */
    margin-right: 5px;
}
.download-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
        
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
    <?php include 'header1.php' ?>


    </div>
    <?php 
    if($al){
        echo '<div class="alert alert-success" role="alert">
        A simple success alert—check it out!
      </div>';
    }
     ?>
   <center> <h2>Exam Schedule</h2></center>

    <!-- Filter Form -->
    <form id="filterForm">
        <label for="dateFilter"><i class="fas fa-calendar-alt filter-icon"></i> Filter by Date:</label>
        <input type="date" id="dateFilter" onchange="filterTable()">
        <label for="timeFilter"><i class="fas fa-clock filter-icon"></i> Filter by Time:</label>
        <select id="timeFilter" onchange="filterTable()">
            <option value="">All Times</option>
            <?php
            // Database connection
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

            // SQL query to fetch unique exam times
            $sql = "SELECT DISTINCT exam_time FROM exam_schedule";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row["exam_time"]."'>".$row["exam_time"]."</option>";
                }
            }

            $conn->close();
            ?>
        </select>
    </form>

   
   
    <div id="tableSuccessMessage" ></div>
    <div class="table-wrapper">

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Registration Number</th>
                <th>Ht_no</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>District</th>
                <th>Exam Date</th>
                <th>Exam Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            // Database connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Initialize counter variable
            $counter = 1;

            // SQL query to fetch all data from exam_schedule table
            $sql = "SELECT id, reg_no, ht_no, name, DATE_FORMAT(dob, '%d-%m-%Y') as dob, district, DATE_FORMAT(exam_date,'%d-%m-%Y') as exam_date, exam_time FROM exam_schedule";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                       echo "<td>".$counter."</td>";
                       echo"<td>".$row["reg_no"]."</td>";
                      echo  " <td>".$row["ht_no"]."</td>";
                        echo  "<td>".$row["name"]."</td>";
                          echo  "<td>".$row["dob"]."</td>";
                           echo  "<td>".$row["district"]."</td>";
                            echo"<td>".$row["exam_date"]."</td>";
                           echo " <td>".$row["exam_time"]."</td>";
                           echo "<td class='action-buttons'>";
                           echo "<button class='edit-btn' onclick='populateModal(\"".$row["id"]."\", \"".htmlspecialchars($row["name"], ENT_QUOTES)."\", \"".htmlspecialchars($row["ht_no"], ENT_QUOTES)."\", \"".htmlspecialchars($row["reg_no"], ENT_QUOTES)."\", \"".htmlspecialchars($row["dob"], ENT_QUOTES)."\", \"".htmlspecialchars($row["district"], ENT_QUOTES)."\", \"".$row["exam_date"]."\", \"".$row["exam_time"]."\")' data-bs-toggle='modal' data-bs-target='#editModal'><i class='fas fa-edit'></i> Edit</button>";
                           echo "<button type='button' class='btn btn-danger deleteBtn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-delete-id='" . $row["id"] . "'><i class='fas fa-trash-alt'></i> Delete</button>";
                           echo "</td>";

                       echo " </tr>";
                    // Increment counter for the next row
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='8'>No results found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
        
    </table>
    </div>

    <!-- Download Button -->
    <button class="download-btn" onclick="downloadSchedule()">Download Schedule</button>

    <!-- Edit Button -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="0" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form fields for editing -->
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="edithallticket" class="form-label">Hallticket</label>
                        <input type="text" class="form-control" id="edithallticket" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRegistration" class="form-label">Registration ID</label>
                        <input type="text" class="form-control" id="editRegistration" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editdob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="editdob" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editDistrict" class="form-label">District</label>
                        <select class="form-control" id="editDistrict" disabled>
                            <option value="kadapa">Kadapa</option>
                            <option value="chittor">Chittor</option>
                            <option value="anathapuram">Anathapuram</option>
                            <option value="kurnool">Kurnool</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editdate" class="form-label">Exam Date</label>
                        <input type="date" class="form-control" id="editdate">
                    </div>
                    <div class="mb-3">
                        <label for="editTime" class="form-label">Exam Time</label>
                        <input type="time" class="form-control" id="editTime">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </div>
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
<script>
    // Function to populate the edit modal with existing data
    function populateModal(id, name, ht_no, reg_no, dob, district, exam_date, exam_time) {
    $('#editId').val(id);
    $('#editName').val(name);
    $('#edithallticket').val(ht_no);
    $('#editRegistration').val(reg_no);
    $('#editdob').val(convertToInputDate(dob)); // Convert date to input format
    $('#editDistrict').val(district);
    $('#editdate').val(convertToInputDate(exam_date)); // Convert date to input format
    $('#editTime').val(exam_time);
}

function convertToInputDate(dateString) {
    // Convert date from dd-mm-yyyy to yyyy-mm-dd (input format)
    var parts = dateString.split("-");
    return parts[2] + "-" + parts[1] + "-" + parts[0];
}


    function saveChanges() {
    var id = $('#editId').val();
    var name = $('#editName').val();
    var ht_no = $('#edithallticket').val();
    var dob = $('#editdob').val();
    var district = $('#editDistrict').val();
    var exam_date = $('#editdate').val();
    var exam_time = $('#editTime').val();

    $.ajax({
        url: 'update_record.php', // Replace with the URL of your update script
        type: 'POST',
        data: {
            id: id,
            name: name,
            ht_no: ht_no,
            dob: dob,
            district: district,
            exam_date: exam_date,
            exam_time: exam_time
        },
        success: function(response) {
            // Fetch updated table data and refresh the table
            fetchTableData();
            $('#editModal').modal('hide');
            
            // Display success message
            var successMessage = $('<div class="alert alert-success" role="alert">Record updated successfully!</div>');
            $('#tableSuccessMessage').html(successMessage);
            setTimeout(function() {
                successMessage.remove();
            }, 8000); // Remove the message after 3 seconds
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error occurred while updating record.');
        }
    });
}


// Function to fetch table data and update the table
// Function to fetch table data and update the table
function fetchTableData() {
    $.ajax({
        url: 'fetch_table_data.php', // Replace 'fetch_table_data.php' with the actual URL of your server-side script
        type: 'GET',
        success: function(response) {
            // Assuming the response is in JSON format and contains an array of objects representing table rows
            var tableData = JSON.parse(response);

            // Clear existing table rows
            $('#tableBody').empty();

            // Initialize counter variable
            var counter = 1;

            // Iterate through the fetched data and append rows to the table
            $.each(tableData, function(index, rowData) {
                var rowHtml = "<tr>" +
                    "<td>" + counter + "</td>" + // Use counter instead of rowData.counter
                    "<td>" + rowData.reg_no + "</td>" +
                    "<td>" + rowData.ht_no + "</td>" +
                    "<td>" + rowData.name + "</td>" +
                    "<td>" + rowData.dob + "</td>" +
                    "<td>" + rowData.district + "</td>" +
                    "<td>" + rowData.exam_date + "</td>" +
                    "<td>" + rowData.exam_time + "</td>" +
                    "<td class='action-buttons'>" +
                    "<button class='edit-btn' onclick='populateModal(" + rowData.id + ", \"" + rowData.name + "\", \"" + rowData.ht_no + "\", \"" + rowData.reg_no + "\", \"" + rowData.dob + "\", \"" + rowData.district + "\", \"" + rowData.exam_date + "\", \"" + rowData.exam_time + "\")' data-bs-toggle='modal' data-bs-target='#editModal'><i class='fas fa-edit'></i> Edit</button>" +
                    "<button class='delete-btn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='" + rowData.id + "'><i class='fas fa-trash-alt'></i> Delete</button>" +
                    "</td>" +
                    "</tr>";

                $('#tableBody').append(rowHtml);
                
                // Increment counter for the next row
                counter++;
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error occurred while fetching table data.');
        }
    });
}


</script>
<!-- Your existing JavaScript code -->
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
      xhr.open('POST', 'show_schedule.php', true);
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





    <script>
        // Function to filter table rows based on date and time
        function filterTable() {
            var dateFilterValue = document.getElementById("dateFilter").value;
            var timeFilterValue = document.getElementById("timeFilter").value;

            var rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(function(row) {
                var examDate = row.querySelector("td:nth-child(7)").textContent;
                var examTime = row.querySelector("td:nth-child(8)").textContent;

                var formattedExamDate = formatDate(examDate); // Format date
                var formattedExamTime = examTime;

                // Show row if both date and time match, or if filters are empty
                if ((formattedExamDate === dateFilterValue || dateFilterValue === "") &&
                    (formattedExamTime === timeFilterValue || timeFilterValue === "" || timeFilterValue === "All Times")) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
        // Function to handle delete record action

        // Function to format date from dd-mm-yyyy to yyyy-mm-dd
        function formatDate(dateString) {
            var parts = dateString.split("-");
            return parts[2] + "-" + parts[1] + "-" + parts[0];
        }

        
    
// Function to fetch table data and update the table


        // Function to download schedule
        function downloadSchedule() {
            // Collect filtered and visible table data
            var visibleRows = document.querySelectorAll("#tableBody tr:not([style*='display: none'])");
            var csvContent = "data:text/csv;charset=utf-8,";

            // Manually adding headers
            var headers = ["ID", "Registration Number", "Ht_no", "Name", "Date of Birth", "District", "Exam Date", "Exam Time"];
            csvContent += headers.join(",") + "\n";

            // Append row data
            visibleRows.forEach(function(row) {
                var rowData = [];
                row.querySelectorAll("td:not(.action-buttons)").forEach(function(cell) { // Exclude action-buttons column
                    rowData.push(cell.textContent);
                });
                csvContent += rowData.join(",") + "\n";
            });

            // Trigger download
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "exam_schedule.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>
</div>
</body>
</html>
