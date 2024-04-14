<?php
require_once 'connect.php';

$stmt = $db->query("SELECT Armors.armor_name, ArmorTypes.armor_type_name
                        FROM Armors
                        INNER JOIN ArmorTypes ON Armors.armor_type_id = ArmorTypes.armor_type_id
                        ORDER BY Armors.armor_id");
$armors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Armors</title>
</head>
<header class="header">
    <div class="text-center">
        <h1>My Blog</h1>
    </div>
</header>

<body>
    <?php include('nav.php'); ?>
    <h1>Available Armors</h1>
    <table>
        <thead>
            <tr>
                <th>Armor Pieces:</th>
                <th>Type:</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($armors as $armor) : ?>
                <tr class="element-table">
                    <td><?php echo $armor['armor_name']; ?></td>
                    <td><?php echo $armor['armor_type_name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Check if user is an administrator
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') {
        // Display CRUD operations for administrators
        echo '<h2>Administrator Actions</h2>';
        echo '<a href="add_armor.php">Add New Armor</a>';
        echo '<a href="delete_armor.php">Delete Armor</a>';
        // Additional CRUD operations such as update and delete can be added here
    }
    ?>
    <?php include('footer.php'); ?>
</body>

</html>