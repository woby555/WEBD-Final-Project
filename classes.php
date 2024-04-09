<?php
    require_once 'connect.php';

    $stmt = $db->query("SELECT * FROM Classes");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elements</title>
</head>
<body>
    <?php include('nav.php');?>
    <h1>Available Classes</h1>
    <table>
        <thead>
            <tr>
                <th>Class:</th>
                <!--<th>Description</th>-->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $class): ?>
                <tr class = "element-table">
                    <td><?php echo $class['class_name']; ?></td>
                    <!--<td><?php echo $element['description']; ?></td>-->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Check if user is an administrator
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') {
        // Display CRUD operations for administrators
        echo '<h2>Administrator Actions</h2>';
        echo '<a href="add_class.php">Add New Class</a>';
        // Additional CRUD operations such as update and delete can be added here
    }
    ?>
    <?php include('footer.php');?>
</body>
</html>