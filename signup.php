<?php
// Include database connection
include("db_conn.php");

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if both fields are filled
    if (empty($username) || empty($password)) {
        $message = "<p class='message'>Please fill in all fields.</p>";
    } else {
        // Check if the username already exists
        $check_username_query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($check_username_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username exists, display error message
            $message = "<p class='message'>Username '$username' already exists. Please choose a different username.</p>";
        } else {
            // Insert the new user with the plain password
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);

            // Execute the query
            if ($stmt->execute()) {
                $message = "<p class='success'>Signup successful! You can now <a href='login.php'>login</a>.</p>";
            } else {
                $message = "<p class='message'>Error: " . $stmt->error . "</p>";
            }
        }
    }
} else {
    $message = "<p</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <!-- Signup form -->
        <form action="signup.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Signup">
            
            <!-- Display message after form submission -->
            <?php if (isset($message)) echo $message; ?>
        </form>
        <!-- Link to Login Page -->
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
