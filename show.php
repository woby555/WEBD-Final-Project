<?php
require('connect.php');

// Redirect to index.php if id parameter is not provided
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// Sanitize the id parameter
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Query to retrieve character details
$query = "SELECT * FROM Characters WHERE character_id = :id";
$statement = $db->prepare($query);
$statement->bindParam(':id', $id);
$statement->execute();
$character = $statement->fetch(PDO::FETCH_ASSOC);

// If character with provided id doesn't exist, redirect to index.php
if (!$character) {
    header('Location: index.php');
    exit();
}

// Query to retrieve post associated with the character
$query = "SELECT * FROM Posts WHERE character_id = :id";
$statement = $db->prepare($query);
$statement->bindParam(':id', $id);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title><?php echo $character['character_name']; ?>'s Details</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <?php include('nav.php'); ?>

    <main class="container py-1">
        <h2><?php echo $character['character_name']; ?>'s Details</h2>
        <div>
            <p>Level: <?php echo $character['level']; ?></p>
            <p>Class: <?php echo $character['class_id']; ?></p>
            <p>Weapon: <?php echo $character['weapon_id']; ?></p>
            <p>Element: <?php echo $character['element_id']; ?></p>
            <p>Post Content: <?php echo $post ? $post['content'] : 'No post available.'; ?></p>
        </div>
    </main>

    <?php include('footer.php'); ?>
</body>

</html>