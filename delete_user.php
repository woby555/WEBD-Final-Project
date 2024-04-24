<?php
/*
    Jake Licmo
    delete_user.php - Shown when choosing to delete a selected user from admin_dashboard.php(Administrator access.).
*/
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: index.php"); // Redirect to login page if not logged in as an administrator
    exit();
}

require_once 'connect.php';

// Check if user_id is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
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
    // Prepare and execute the SQL statement to delete user from the database
    $stmt = $db->prepare("DELETE FROM Users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "User successfully deleted.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['delete_error'] = "An error occurred while deleting user. Please try again later.";
        header("Location: admin_dashboard.php");
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
    <title>Delete User</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <h1>Delete User</h1>
            <p>Welcome, <?php echo $_SESSION['username']; ?>! Account status: <?php echo $_SESSION['role']; ?>, ID: <?php echo $_SESSION['user_id']; ?></p>
            <a href="index.php"> Home </a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main>
        <section>
            <h2>Delete User</h2>
            <p>Are you sure you want to delete the user "<?php echo $user['username']; ?>"?</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $user_id; ?>" method="post">
                <button type="submit">Confirm Delete</button>
            </form>
        </section>
    </main>
</body>

</html>
