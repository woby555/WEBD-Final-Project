<?php
    require_once 'connect.php';

    $stmt = $db->query("SELECT * FROM Elements");
    $elements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elements</title>
</head>
<header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
</header>
<body>
    <?php include('nav.php');?>
    <h1>Available Elements</h1>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($elements as $element): ?>
                <tr class = "element-table">
                    <td><img src="<?php echo $element['image_path']; ?>" class="element-image" alt="<?php echo $element['element_name']; ?> image"></td>
                    <td><?php echo $element['element_name']; ?></td>
                    <td><?php echo $element['description']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Check if user is an administrator
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') {
        // Display CRUD operations for administrators
        echo '<h2>Administrator Actions</h2>';
        echo '<a href="add_element.php">Add New Element</a>';
        // Additional CRUD operations such as update and delete can be added here
        echo '<a href="delete_element.php"> Delete Element </a>';
    }
    ?>
    <?php include('footer.php');?>
</body>
</html>
