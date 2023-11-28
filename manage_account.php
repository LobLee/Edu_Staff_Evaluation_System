<?php
include("connection.php");
class Users {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserList() {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $userList = [];
            while ($row = $result->fetch_assoc()) {
                $userList[] = $row;
            }
            return $userList;
        } else {
            return [];
        }
    }

    public function editUser($userId, $newValues) {
        $userId = $this->conn->real_escape_string($userId);
    
        // Construct the SET part of the SQL query
        $setValues = [];
        foreach ($newValues as $key => $value) {
            $setValues[] = "$key = '" . $this->conn->real_escape_string($value) . "'";
        }
        $setClause = implode(', ', $setValues);
    
        $query = "UPDATE users SET $setClause WHERE id = $userId";
        $result = $this->conn->query($query);
    
        return $result;
    }
}

$user = new Users($conn);

// Check if the form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    // Form submitted for editing staff
    $editId = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';
    $editFirstName = isset($_POST['edit_first_name']) ? $_POST['edit_first_name'] : '';
    $editMiddleName = isset($_POST['edit_middle_name']) ? $_POST['edit_middle_name'] : '';
    $editLastName = isset($_POST['edit_last_name']) ? $_POST['edit_last_name'] : '';
    $editEmail = isset($_POST['edit_email']) ? $_POST['edit_email'] : '';
    $editPassword = isset($_POST['edit_password']) ? $_POST['edit_password'] : '';
    $editAvatar = isset($_FILES['edit_avatar']) ? $_FILES['edit_avatar'] : '';

    // Check if a new avatar file is uploaded
    if ($editAvatar['error'] == UPLOAD_ERR_OK) {
        $targetDir = "Assets/images/";
        $targetFile = $targetDir . basename($editAvatar["name"]);
        move_uploaded_file($editAvatar["tmp_name"], $targetFile);
    } else {
        // Handle the case when no new avatar is uploaded
        $targetFile = ''; // Set a default value or handle as needed
    }

    // Call the editUser method
    $editResult = $user->editUser($editId, [
        'first_name' => $editFirstName,
        'middle_name' => $editMiddleName,
        'last_name' => $editLastName,
        'email' => $editEmail,
        'password' => $editPassword,
        'avatar' => $targetFile,
    ]);

    if ($editResult) {
        // Data edited successfully, redirect or show a success message
        header("Location: manage_account.php");
        exit();
    } else {
        // Log the error for reference
        error_log("Error editing user: " . $conn->error);
        // Display a user-friendly message
        $error_message = "Error editing user. Please try again later.";
    }
}

$userList = $user->getUserList();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edustaff Evaluate System</title>
    <?php include("Include/ad_sidebar.php");?>
    <link rel="stylesheet" href="Assets/css/new.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Nosifer&family=Playfair+Display&display=swap" rel="stylesheet">
</head>
<body>
   
            

        <?php if (!empty($userList)) : ?>
    <?php foreach ($userList as $index => $user) : ?>
        <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel<?= $user['id'] ?>">Manage Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form id="editUserForm<?= $user['id'] ?>" action="manage_account.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="edit_id" value="<?= $user['id'] ?>">

                            <div class="row">
                                <!-- First Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_first_name">First Name:</label>
                                        <input type="text" class="form-control" name="edit_first_name" value="<?= $user['first_name'] ?? '' ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_middle_name">Middle Name:</label>
                                        <input type="text" class="form-control" name="edit_middle_name" value="<?= $user['middle_name'] ?? '' ?>" required>
                                    </div>

                                    <!-- Add other form fields for the first column as needed -->
                                </div>

                                <!-- Second Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_last_name">Last Name:</label>
                                        <input type="text" class="form-control" name="edit_last_name" value="<?= $user['last_name'] ?? '' ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_email">Email:</label>
                                        <input type="email" class="form-control" name="edit_email" value="<?= $user['email'] ?? '' ?>" required>
                                    </div>
                                   <!-- Add other form fields for the second column as needed -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="edit_password">Password:</label>
                                <input type="password" class="form-control" name="edit_password" value="<?= $user['password'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label for="edit_avatar">Avatar:</label>
                                <input type="file" class="form-control-file" name="edit_avatar" accept="image/*" id="editAvatarInput">
                                <img id="editAvatarPreview" src="Assets/images/user.jpg" class="img-thumbnail" alt="Default Avatar">
                            </div>

                            <!-- Add a submit button inside the form -->
                            <button type="submit" class="btn btn-primary" name="save_changes">Save Changes</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>



        <!-- Your table content remains unchanged -->

    </div>

    <!-- Bootstrap JS and Ionicons -->
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Update the image preview when a file is selected
        $("#editAvatarInput").change(function () {
            readURL(this);
        });

        // Function to read and display the selected image
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#editAvatarPreview").attr("src", e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
    <script>
        // Assume you have a variable called userFirstName with the user's first name
        var userFirstName = "Admin"; // Replace this with the actual first name

        // Update the title dynamically
        document.getElementById("profileTitle").innerText = "" + userFirstName;
    </script>
</body>
</html>
        