<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: index.php"); // Redirect to login page if not logged in as an administrator
    exit();
}

require('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['class_name']) && !empty($_POST['description'])) {
    $class_name = filter_input(INPUT_POST, 'class_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Insert the element into the Elements table
    $query = "INSERT INTO CLASSES (class_name, description) VALUES (:class_name, :description)";
    $statement = $db->prepare($query);
    $statement->bindValue(':class_name', $class_name);
    $statement->bindValue(':description', $description);

    if ($statement->execute()) {
        echo "Class created successfully!";
        header("Location: classes.php");
    } else {
        echo "Error creating class.";
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
    <title>Add Class</title>
</head>

<body>
    <nav class="navbar">
        <ul class="container">
            <li><a href="index.php" class="button-primary-outline">Home</a></li>
            <li><a href="characters.php" class="button-primary-outline">Characters</a></li>
            <li><a href="elements.php" class="button-primary-outline">Elements</a></li>
            <li><a href="classes.php" class="button-primary-outline">Classes</a></li>
            <li><a href="skills.php" class="button-primary-outline">Skills</a></li>
            <li><a href="weapons.php" class="button-primary-outline">Weapons</a></li>
            <li><a href="armors.php" class="button-primary-outline">Armors</a></li>
            <?php
            if (isset($_SESSION['username']) && $_SESSION['role'] === 'Administrator') {
                echo '<li><a href="admin_dashboard.php" class="button-primary-outline">Admin Dashboard</a></li>';
                echo '<br><li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
            } else if (isset($_SESSION['username'])) {
                echo '<br><li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
            } else {
                echo '<li><a href="login_page.php" class="button-primary-outline">Login</a></li>';
            }
            ?>
        </ul>
    </nav>
    <div class="add-new-class">
        <h2>Add New Class</h2>
        <form action="add_class.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="class_name">Class Name:</label>
                <input type="text" id="class_name" name="class_name" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            </div>
            <button type="submit">Add Class</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>