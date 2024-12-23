<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['password'] === $password) { // Compare plain text passwords
                echo "Login successful! Welcome, " . htmlspecialchars($username) . ".";
            } else {
                echo "Invalid password. Please try again.";
            }
        } else {
            echo "Invalid username. Please try again.";
        }

        $stmt->close();
    } else {
        echo "Error: Please fill out both username and password fields.";
    }
} else {
    echo "Invalid request method. Please submit the form.";
}

$conn->close();
