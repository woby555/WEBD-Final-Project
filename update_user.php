<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: index.php"); // Redirect to login page if not logged in as an administrator
    exit();
}

require_once 'connect.php';

// Check if user_id is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php"); // Redirect if user_id is not provided
    exit();
}

// Fetch user details based on user_id
$user_id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM Users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = $_POST['role']; 

    // Hash and salt the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE Users SET username = :username, email = :email, hashed_password = :password, role = :role WHERE user_id = :user_id");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':user_id', $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['update_success'] = "User details successfully updated.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['update_error'] = "An error occurred while updating user details. Please try again later.";
        // Debugging: Print error info
        echo "Error: " . $stmt->errorInfo()[2];
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
    <title>Update User</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <h1>Update User</h1>
            <p>Welcome, <?php echo $_SESSION['username']; ?>! Account status: <?php echo $_SESSION['role']; ?>, ID: <?php echo $_SESSION['user_id']; ?></p>
            <a href="index.php"> Home </a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main>
        <section>
            <h2>Update User Details</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $user_id; ?>" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role">
                        <option value="User" <?php echo ($user['role'] === 'User') ? 'selected' : ''; ?>>User</option>
                        <option value="Administrator" <?php echo ($user['role'] === 'Administrator') ? 'selected' : ''; ?>>Administrator</option>
                    </select>
                </div>
                <button type="submit">Update</button>
            </form>
        </section>
    </main>
</body>

</html>
