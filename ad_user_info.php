<?php
include("connection.php");

class Staff {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getStaffList() {
        $query = "SELECT * FROM ad_staff";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $staffList = [];
            while ($row = $result->fetch_assoc()) {
                $staffList[] = $row;
            }
            return $staffList;
        } else {
            return [];
        }
    }

    public function addStaff($first_name, $middle_name, $last_name, $email, $department, $evaluator) {
        $first_name = $this->conn->real_escape_string($first_name);
        $middle_name = $this->conn->real_escape_string($middle_name);
        $last_name = $this->conn->real_escape_string($last_name);
        $email = $this->conn->real_escape_string($email);
        $department = $this->conn->real_escape_string($department);
        $evaluator = $this->conn->real_escape_string($evaluator);
    
        $query = "INSERT INTO ad_staff(first_name, middle_name, last_name, email, department, evaluator) 
                  VALUES ('$first_name', '$middle_name', '$last_name', '$email', '$department', '$evaluator')";
        $result = $this->conn->query($query);
    
        return $result;
    }

    public function getStaffDetails($staffId) {
        $staffId = $this->conn->real_escape_string($staffId);
        $query = "SELECT * FROM ad_staff WHERE id = $staffId";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function deleteStaff($staffId) {
        $staffId = $this->conn->real_escape_string($staffId);
        $query = "DELETE FROM ad_staff WHERE id = $staffId";
        $result = $this->conn->query($query);

        return $result;
    }
    public function editStaff($staffId, $newValues) {
        $staffId = $this->conn->real_escape_string($staffId);
    
        // Construct the SET part of the SQL query
        $setValues = [];
        foreach ($newValues as $key => $value) {
            $setValues[] = "$key = '$value'";
        }
        $setClause = implode(', ', $setValues);
    
        $query = "UPDATE ad_staff SET $setClause WHERE id = $staffId";
        $result = $this->conn->query($query);
    
        return $result;
    }
}

$staff = new Staff($conn);
// Check if the form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    // Form submitted for editing staff
    $editId = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';
    $editFirstName = isset($_POST['edit_first_name']) ? $_POST['edit_first_name'] : '';
    $editMiddleName = isset($_POST['edit_middle_name']) ? $_POST['edit_middle_name'] : '';
    $editLastName = isset($_POST['edit_last_name']) ? $_POST['edit_last_name'] : '';
    $editEmail = isset($_POST['edit_email']) ? $_POST['edit_email'] : '';
    $editDepartment = isset($_POST['edit_department']) ? $_POST['edit_department'] : '';
    $editEvaluator = isset($_POST['edit_evaluator']) ? $_POST['edit_evaluator'] : '';

    // Call the editStaff method
    $editResult = $staff->editStaff($editId, [
        'first_name' => $editFirstName,
        'middle_name' => $editMiddleName,
        'last_name' => $editLastName,
        'email' => $editEmail,
        'department' => $editDepartment,
        'evaluator' => $editEvaluator,
    ]);

    if ($editResult) {
        // Data edited successfully, redirect or show a success message
        header("Location: ad_staff.php?success=1");
        exit();
    } else {
        // Log the error for reference
        error_log("Error editing staff: " . $conn->error);
        // Display a user-friendly message
        $error_message = "Error editing staff. Please try again later.";
    }
}

// Check if the form is submitted for adding or deleting
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_staff'])) {
    // Form submitted for adding staff
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $middleName = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $evaluator = isset($_POST['evaluator']) ? $_POST['evaluator'] : '';

    // Call the addStaff method
    $result = $staff->addStaff($firstName, $middleName, $last_name, $email, $department, $evaluator);

    if ($result) {
        // Data added successfully, redirect or show a success message
        header("Location: ad_staff.php?success=1");
        exit();
    } else {
        // Log the error for reference
        error_log("Error adding staff: " . $conn->error);
        // Display a user-friendly message
        $error_message = "Error adding staff. Please try again later.";
    }
} elseif (isset($_POST['delete_id'])) {
    // Form submitted for deleting staff
    $deleteId = $_POST['delete_id'];

    $deleteResult = $staff->deleteStaff($deleteId);

    if ($deleteResult) {
        // Use JavaScript to show the delete success toast
        // Data added successfully, redirect or show a success message
        header("Location: ad_staff.php?success=1");
        exit();
    } else {
        // Log the error for reference
        error_log("Error deleting staff: " . $conn->error);
        // Display a user-friendly message
        $error_message = "Error deleting staff. Please try again later.";
    }
}

$staffList = $staff->getStaffList();
?>



<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include("Include/ad_sidebar.php");?>

    <title>Edu Staff Evaluation System</title>
    <link rel="stylesheet" href="Assets/css/eva_task.css">
</head>
<body>
        <div class="Container">
        <div class="header">
        <header>Staff List</header>

        <!-- Add New Staff Button -->
        <button class="btn btn-primary add-task-btn" data-toggle="modal" data-target="#addStaffModal">Add New Staff</button>

        <!-- Search Bar -->
        <input type="text" placeholder="Search..." class="form-control search-bar">


        <table class="table table-bordered">
        <thead>

        <tr>
        <th scope="col">#</th>
        <th scope="col">First Name</th>
        <th scope="col">Middle Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email</th>
        <th scope="col">Department</th>
        <th scope="col">Evaluator</th>
        <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($staffList)) : ?>
        <?php foreach ($staffList as $index => $staff) : ?>
        <tr>
        <th scope="row"><?= $index + 1 ?></th>
        <td><?= $staff['first_name'] ?? '' ?></td>
        <td><?= $staff['middle_name'] ?? '' ?></td>
        <td><?= $staff['last_name'] ?? '' ?></td>
        <td><?= $staff['email'] ?></td>
        <td><?= $staff['department'] ?></td>
        <td><?= $staff['evaluator'] ?></td>       
        
        <td>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actions
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewStaffModal<?= $index ?>">View Staff</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editStaffModal<?= $index ?>">Edit</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStaffModal<?= $index ?>">Delete</a>
                </div>
            </div>
        </td>
        </tr>

        <!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel<?= $index ?>" aria-hidden="true">
    <!-- Modal Content Goes Here -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel<?= $index ?>">Edit Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your edit staff modal content goes here -->
                <form id="editStaffForm<?= $index ?>" action="ad_staff.php" method="post">
                    <input type="hidden" name="edit_id" value="<?= $staff['id'] ?>">
                    <div class="form-group">
                        <label for="edit_first_name">First Name:</label>
                        <input type="text" class="form-control" name="edit_first_name" value="<?= $staff['first_name'] ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_middle_name">Middle Name:</label>
                        <input type="text" class="form-control" name="edit_middle_name" value="<?= $staff['middle_name'] ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_last_name">Last Name:</label>
                        <input type="text" class="form-control" name="edit_last_name" value="<?= $staff['last_name'] ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email:</label>
                        <input type="email" class="form-control" name="edit_email" value="<?= $staff['email'] ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_department">Department:</label>
                        <input type="text" class="form-control" name="edit_department" value="<?= $staff['department'] ?? '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_evaluator">Evaluator:</label>
                        <input type="text" class="form-control" name="edit_evaluator" value="<?= $staff['evaluator'] ?? '' ?>" required>
                    </div>
                    <!-- Add more fields as needed for editing -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="editStaffForm<?= $index ?>" name="save_changes">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


        <!-- Delete Staff Modal -->
        <div class="modal fade" id="deleteStaffModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="deleteStaffModalLabel<?= $index ?>" aria-hidden="true">
        <!-- Modal Content Goes Here -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStaffModalLabel<?= $index ?>">Delete Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete Staff #<?= $index + 1 ?>?
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="delete_id" value="<?= $staff['id'] ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
       <!-- View Staff Modal -->
<div class="modal fade" id="viewStaffModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="viewStaffModalLabel<?= $index ?>" aria-hidden="true">
    <!-- Modal Content Goes Here -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewStaffModalLabel<?= $index ?>">View Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display staff details here -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>First Name:</strong> <?= $staff['first_name'] ?? '' ?></p>
                            <p><strong>Middle Name:</strong> <?= $staff['middle_name'] ?? '' ?></p>
                            <p><strong>Last Name:</strong> <?= $staff['last_name'] ?? '' ?></p>
                            <p><strong>Email:</strong> <?= $staff['email'] ?? '' ?></p>                       
                            <p><strong>Department:</strong> <?= $staff['department'] ?? '' ?></p>
                            <p><strong>Evaluator:</strong> <?= $staff['evaluator'] ?? '' ?></p>
                            <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    </div>
    <?php endforeach; ?>
    </tbody>
    </table>
    <?php else : ?>
    <tr>
        <th colspan="6">No staff found</th>
    </tr>
    <?php endif; ?>
    <div id="noResultsMessage" style="display: none;">No results found</div>
    <!-- Add New Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your staff form content goes here -->
                <form id="addStaffForm" action="ad_staff.php" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-avatar">
                            <label for="avatar">Avatar:</label>
                            <input type="file" class="form-control-file" name="avatar">
                            <br>
                        </div>
                    </div>
                    <div class="form-row">                   
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="middle_name">Middle Name:</label>
                            <input type="text" class="form-control" name="middle_name" required>
                        </div>
                                      
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="department">Department:</label>
                            <input type="text" class="form-control" name="department" required>
                        </div>

                                
                        <div class="form-group col-md-6">
                            <label for="evaluator">Evaluator:</label>
                            <input type="text" class="form-control" name="evaluator" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>                     
                    

                    
                        <div class="form-group col-md-6">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>                       
                    </div>
                    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add_staff">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
                        
                </form>
                    
            </div>
        </div>
    </div>
</div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script>
        // Reset the form when the modal is closed
        $('#addStaffModal').on('hidden.bs.modal', function () {
            $('#addStaffForm')[0].reset();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#deleteSuccessToast, #editSuccessToast').toast({
                autohide: true,
                delay: 2000
            }).toast('show');
        });
    </script>
   <script>
    $(document).ready(function () {
        // Function to filter table rows based on the search input
        $(".search-bar").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            var rows = $("table tbody tr");
            
            rows.hide();
            
            rows.filter(function () {
                return $(this).text().toLowerCase().indexOf(value) > -1;
            }).show();
            
            // Show a message when no results are found
            var noResultsMessage = $("#noResultsMessage");
            if (rows.filter(":visible").length === 0) {
                noResultsMessage.show();
            } else {
                noResultsMessage.hide();
            }
        });
    });
</script>

</body>
</html>

<?php
//close the database
mysqli_close($conn);
?>
