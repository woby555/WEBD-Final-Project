<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require_once 'connect.php'; // Include database connection

// Fetch all armor types from the database
$query = "SELECT * FROM ArmorTypes";
$statement = $db->query($query);
$armor_types = $statement->fetchAll(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_armor'])) {
    // Validate input
    $armor_type_id = $_POST['armor_type_id'];
    $armor_name = trim($_POST['armor_name']);

    // Insert new armor into the database
    $queryInsertArmor = "INSERT INTO Armors (armor_type_id, armor_name) VALUES (:armor_type_id, :armor_name)";
    $statementInsertArmor = $db->prepare($queryInsertArmor);
    $statementInsertArmor->bindValue(':armor_type_id', $armor_type_id);
    $statementInsertArmor->bindValue(':armor_name', $armor_name);

    if ($statementInsertArmor->execute()) {
        header('Location: armors.php'); // Redirect after successful insertion
        exit();
    } else {
        $error_message = "Failed to add armor. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Armor</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <nav class="navbar">
        <ul class="container">
            <li><a href="index.php">Home</a></li>
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
    <h2>Add New Armor</h2>
    <form action="add_armor.php" method="POST">
        <div>
            <label for="armor_type_id">Armor Type:</label>
            <select name="armor_type_id" id="armor_type_id">
                <?php foreach ($armor_types as $armor_type) : ?>
                    <option value="<?= $armor_type['armor_type_id'] ?>"><?= $armor_type['armor_type_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="armor_name">Armor Name:</label>
            <input type="text" id="armor_name" name="armor_name" required>
        </div>
        <button type="submit" name="add_armor">Add Armor</button>
    </form>
    <?php include('footer.php'); ?>
</body>

</html>