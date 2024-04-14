<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require('connect.php');; // Include database connection

// Function to delete an image file from the server
function deleteImage($imagePath) {
    if (file_exists($imagePath)) {
        unlink($imagePath); // Delete the file
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_elements'])) {
    // Loop through selected element IDs and delete them
    foreach ($_POST['elements'] as $element_id) {
        // Fetch image path of the element
        $queryImagePath = "SELECT image_path FROM Elements WHERE element_id = :element_id";
        $statementImagePath = $db->prepare($queryImagePath);
        $statementImagePath->bindValue(':element_id', $element_id);
        $statementImagePath->execute();
        $result = $statementImagePath->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['image_path'])) {
            $imagePath = $result['image_path'];
            deleteImage($imagePath); // Delete the associated image file
        }

        // Delete the element from the database
        $queryDeleteElement = "DELETE FROM Elements WHERE element_id = :element_id";
        $statementDeleteElement = $db->prepare($queryDeleteElement);
        $statementDeleteElement->bindValue(':element_id', $element_id);
        $statementDeleteElement->execute();
    }
    header('Location: elements.php'); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all elements from database
$query = "SELECT * FROM Elements";
$statement = $db->query($query);
$elements = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Elements</title>
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
    <h1><a href="elements.php">Back to elements page</a></h1>
    <h2>Delete Elements</h2>
    <form action="delete_element.php" method="POST">
        <table>
            <tr>
                <th>Select</th>
                <th>Element ID</th>
                <th>Element Name</th>
                <th>Description</th>
                <th>Image Path</th>
            </tr>
            <?php foreach ($elements as $element): ?>
                <tr>
                    <td><input type="checkbox" name="elements[]" value="<?= $element['element_id'] ?>"></td>
                    <td><?= $element['element_id'] ?></td>
                    <td><?= $element['element_name'] ?></td>
                    <td><?= $element['description'] ?></td>
                    <td><?= $element['image_path'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="delete_elements" value="Delete Selected Elements">
    </form>
</body>

</html>
