<?php
// Include your database connection file
include("connection.php");

// Function to authenticate user against database
function authenticateUser($conn, $email, $password, $role) {
    // Replace this with your actual authentication logic
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $role = $conn->real_escape_string($role);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = '$role'";
    $result = $conn->query($query);

    return ($result->num_rows > 0);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Authenticate the user
    if (authenticateUser($conn, $email, $password, $role)) {
        // Redirect to the respective homepage based on the selected role
        if ($role === 'admin') {
            header('Location: admin.php');
            exit();
        } elseif ($role === 'evaluator') {
            header('Location: eva_homepage.php');
            exit();
        }
    } else {
        $loginError = 'Invalid email, password, or role.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Edu Staff Evaluation System</title>
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role"> Role:</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="evaluator">Evaluator</option>
        </select>

        <?php if (isset($loginError)): ?>
            <p style="color: red;"><?php echo $loginError; ?></p>
        <?php endif; ?>

        <button type="submit">Login</button>
    </form>
</body>
</html>
