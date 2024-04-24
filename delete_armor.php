<?php
/*
    Jake Licmo
    delete_armor.php - Shows a table of armors to select and delete from (Administrator access.).
*/
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require_once 'connect.php'; // Include database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_armors'])) {
    // Loop through selected armor IDs and delete them
    foreach ($_POST['armors'] as $armor_id) {
        // Delete the armor from the database
        $queryDeleteArmor = "DELETE FROM Armors WHERE armor_id = :armor_id";
        $statementDeleteArmor = $db->prepare($queryDeleteArmor);
        $statementDeleteArmor->bindValue(':armor_id', $armor_id);
        $statementDeleteArmor->execute();
    }
    header('Location: armors.php'); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all armors with armor type names from database
$query = "SELECT a.armor_id, a.armor_name, at.armor_type_name 
          FROM Armors a 
          INNER JOIN ArmorTypes at ON a.armor_type_id = at.armor_type_id";
$statement = $db->query($query);
$armors = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Armors</title>
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
    <h1><a href="armors.php">Back to Armors Page</a></h1>
    <h2>Delete Armors</h2>
    <form action="delete_armor.php" method="POST">
        <table>
            <tr>
                <th>Select</th>
                <th>Armor ID</th>
                <th>Armor Name</th>
                <th>Armor Type</th>
            </tr>
            <?php foreach ($armors as $armor) : ?>
                <tr>
                    <td><input type="checkbox" name="armors[]" value="<?= $armor['armor_id'] ?>"></td>
                    <td><?= $armor['armor_id'] ?></td>
                    <td><?= $armor['armor_name'] ?></td>
                    <td><?= $armor['armor_type_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="delete_armors" value="Delete Selected Armors">
    </form>
</body>

</html>