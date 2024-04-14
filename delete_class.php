<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require('connect.php'); // Include database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_classes'])) {
    // Loop through selected class IDs and delete them
    foreach ($_POST['classes'] as $class_id) {
        // Delete the class from the database
        $queryDeleteClass = "DELETE FROM Classes WHERE class_id = :class_id";
        $statementDeleteClass = $db->prepare($queryDeleteClass);
        $statementDeleteClass->bindValue(':class_id', $class_id);
        $statementDeleteClass->execute();
    }
    header('Location: classes.php'); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all classes from database
$query = "SELECT * FROM Classes";
$statement = $db->query($query);
$classes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Classes</title>
    <link rel="stylesheet" href="main.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<header class="header">
    <div class="text-center">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?>! Account status: <?php echo $_SESSION['role']; ?>, ID: <?php echo $_SESSION['user_id']; ?></p>
        <a href="index.php"> Home </a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<body>
    <h1><a href="classes.php">Back to classes page</a></h1>
    <h2>Delete Classes</h2>
    <form action="delete_class.php" method="POST">
        <table>
            <tr>
                <th>Select</th>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Description</th>
            </tr>
            <?php foreach ($classes as $class) : ?>
                <tr>
                    <td><input type="checkbox" name="classes[]" value="<?= $class['class_id'] ?>"></td>
                    <td><?= $class['class_id'] ?></td>
                    <td><?= $class['class_name'] ?></td>
                    <td><?= $class['description'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="delete_classes" value="Delete Selected Classes">
    </form>
</body>

</html>