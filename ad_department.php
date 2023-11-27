<?php   
    include("connection.php");
    class Department {
        private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getDepartments() {
        $query = "SELECT * FROM eva_department";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $departments = [];
            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }
            return $departments;
        } else {
            return [];
        }
    }

    public function addDepartment($name, $description) {
        $name = $this->conn->real_escape_string($name);
        $description = $this->conn->real_escape_string($description);

        $query = "INSERT INTO eva_department(name, description) VALUES ('$name', '$description')";
        $result = $this->conn->query($query);

        return $result;
    }

    public function deleteDepartment($department_id) {
        $department_id = $this->conn->real_escape_string($department_id);

        $query = "DELETE FROM eva_department WHERE id = '$department_id'";
        $result = $this->conn->query($query);
        
        if (!$result) {
            // Log the error for reference
            error_log("Error deleting department: " . $this->conn->error);
        }
    
        return $result;
    }
}

// Create an instance of the Department class
$department = new Department($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_department'])) {
        // Form submitted for adding department
        $name = $_POST['name'];
        $description = $_POST['description'];

        // Call the addDepartment method
        $result = $department->addDepartment( $name, $description);

        if ($result) {
            // Data added successfully, redirect or show a success message
            header("Location: ad_department.php?success=1");
            exit();
        } else {
            // Log the error for reference
            error_log("Error adding department: " . $conn->error);
            // Display a user-friendly message
            $error_message = "Error adding department. Please try again later.";
        }
    } elseif (isset($_POST['delete_id'])) {
        // Form submitted for deleting department
        $delete_id = $_POST['delete_id'];

        $deleteResult = $department->deleteDepartment($delete_id);

        if ($deleteResult) {
            // Use JavaScript to show the delete success toast
           // Data added successfully, redirect or show a success message
           header("Location: ad_department.php?success=1");
           exit();
       } else {
           // Log the error for reference
           error_log("Error adding department: " . $conn->error);
           // Display a user-friendly message
           $error_message = "Error adding department. Please try again later.";
       }
    }
}


// Fetch departments
$departments = $department->getDepartments();

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
        <header>Department List</header>
            <!-- Add New Button -->
            <button class="btn btn-primary custom-button" data-toggle="modal" data-target="#addDepartmentModal">Add New</button>
           <!-- Search Bar -->
            <input type="text" class="custom-input form-search" placeholder="Search..." aria-label="Search">

            <div class="toast" id="deleteSuccessToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header">
                    <strong class="mr-auto">Success!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="toast-body">
                   department deleted successfully.
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Department</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($departments)) : ?>
                <?php foreach ($departments as $index => $department) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $department['name'] ?></td>
                        <td><?= $department['description'] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editDepartmentModal<?= $index ?>">Edit</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteDepartmentModal<?= $index ?>">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Department Modal -->
                    <div class="modal fade" id="editDepartmentModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel<?= $index ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDepartmentModalLabel<?= $index ?>">Edit Department</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add content to edit department details here -->
                                    Manage Department #<?= $index + 1 ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Department Modal -->
                    <div class="modal fade" id="deleteDepartmentModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="deleteDepartmentModalLabel<?= $index ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteDepartmentModalLabel<?= $index ?>">Delete Department</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete Department #<?= $index + 1 ?>?
                                </div>
                                <div class="modal-footer">
                                    <form method="post" action="ad_department.php">
                                        <input type="hidden" name="delete_id" value="<?= $department['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <tr>
            <td colspan="3">No departments found.</td>
        </tr>
    <?php endif; ?>

    <!-- Add Department Modal -->
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Add New Department</h5>
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_department'])) : ?>
                                    <?php if (isset($result) && $result) : ?>
                                        <!-- Show success toast -->
                                        <script>
                                            $(document).ready(function(){
                                                $('#successToast').toast('show');
                                            });
                                        </script>
                                    <?php elseif (isset($error_message)) : ?>
                                        <!-- Show error message -->
                                        <div class="alert alert-danger" role="alert">
                                            <?= $error_message ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your department form content goes here -->
                    <form action="ad_department.php" method="post">
                        <label for="department_name">Department:</label>
                        <input type="text" name="name" required>
                        <br><br>
                        
                        <label for="department_description">Description:</label>
                        <input type="text" name="description" required>
                        <br><br>
                        
                        <button type="submit" class="btn btn-primary" name="add_department">Add Department</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    $(document).ready(function(){
        $('#deleteSuccessToast').toast({
            autohide: true,
            delay: 2000
        }).toast('show');
    });
    $(document).ready(function(){
        $('#successToast').toast({
            autohide: true,
            delay: 2000
        }).toast('show');
    });
   
</script>
</body>
</html>

<?php
// Close the database
mysqli_close($conn);
?>
