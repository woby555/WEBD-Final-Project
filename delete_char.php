<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require('connect.php'); // Include database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_characters'])) {
    // Loop through selected character IDs and delete them
    foreach ($_POST['characters'] as $character_id) {
        // Fetch image path of the character
        $queryImagePath = "SELECT image_path FROM Characters WHERE character_id = :character_id";
        $statementImagePath = $db->prepare($queryImagePath);
        $statementImagePath->bindValue(':character_id', $character_id);
        $statementImagePath->execute();
        $image_path = $statementImagePath->fetchColumn();

        // Delete associated posts
        $queryDeletePosts = "DELETE FROM Posts WHERE character_id = :character_id";
        $statementDeletePosts = $db->prepare($queryDeletePosts);
        $statementDeletePosts->bindValue(':character_id', $character_id);
        $statementDeletePosts->execute();

        // Delete the character from the database
        $queryDeleteCharacter = "DELETE FROM Characters WHERE character_id = :character_id";
        $statementDeleteCharacter = $db->prepare($queryDeleteCharacter);
        $statementDeleteCharacter->bindValue(':character_id', $character_id);
        $statementDeleteCharacter->execute();

        // Delete the associated image file
        if ($image_path) {
            $image_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . $image_path;
            if (file_exists($image_file)) {
                unlink($image_file); // Delete the image file
            }
        }
    }
    header('Location: characters.php'); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all characters from database
$query = "SELECT * FROM Characters";
$statement = $db->query($query);
$characters = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Characters</title>
    <link rel="stylesheet" href="main.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="text-center">
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['username']; ?>! Account status: <?php echo $_SESSION['role']; ?>, ID: <?php echo $_SESSION['user_id']; ?></p>
            <a href="index.php"> Home </a>
            <a href="logout.php">Logout</a>
        </div>
    </header>
    <h1><a href="characters.php">Back to Characters Page</a></h1>
    <h2>Delete Characters</h2>
    <form action="delete_char.php" method="POST">
        <table>
            <tr>
                <th>Select</th>
                <th>Character ID</th>
                <th>User ID</th>
                <th>Character Name</th>
                <th>Level</th>
                <th>Date Created</th>
                <th>Class ID</th>
                <th>Weapon ID</th>
                <th>Element ID</th>
            </tr>
            <?php foreach ($characters as $character): ?>
                <tr>
                    <td><input type="checkbox" name="characters[]" value="<?= $character['character_id'] ?>"></td>
                    <td><?= $character['character_id'] ?></td>
                    <td><?= $character['user_id'] ?></td>
                    <td><?= $character['character_name'] ?></td>
                    <td><?= $character['level'] ?></td>
                    <td><?= $character['date_created'] ?></td>
                    <td><?= $character['class_id'] ?></td>
                    <td><?= $character['weapon_id'] ?></td>
                    <td><?= $character['element_id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="delete_characters" value="Delete Selected Characters">
    </form>
</body>
</html>
