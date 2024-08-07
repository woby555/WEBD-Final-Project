<?php
/*
    Jake Licmo
    login.php - Login for users.
*/
require_once 'connect.php';

session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve the hashed password and role from the database
    $stmt = $db->prepare("SELECT user_id, username, hashed_password, role FROM Users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    // Verify password
    if ($user && password_verify($password, $user['hashed_password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Set user role in session

        if ($user['role'] == 'Administrator') {
            require_once 'authenticate.php'; // Additional authenticate.php for enhanced verification
        }
        
        // Redirect to home page or do other login success logic
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['login_failure'] = true;
        // Redirect to login page with error message or do other login failure logic
        header("Location: login_page.php?login_error=1");
        exit();
    }
} else {
    // Redirect to login page if login form is not submitted
    header("Location: index.php");
    exit();
}
?>
