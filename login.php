<?php
session_start(); // Start the session to store login status

// Include the database connection file
include('db_conn.php');

$message = ""; // Variable to store success or error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the user exists and the password is correct
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $user['password'] == $password) {
        // If login is successful, start the session and display a success message
        $_SESSION['username'] = $username;  // Store username in session
        $message = "<p class='success'>Successfully logged in! Welcome, " . htmlspecialchars($username) . ".</p>";

        // Optionally, you can redirect the user to a dashboard or home page
        // header("Location: dashboard.php");
        // exit();
    } else {
        // If credentials are incorrect, display an error message
        $message = "<p class='error'>Invalid username or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        
        <!-- Display success or error message inside the form container -->
        <div class="message-container">
            <?php if (!empty($message)) { echo $message; } ?>
        </div>

        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Login">
        </form>

        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
    </div>
</body>
</html>
