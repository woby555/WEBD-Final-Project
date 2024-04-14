<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require('connect.php'); // Include database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_weapons'])) {
    // Loop through selected weapon IDs and delete them
    foreach ($_POST['weapons'] as $weapon_id) {
        // Delete the weapon from the database
        $queryDeleteWeapon = "DELETE FROM Weapons WHERE weapon_id = :weapon_id";
        $statementDeleteWeapon = $db->prepare($queryDeleteWeapon);
        $statementDeleteWeapon->bindValue(':weapon_id', $weapon_id);
        $statementDeleteWeapon->execute();
    }
    header('Location: weapons.php'); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all weapons from database
$query = "SELECT * FROM Weapons";
$statement = $db->query($query);
$weapons = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Weapons</title>
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
    <h1><a href="weapons.php">Back to Weapons Page</a></h1>
    <h2>Delete Weapons</h2>
    <form action="delete_weapon.php" method="POST">
        <table>
            <tr>
                <th>Select</th>
                <th>Weapon ID</th>
                <th>Weapon Name</th>
            </tr>
            <?php foreach ($weapons as $weapon) : ?>
                <tr>
                    <td><input type="checkbox" name="weapons[]" value="<?= $weapon['weapon_id'] ?>"></td>
                    <td><?= $weapon['weapon_id'] ?></td>
                    <td><?= $weapon['weapon_name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="delete_weapons" value="Delete Selected Weapons">
    </form>
</body>

</html>