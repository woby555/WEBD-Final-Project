<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header('Location: login.php'); // Redirect unauthorized users
    exit();
}

require('connect.php'); // Include database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_skills'])) {
    // Loop through selected skill IDs and delete them
    foreach ($_POST['skills'] as $skill_id) {
        // Delete the skill from the database
        $queryDeleteSkill = "DELETE FROM Skills WHERE skill_id = :skill_id";
        $statementDeleteSkill = $db->prepare($queryDeleteSkill);
        $statementDeleteSkill->bindValue(':skill_id', $skill_id);
        $statementDeleteSkill->execute();
    }
    header('Location: skills.php'); // Redirect to refresh the page after deletion
    exit();
}

// Fetch all skills from database
$query = "SELECT * FROM Skills";
$statement = $db->query($query);
$skills = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Skills</title>
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
    <h1><a href="skills.php">Back to Skills Page</a></h1>
    <h2>Delete Skills</h2>
    <form action="delete_skill.php" method="POST">
        <table>
            <tr>
                <th>Select</th>
                <th>Skill ID</th>
                <th>Skill Name</th>
                <th>Associated Class ID</th>
            </tr>
            <?php foreach ($skills as $skill) : ?>
                <tr>
                    <td><input type="checkbox" name="skills[]" value="<?= $skill['skill_id'] ?>"></td>
                    <td><?= $skill['skill_id'] ?></td>
                    <td><?= $skill['skill_name'] ?></td>
                    <td><?= $skill['class_id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" name="delete_skills" value="Delete Selected Skills">
    </form>
</body>

</html>