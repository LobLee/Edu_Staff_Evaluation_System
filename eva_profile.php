
<?php
// Include the connection file and any necessary functions
include("connection.php");

// Fetch user profile information from the database
$userProfileInfo = getUserProfileInfo();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user profile information in the database
    $email = $_POST['email'];
    $dateOfBirth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $maritalStatus = $_POST['marital_status'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $middleName = $_POST['middle_name'];
    $password = $_POST['password'];

    // Perform any necessary validation on the input data

    // Hash the password before storing it (assuming you're using PHP password_hash function)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's information in the database
    $updateQuery = "UPDATE profile SET 
                    first_name = '$firstName',
                    last_name = '$lastName',
                    middle_name = '$middleName',
                    email = '$email',
                    date_of_birth = '$dateOfBirth',
                    gender = '$gender',
                    marital_status = '$maritalStatus',
                    password = '$hashedPassword'
                    WHERE id = " . $userProfileInfo['id'];

    $updateResult = mysqli_query($conn, $updateQuery);

    if (!$updateResult) {
        die("Update failed: " . mysqli_error($conn));
    }

    // Refresh the user profile information after updating
    $userProfileInfo = getUserProfileInfo();
}

// Function to get user profile information
function getUserProfileInfo() {
    global $conn;

    // Assume you have a user ID stored in a session or obtained from somewhere
    $userId = 1; // Replace with your actual user ID retrieval logic

    // Fetch user profile information from the database
    $selectQuery = "SELECT * FROM profile WHERE id = $userId";
    $result = mysqli_query($conn, $selectQuery);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if a row is returned
    if ($row = mysqli_fetch_assoc($result)) {
        // Return the user profile information
        return $row;
    } else {
        // Handle the case where no user with the given ID is found
        die("User not found with ID: $userId");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include("Include/eva_sidebar.php");?>

    <title>Edu Staff Evaluation System</title>
    <link rel="stylesheet" href="Assets/css/profile.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Profile</h1>

            <!-- Display user profile information -->
                <div>
                    <img src="images/user.jpg" alt="Profile Picture" class="rounded-circle" width="120">
                </div>
            <h2>Profile Information</h2>
            <p>First Name: <?php echo $userProfileInfo['first_name']; ?></p>
            <p>Last Name: <?php echo $userProfileInfo['last_name']; ?></p>
            <p>Middle Name: <?php echo $userProfileInfo['middle_name']; ?></p>
            <p>Email: <?php echo $userProfileInfo['email']; ?></p>
            <p>Date of Birth: <?php echo $userProfileInfo['date_of_birth']; ?></p>
            <p>Gender: <?php echo $userProfileInfo['gender']; ?></p>
            <p>Marital Status: <?php echo $userProfileInfo['marital_status']; ?></p>
            
            <!-- Button to open modal -->
            <button id="openModal" class="btn btn-primary">Edit Profile</button>

      
<!-- The Modal -->
<div id="profileModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing profile -->
                <form method="post" action="ad_profile.php" id="profileForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Left column -->
                            <label for="first_name">First Name:</label>
                            <input type="text" name="first_name" value="<?php echo $userProfileInfo['first_name']; ?>" class="form-control" required>

                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" value="<?php echo $userProfileInfo['last_name']; ?>" class="form-control" required>

                            <label for="middle_name">Middle Name:</label>
                            <input type="text" name="middle_name" value="<?php echo $userProfileInfo['middle_name']; ?>" class="form-control" required>

                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?php echo $userProfileInfo['email']; ?>" class="form-control" required>

                            <!-- ... (other fields for the left column) ... -->
                        </div>
                        <div class="col-md-6">
                            <!-- Right column -->
                            <label for="date_of_birth">Date of Birth:</label>
                            <input type="date" name="date_of_birth" value="<?php echo $userProfileInfo['date_of_birth']; ?>" class="form-control" required>

                            <label for="gender">Gender:</label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" <?php echo ($userProfileInfo['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($userProfileInfo['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                            </select>

                            <label for="marital_status">Marital Status:</label>
                            <select name="marital_status" class="form-control" required>
                                <option value="Single" <?php echo ($userProfileInfo['marital_status'] === 'Single') ? 'selected' : ''; ?>>Single</option>
                                <option value="Married" <?php echo ($userProfileInfo['marital_status'] === 'Married') ? 'selected' : ''; ?>>Married</option>
                                <!-- Add other options as needed -->
                            </select>

                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>

                            <!-- New input field for password confirmation -->
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" name="confirm_password" class="form-control" required>

                            <!-- ... (other fields for the right column) ... -->
                        </div>
                    </div>

                    <!-- Profile picture upload -->
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture" accept="image/*" class="form-control-file">
                    

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        // JavaScript to handle modal functionality
        var openModalButton = document.getElementById('openModal');
        var modal = document.getElementById('profileModal');
        var closeModalButton = document.querySelector('#profileModal .close');

        openModalButton.addEventListener('click', function () {
            modal.style.display = 'block';
        });

        closeModalButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Close the modal if the user clicks outside of it
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

</body>
</html>
<?php
//close the database
mysqli_close($conn);
?>

