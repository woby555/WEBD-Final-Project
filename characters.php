<?php
require_once 'connect.php';

$stmt = $db->query("SELECT
                        c.character_id,
                        u.username,
                        c.character_name,
                        c.level,
                        c.date_created, 
                        cls.class_name,
                        w.weapon_name,
                        e.element_name,
                        c.user_id
                    FROM
                        Characters c
                    JOIN
                        Users u ON c.user_id = u.user_id
                    JOIN
                        Classes cls ON c.class_id = cls.class_id
                    LEFT JOIN
                        Weapons w ON c.weapon_id = w.weapon_id
                    JOIN
                        Elements e ON c.element_id = e.element_id
                    ");
$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weapons</title>
</head>
<header class="header">
    <div class="text-center">
        <h1>My Blog</h1>
    </div>
</header>
<body>
    <?php include('nav.php');?>
    <h1>Current list of characters</h1>
    <table>
        <thead>
            <tr>
                <th>Character</th>
                <th>Level</th>
                <th>Class</th>
                <th>Weapon</th>
                <th>Element</th>
                <th>Created by:</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($characters as $character): ?>
                <tr class="element-table">
                    <td>
                        <a href="show.php?id=<?php echo $character['character_id']; ?>">
                            <?php echo $character['character_name']; ?>
                        </a>
                        <?php if(isset($_SESSION['user_id']) && isset($character['user_id']) && $_SESSION['user_id'] === $character['user_id']): ?>
                            <!-- Display Update and Delete links for the user's character -->
                            <span>
                                <a href="edit_char.php?id=<?php echo $character['character_id']; ?>">Update</a> | 
                                <a href="delete.php?id=<?php echo $character['character_id']; ?>">Delete</a>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $character['level']; ?></td>
                    <td><?php echo $character['class_name']; ?></td>
                    <td><?php echo $character['weapon_name'] ?? 'None'; ?></td>
                    <td><?php echo $character['element_name']; ?></td>
                    <td><?php echo $character['username']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Check if user is an administrator
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') {
        // Display CRUD operations for administrators
        echo '<h2>Administrator Actions</h2>';
        echo '<a href="create_char.php">Add New Character</a>';
        echo '<a href="delete_char.php">Delete New Character</a>';
        // Additional CRUD operations such as update and delete can be added here
    }
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'User') {
        // Display CRUD operations for administrators
        echo '<h2>User Actions</h2>';
        echo '<a href="create_char.php">Create a character!</a>';
        // Additional CRUD operations such as update and delete can be added here
    }
    ?>
    <?php include('footer.php');?>
</body>
</html>
