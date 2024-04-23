<?php
session_start();

// Administrator Check
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: index.php");
    exit();
}

require('connect.php');

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['weapon_name'])) {
    $weapon_name = filter_input(INPUT_POST, 'weapon_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Insert the weapon into the Weapons table
    $query = "INSERT INTO Weapons (weapon_name) VALUES (:weapon_name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':weapon_name', $weapon_name);

    if ($statement->execute()) {
        echo "Weapon created successfully!";
        header("Location: weapons.php");
    } else {
        echo "Error creating weapon.";
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
    <title>Add Weapon</title>
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
    <div class="add-new-weapon">
        <h2>Add New Weapon</h2>
        <form action="add_weapon.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="weapon_name">Weapon Name:</label>
                <input type="text" id="weapon_name" name="weapon_name" required>
            </div>
            <button type="submit">Add Weapon</button>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>