<?php session_start();
require('connect.php');

// Check if character ID is provided
if (!isset($_GET['id'])) {
    // Redirect if character ID is not provided
    header('Location: characters.php');
    exit();
}

$character_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['character_name']) && !empty($_POST['class_id']) && !empty($_POST['weapon_id']) && !empty($_POST['element_id']) && !empty($_POST['level']) && !empty($_POST['content'])) {
    $character_name = filter_input(INPUT_POST, 'character_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_id = $_POST['class_id'];
    $weapon_id = $_POST['weapon_id'];
    $element_id = $_POST['element_id'];
    $level = $_POST['level'];
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $armor_id = $_POST['armor_id'];
    $armor_id_2 = $_POST['armor_id_2'];
    $armor_id_3 = $_POST['armor_id_3'];
    $armor_id_4 = $_POST['armor_id_4'];

    // Update the character in the Characters table
    $query = "UPDATE Characters 
              SET character_name = :character_name, 
                  level = :level, 
                  class_id = :class_id, 
                  weapon_id = :weapon_id, 
                  element_id = :element_id 
              WHERE character_id = :character_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':character_name', $character_name);
    $statement->bindValue(':level', $level);
    $statement->bindValue(':class_id', $class_id);
    $statement->bindValue(':weapon_id', $weapon_id);
    $statement->bindValue(':element_id', $element_id);
    $statement->bindValue(':character_id', $character_id);

    if ($statement->execute()) {
        // Update or insert armor entries in the CharacterArmors table
        $armorIds = array($armor_id, $armor_id_2, $armor_id_3, $armor_id_4);
        $armorTypes = array(1, 2, 3, 4); // Corresponding armor types for each armor

        for ($i = 0; $i < count($armorIds); $i++) {
            $armorId = $armorIds[$i];
            $armorType = $armorTypes[$i];

            // Check if an entry exists for the character and armor combination
            $queryCheckArmor = "SELECT * FROM CharacterArmors WHERE character_id = :character_id AND armor_id = :armor_id";
            $stmtCheckArmor = $db->prepare($queryCheckArmor);
            $stmtCheckArmor->bindValue(':character_id', $character_id);
            $stmtCheckArmor->bindValue(':armor_id', $armorId);
            $stmtCheckArmor->execute();
            $existingArmor = $stmtCheckArmor->fetch(PDO::FETCH_ASSOC);

            if ($existingArmor) {
                // Update the existing entry
                $queryUpdateArmor = "UPDATE CharacterArmors SET armor_id = :armor_id WHERE character_id = :character_id AND armor_id = :existing_armor_id";
                $stmtUpdateArmor = $db->prepare($queryUpdateArmor);
                $stmtUpdateArmor->bindValue(':armor_id', $armorId);
                $stmtUpdateArmor->bindValue(':character_id', $character_id);
                $stmtUpdateArmor->bindValue(':existing_armor_id', $existingArmor['armor_id']);
                $stmtUpdateArmor->execute();
            } else {
                // Insert a new entry
                $queryInsertArmor = "INSERT INTO CharacterArmors (character_id, armor_id) VALUES (:character_id, :armor_id)";
                $stmtInsertArmor = $db->prepare($queryInsertArmor);
                $stmtInsertArmor->bindValue(':character_id', $character_id);
                $stmtInsertArmor->bindValue(':armor_id', $armorId);
                $stmtInsertArmor->execute();
            }
        }

        // Update the post in the Posts table
        $queryUpdatePost = "UPDATE Posts SET content = :content WHERE character_id = :character_id";
        $stmtUpdatePost = $db->prepare($queryUpdatePost);
        $stmtUpdatePost->bindValue(':content', $content);
        $stmtUpdatePost->bindValue(':character_id', $character_id);
        $stmtUpdatePost->execute();

        // Redirect to characters.php after successful update
        header("Location: characters.php");
        exit();
    } else {
        // Error updating character
        echo "Error updating character.";
    }
}

// Fetch character details based on ID
$queryCharacter = "SELECT c.*, p.content 
                   FROM Characters c 
                   LEFT JOIN Posts p ON c.character_id = p.character_id 
                   WHERE c.character_id = :character_id";
$stmtCharacter = $db->prepare($queryCharacter);
$stmtCharacter->bindValue(':character_id', $character_id);
$stmtCharacter->execute();
$character = $stmtCharacter->fetch(PDO::FETCH_ASSOC);

// Retrieve the character's equipped armors along with their types
$queryArmors = "SELECT ca.armor_id, a.armor_name, at.armor_type_name 
                FROM CharacterArmors ca
                INNER JOIN Armors a ON ca.armor_id = a.armor_id
                INNER JOIN ArmorTypes at ON a.armor_type_id = at.armor_type_id
                WHERE ca.character_id = :character_id";
$stmtArmors = $db->prepare($queryArmors);
$stmtArmors->bindValue(':character_id', $character['character_id']);
$stmtArmors->execute();
$equipped_armors = $stmtArmors->fetchAll(PDO::FETCH_ASSOC);

// Check if character exists
if (!$character) {
    // Redirect if character does not exist
    header('Location: characters.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit Character</title>
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

    <main class="container py-1" id="edit-character">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Edit your character</h2>
        <input type="hidden" name="character_id" value="<?php echo $character['character_id']; ?>">
        <div class="form-group">
            <label for="character_name">Character Name:</label>
            <input type="text" id="character_name" name="character_name" value="<?php echo $character['character_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="class_id">Class:</label>
            <select id="class_id" name="class_id" required>
                <option value="">Select Class</option>
                <?php
                $stmt = $db->query("SELECT class_id, class_name FROM Classes");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['class_id'] == $character['class_id']) ? 'selected' : '';
                    echo "<option value='{$row['class_id']}' $selected>{$row['class_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="weapon_id">Weapon:</label>
            <select id="weapon_id" name="weapon_id" required>
                <option value="">Select Weapon</option>
                <?php
                $stmt = $db->query("SELECT weapon_id, weapon_name FROM Weapons");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['weapon_id'] == $character['weapon_id']) ? 'selected' : '';
                    echo "<option value='{$row['weapon_id']}' $selected>{$row['weapon_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="element_id">Element:</label>
            <select id="element_id" name="element_id" required>
                <option value="">Select Element</option>
                <?php
                $stmt = $db->query("SELECT element_id, element_name FROM Elements");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['element_id'] == $character['element_id']) ? 'selected' : '';
                    echo "<option value='{$row['element_id']}' $selected>{$row['element_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
    <label for="armor_id">Head Armor:</label>
    <select id="armor_id" name="armor_id" required>
        <option value="">Select Armor</option>
        <?php
        $stmt = $db->query("SELECT armor_id, armor_name FROM Armors WHERE armor_type_id = 1"); // armor_type_id 1 = head
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = '';
            foreach ($equipped_armors as $armor) {
                if ($armor['armor_type_name'] === 'Head' && $armor['armor_id'] == $row['armor_id']) {
                    $selected = 'selected';
                    break;
                }
            }
            echo "<option value='{$row['armor_id']}' $selected>{$row['armor_name']}</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="armor_id_2">Hands Armor:</label>
    <select id="armor_id_2" name="armor_id_2" required>
        <option value="">Select Armor</option>
        <?php
        $stmt = $db->query("SELECT armor_id, armor_name FROM Armors WHERE armor_type_id = 2"); // armor_type_id 2 = hands
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = '';
            foreach ($equipped_armors as $armor) {
                if ($armor['armor_type_name'] === 'Hands' && $armor['armor_id'] == $row['armor_id']) {
                    $selected = 'selected';
                    break;
                }
            }
            echo "<option value='{$row['armor_id']}' $selected>{$row['armor_name']}</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="armor_id_3">Body Armor:</label>
    <select id="armor_id_3" name="armor_id_3" required>
        <option value="">Select Armor</option>
        <?php
        $stmt = $db->query("SELECT armor_id, armor_name FROM Armors WHERE armor_type_id = 3"); // armor_type_id 3 = body
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = '';
            foreach ($equipped_armors as $armor) {
                if ($armor['armor_type_name'] === 'Body' && $armor['armor_id'] == $row['armor_id']) {
                    $selected = 'selected';
                    break;
                }
            }
            echo "<option value='{$row['armor_id']}' $selected>{$row['armor_name']}</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="armor_id_4">Shoes Armor:</label>
    <select id="armor_id_4" name="armor_id_4" required>
        <option value="">Select Armor</option>
        <?php
        $stmt = $db->query("SELECT armor_id, armor_name FROM Armors WHERE armor_type_id = 4"); // armor_type_id 4 = shoes
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = '';
            foreach ($equipped_armors as $armor) {
                if ($armor['armor_type_name'] === 'Shoes' && $armor['armor_id'] == $row['armor_id']) {
                    $selected = 'selected';
                    break;
                }
            }
            echo "<option value='{$row['armor_id']}' $selected>{$row['armor_name']}</option>";
        }
        ?>
    </select>
</div>

        <!-- Repeat the same process for armor_id, armor_id_2, armor_id_3, and armor_id_4 -->
        <div class="form-group">
            <label for="level">Level:</label>
            <input type="number" id="level" name="level" min="1" max="100" value="<?php echo $character['level']; ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="4" cols="50" required><?php echo isset($character['content']) ? $character['content'] : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
        </div>
        <button type="submit" class="button-primary">Update Character</button>
    </form>
</main>


    <?php include('footer.php');?>
</body>
</html>
