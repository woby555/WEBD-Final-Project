<?php
/*
    Jake Licmo
    register.php - Registration for new users.
*/
require_once 'connect.php';


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate passwords
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match. Please try again.";
        header("Location: register.php");
        exit();
    }

    // Hash and salt the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to insert user into database
    $stmt = $db->prepare("INSERT INTO Users (username, email, hashed_password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "Registration successful. You can now login.";
        echo "<script>alert('Registered!'); window.location.href = 'index.php';</script>";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['register_error'] = "An error occurred while registering. Please try again later.";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Register</title>
</head>

<body>
    <header class="header">
    <div class="text-center">
            <img class="logo" src="images/logos.png">
        </div>
    </header>

    <main>
        <?php include('nav.php'); ?>
        <div class="register-form">
            <h2>Register</h2>
            <?php
            if (isset($_SESSION['register_error'])) {
                echo "<p class='error'>" . $_SESSION['register_error'] . "</p>";
                unset($_SESSION['register_error']);
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Register</button>
            </form>
        </div>

        <?php include('footer.php'); ?>
    </main>
</body>

</html>