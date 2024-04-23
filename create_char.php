<?php
session_start();
require('connect.php');

// Function to safely build a path string for uploading files
function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
{
    $upload_folder = 'uploads';
    $path_segments = [$upload_folder, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

// Uploaded file mime check
function file_is_an_image($temporary_path, $new_path)
{
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = getimagesize($temporary_path)['mime'];
    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);
    return $file_extension_is_valid && $mime_type_is_valid;
}

// Form submission
$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
$image_filename = null; // Initialize image filename variable

if ($image_upload_detected) {
    $image_filename = $_FILES['image']['name'];
    $temporary_image_path = $_FILES['image']['tmp_name'];
    $new_image_path = file_upload_path($image_filename);

    // Check if the uploaded file is an image
    if (file_is_an_image($temporary_image_path, $new_image_path)) {
        // Move the valid uploaded image to the uploads folder
        move_uploaded_file($temporary_image_path, $new_image_path);
    } else {
        echo "Invalid image upload. Please upload a valid image file.";
        exit;
    }
}

// Check if the user has already created a character
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM Characters WHERE user_id = :user_id";
$statement = $db->prepare($query);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
$existing_character = $statement->fetch(PDO::FETCH_ASSOC);

if ($existing_character) {
    // If a character already exists for the user, display a message
    echo "<script>alert('You have already created a character! Please either edit your existing character, or delete a character to create a new one.'); window.location.href = 'characters.php';</script>";
    exit;
}

// Character Form submission, Sanitation where needed.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['character_name']) && !empty($_POST['class_id']) && !empty($_POST['weapon_id']) && !empty($_POST['element_id']) && !empty($_POST['armor_id']) && !empty($_POST['level']) && !empty($_POST['content'])) {
    $character_name = filter_input(INPUT_POST, 'character_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_id = $_POST['class_id'];
    $weapon_id = $_POST['weapon_id'];
    $element_id = $_POST['element_id'];
    $armor_id = $_POST['armor_id'];
    $armor_id_2 = $_POST['armor_id_2'];
    $armor_id_3 = $_POST['armor_id_3'];
    $armor_id_4 = $_POST['armor_id_4'];
    $level = $_POST['level'];
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $image_path = file_upload_path($image_filename);

    // Insert the character into the Characters table
    $query = "INSERT INTO Characters (user_id, character_name, level, class_id, weapon_id, element_id, image_path) VALUES (:user_id, :character_name, :level, :class_id, :weapon_id, :element_id, :image_path)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':character_name', $character_name);
    $statement->bindValue(':level', $level);
    $statement->bindValue(':class_id', $class_id);
    $statement->bindValue(':weapon_id', $weapon_id);
    $statement->bindValue(':element_id', $element_id);
    $statement->bindValue(':image_path', $image_path);

    if ($statement->execute()) {
        // Get the character ID of the newly inserted character
        $character_id = $db->lastInsertId();

        // Insert the armor into the CharacterArmors table
        $query = "INSERT INTO CharacterArmors (character_id, armor_id) VALUES (:character_id, :armor_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':character_id', $character_id);
        $statement->bindValue(':armor_id', $armor_id);

        if ($statement->execute()) {
            // Insert the armor 2 into the CharacterArmors table
            $query = "INSERT INTO CharacterArmors (character_id, armor_id) VALUES (:character_id, :armor_id)";
            $statement = $db->prepare($query);
            $statement->bindValue(':character_id', $character_id);
            $statement->bindValue(':armor_id', $armor_id_2);

            if ($statement->execute()) {
                // Insert the armor 3 into the CharacterArmors table
                $query = "INSERT INTO CharacterArmors (character_id, armor_id) VALUES (:character_id, :armor_id)";
                $statement = $db->prepare($query);
                $statement->bindValue(':character_id', $character_id);
                $statement->bindValue(':armor_id', $armor_id_3);

                if ($statement->execute()) {
                    // Insert the armor 4 into the CharacterArmors table
                    $query = "INSERT INTO CharacterArmors (character_id, armor_id) VALUES (:character_id, :armor_id)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':character_id', $character_id);
                    $statement->bindValue(':armor_id', $armor_id_4);

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
                        echo "Error creating armor 4.";
                    }
                } else {
                    echo "Error creating armor 3.";
                }
            } else {
                echo "Error creating armor 2.";
            }
        } else {
            echo "Error creating armor 1.";
        }
    } else {
        echo "Error creating character.";
    }

    // Redirect to index.php after creating the character and post
    header("Location: characters.php");
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
    <nav class="navbar">
        <ul class="container">
            <li><a href="index.php" class="button-primary-outline">Home</a></li>
            <li><a href="characters.php" class="button-primary-outline">Characters</a></li>
            <li><a href="elements.php" class="button-primary-outline">Elements</a></li>
            <li><a href="classes.php" class="button-primary-outline">Classes</a></li>
            <li><a href="skills.php" class="button-primary-outline">Skills</a></li>
            <li><a href="weapons.php" class="button-primary-outline">Weapons</a></li>
            <li><a href="armors.php" class="button-primary-outline">Armors</a></li>
            <?php if (isset($_SESSION['username']) && $_SESSION['role'] === 'Administrator') {
                echo '<li><a href="admin_dashboard.php" class="button-primary-outline">Admin Dashboard</a></li>';
                echo '<br><li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
            } else if (isset($_SESSION['username'])) {
                echo '<br><li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
            } else {
                echo '<li><a href="login_page.php" class="button-primary-outline">Login</a></li>';
            } ?>
        </ul>
    </nav>


    <main class="container py-1" id="create-character">
        <form action="create_char.php" method="POST" enctype="multipart/form-data">
            <h2>Create your character</h2>
            <div class="form-group">
                <label for="character_name">Character Name:</label>
                <input type="text" id="character_name" name="character_name" required>
            </div>
            <div class="form-group">
                <label for="class_id">Class:</label>
                <select id="class_id" name="class_id" required>
                    <option value="">Select Class</option>
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
                    <?php
                    $stmt = $db->query("SELECT element_id, element_name FROM Elements");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['element_id']}'>{$row['element_name']}</option>";
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
                        echo "<option value='{$row['armor_id']}'>{$row['armor_name']}</option>";
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
                        echo "<option value='{$row['armor_id']}'>{$row['armor_name']}</option>";
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
                        echo "<option value='{$row['armor_id']}'>{$row['armor_name']}</option>";
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
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image">
            </div>
            <button type="submit" class="button-primary">Create Character</button>
        </form>
    </main>


    <?php include('footer.php'); ?>
</body>

</html>