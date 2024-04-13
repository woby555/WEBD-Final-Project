<?php
    session_start();
    require('connect.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['character_name']) && !empty($_POST['class_id']) && !empty($_POST['weapon_id']) && !empty($_POST['element_id']) && !empty($_POST['armor_id']) && !empty($_POST['level']) && !empty($_POST['content'])) {
    $character_name = filter_input(INPUT_POST, 'character_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_id = $_POST['class_id'];
    $weapon_id = $_POST['weapon_id'];
    $element_id = $_POST['element_id'];
    $armor_id = $_POST['armor_id'];
    $level = $_POST['level'];
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Insert the character into the Characters table
    $query = "INSERT INTO Characters (user_id, character_name, level, class_id, weapon_id, element_id) VALUES (:user_id, :character_name, :level, :class_id, :weapon_id, :element_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':character_name', $character_name);
    $statement->bindValue(':level', $level);
    $statement->bindValue(':class_id', $class_id);
    $statement->bindValue(':weapon_id', $weapon_id);
    $statement->bindValue(':element_id', $element_id);
    
    if ($statement->execute()) {
        // Get the character ID of the newly inserted character
        $character_id = $db->lastInsertId();

        // Insert the armor into the CharacterArmors table
        $query = "INSERT INTO CharacterArmors (character_id, armor_id) VALUES (:character_id, :armor_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':character_id', $character_id);
        $statement->bindValue(':armor_id', $armor_id);
        
        if ($statement->execute()) {
            // Get the user ID from the session
            $user_id = $_SESSION['user_id'];

            // Insert the post into the Posts table
            $query = "INSERT INTO Posts (character_id, user_id, content) VALUES (:character_id, :user_id, :content)";
            $statement = $db->prepare($query);
            $statement->bindValue(':character_id', $character_id);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':content', $content);
            
            if ($statement->execute()) {
                echo "Character and Post created successfully!";
            } else {
                echo "Error creating post.";
            }
        } else {
            echo "Error creating character.";
        }
    } else {
        echo "Error creating character.";
    }

    // Redirect to index.php after creating the character and post
    header("Location: index.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Create Character</title>
</head>
<body>
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>
    <nav class = "navbar">
        <ul class="container">
            <li><a href="index.php">Home</a></li>
            <li><a href="characters.php" class="button-primary-outline">Characters</a></li>
            <li><a href="elements.php" class="button-primary-outline">Elements</a></li>
            <li><a href="classes.php" class="button-primary-outline">Classes</a></li>
            <li><a href="skills.php" class="button-primary-outline">Skills</a></li>
            <li><a href="weapons.php" class="button-primary-outline">Weapons</a></li>
            <li><a href="armors.php" class="button-primary-outline">Armors</a></li>
            <?php    if(isset($_SESSION['username']) && $_SESSION['role'] === 'Administrator') {
            echo '<li><a href="admin_dashboard.php" class="button-primary-outline">Admin Dashboard</a></li>';
            echo '<br><li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
            } else if(isset($_SESSION['username'])) {
                echo '<br><li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
            } else {
                echo '<li><a href="login_page.php" class="button-primary-outline">Login</a></li>';
            }?>
        </ul>
    </nav>


    <main class="container py-1" id="create-character">
        <form action="create_char.php" method="POST">
            <h2>Create your character</h2>
            <div class="form-group">
                <label for="character_name">Character Name:</label>
                <input type="text" id="character_name" name="character_name" required>
            </div>
            <div class="form-group">
                <label for="class_id">Class:</label>
                <select id="class_id" name="class_id" required>
                    <option value="">Select Class</option>
                    <!-- Populate with classes from database -->
                    <?php
                    $stmt = $db->query("SELECT class_id, class_name FROM Classes");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['class_id']}'>{$row['class_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="weapon_id">Weapon:</label>
                <select id="weapon_id" name="weapon_id" required>
                    <option value="">Select Weapon</option>
                    <!-- Populate with weapons from database -->
                    <?php
                    $stmt = $db->query("SELECT weapon_id, weapon_name FROM Weapons");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['weapon_id']}'>{$row['weapon_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="element_id">Element:</label>
                <select id="element_id" name="element_id" required>
                    <option value="">Select Element</option>
                    <!-- Populate with elements from database -->
                    <?php
                    $stmt = $db->query("SELECT element_id, element_name FROM Elements");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['element_id']}'>{$row['element_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="armor_id">Armor:</label>
                <select id="armor_id" name="armor_id" required>
                    <option value="">Select Armor</option>
                    <!-- Populate with armors from database -->
                    <?php
                    $stmt = $db->query("SELECT armor_id, armor_name FROM Armors");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['armor_id']}'>{$row['armor_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="level">Level:</label>
                <input type="number" id="level" name="level" min="1" max="100" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="4" cols="50" required></textarea>
            </div>
            <button type="submit" class="button-primary">Create Character</button>
        </form>
    </main>


    <?php include('footer.php');?>
</body>
</html>
