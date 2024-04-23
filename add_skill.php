<?php
session_start();

// Administrator Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require_once 'connect.php';

// Classes Fetch
$query = "SELECT class_id, class_name FROM Classes";
$statement = $db->query($query);
$classes = $statement->fetchAll(PDO::FETCH_ASSOC);

// Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    // Validate input
    $skill_name = filter_input(INPUT_POST, 'skill_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_id = $_POST['class_id'];

    // Insert new skill into the database
    $queryInsertSkill = "INSERT INTO Skills (skill_name, class_id) VALUES (:skill_name, :class_id)";
    $statementInsertSkill = $db->prepare($queryInsertSkill);
    $statementInsertSkill->bindValue(':skill_name', $skill_name);
    $statementInsertSkill->bindValue(':class_id', $class_id);

    if ($statementInsertSkill->execute()) {
        header('Location: skills.php'); 
        exit();
    } else {
        $error_message = "Failed to add skill. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Add Skill</title>
</head>

<body>
    <nav class="navbar">
        <ul class="container">
            <li><a href="index.php" class="button-primary-outline">Home</a></li>
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
    <div class="add-new-skill">
    <h1>Add New Skill</h1>
    <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>
    <form action="add_skill.php" method="POST">
        <label for="skill_name">Skill Name:</label>
        <input type="text" id="skill_name" name="skill_name" required>
        <br><br>
        <label for="class_id">Associated Class:</label>
        <select id="class_id" name="class_id" required>
            <option value="">Select Class</option>
            <?php foreach ($classes as $class) : ?>
                <option value="<?= $class['class_id'] ?>"><?= $class['class_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" name="add_skill" value="Add Skill">
    </form>
    <br>
    <a href="skills.php">Back to Skills Page</a>
    </div>
    <?php include("footer.php") ?>
</body>

</html>