<?php
session_start();

// Administrator Check
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: index.php"); 
    exit();
}

require('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['element_name']) && !empty($_POST['description'])) {
    $element_name = filter_input(INPUT_POST, 'element_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Check if image file is selected
    if (!empty($_FILES['image']['name'])) {
        // Upload image file
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    } else {
        $image_path = null;
    }

    // Insert the element into the Elements table
    $query = "INSERT INTO Elements (element_name, description, image_path) VALUES (:element_name, :description, :image_path)";
    $statement = $db->prepare($query);
    $statement->bindValue(':element_name', $element_name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':image_path', $image_path);

    if ($statement->execute()) {
        echo "Element created successfully!";
        header("Location: elements.php");
    } else {
        echo "Error creating element.";
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
    <title>Add Element</title>
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
    <div class="add-new-element">
        <h2>Add New Element</h2>
        <form action="add_element.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="element_name">Element Name:</label>
                <input type="text" id="element_name" name="element_name" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            </div>
            <div>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image">
            </div>
            <button type="submit">Add Element</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>