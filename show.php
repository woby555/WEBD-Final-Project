<?php

// Include database connection
require_once 'connect.php';

// Fetch post details and character information
$post_id = $_GET['post_id']; // Make sure to validate and sanitize this input
$stmt = $db->prepare("SELECT p.*, c.character_name, c.level, cls.class_name, w.weapon_name, e.element_name, c.image_path
                      FROM Posts p
                      JOIN Characters c ON p.character_id = c.character_id
                      JOIN Classes cls ON c.class_id = cls.class_id
                      LEFT JOIN Weapons w ON c.weapon_id = w.weapon_id
                      JOIN Elements e ON c.element_id = e.element_id
                      WHERE p.post_id = :post_id");
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch comments associated with the post
$stmt = $db->prepare("SELECT * FROM Comments WHERE post_id = :post_id");
$stmt->bindParam(':post_id', $post_id);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch armors associated with the character
$stmt = $db->prepare("SELECT a.armor_name FROM CharacterArmors ca
                      JOIN Armors a ON ca.armor_id = a.armor_id
                      WHERE ca.character_id = :character_id");
$stmt->bindParam(':character_id', $post['character_id']);
$stmt->execute();
$armors = $stmt->fetchAll(PDO::FETCH_COLUMN);


function getUsername($user_id)
{
    global $db;
    $stmt = $db->prepare("SELECT username FROM Users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['username'] : 'Unknown';
}

//////////////////// CAPTCHA TEST
// Generate a random CAPTCHA code
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Viewing Character</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <img class="logo" src="images/logos.png">
        </div>
    </header>

    <main>
        <?php include('nav.php'); ?>

        <div class="post-details">
            <?php if ($post['image_path']) : ?>
                <img src="<?php echo $post['image_path']; ?>" alt="Character Image" width="200">
            <?php else : ?>
                <img src="images/unavailable.png" alt="Character Image" width="100">
            <?php endif; ?>
            <?php if (isset($post) && $post) : ?>
                <!-- Display character details -->
                <h3>Character Details</h3>
                <table>
                    <tr>
                        <td>Character Name:</td>
                        <td><?php echo $post['character_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Level:</td>
                        <td><?php echo $post['level']; ?></td>
                    </tr>
                    <tr>
                        <td>Class:</td>
                        <td><?php echo $post['class_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Weapon:</td>
                        <td><?php echo $post['weapon_name'] ?? 'None'; ?></td>
                    </tr>
                    <tr>
                        <td>Element:</td>
                        <td><?php echo $post['element_name']; ?></td>
                    </tr>
                </table>
                <h3>Equipped Armors</h3>
                <?php if ($armors) : ?>
                    <ul>
                        <?php foreach ($armors as $armor) : ?>
                            <li><?php echo $armor; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No armors equipped.</p>
                <?php endif; ?>
                <h1>Content</h1>
                <p>Date Posted: <?php echo $post['date_posted']; ?></p>
                <p><?php echo $post['content']; ?></p>
            <?php else : ?>
                <p>No post found.</p>
            <?php endif; ?>
        </div>

        <div class="comments-section">
            <h3>Comments</h3>
            <?php if (isset($comments) && $comments) : ?>
                <ul>
                    <?php foreach ($comments as $comment) : ?>
                        <li>
                            <p><?php echo $comment['content']; ?></p>
                            <p>Posted by: <?php echo getUsername($comment['user_id']); ?></p>
                            <p>Date Posted: <?php echo $comment['date_posted']; ?></p>
                            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'Administrator' || $_SESSION['user_id'] === $comment['user_id'])) : ?>
                                <!-- Display delete button for administrators or comment authors -->
                                <form action="delete_comment.php" method="post">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"> <!-- Add this line -->
                                    <button type="submit">Delete</button>
                                </form>
                            <?php endif; ?>

                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No comments yet.</p>
            <?php endif; ?>
        </div>


        <?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'User' || $_SESSION['role'] === 'Administrator')) : ?>
            <div class="comment-form">
                <h3>Add a Comment</h3>
                <form action="add_comment.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="captcha">CAPTCHA:</label><br>
                        <img src="captcha.php" alt="CAPTCHA"><br>
                        <input type="text" id="captcha" name="captcha" required>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        <?php endif; ?>



        <?php include('footer.php'); ?>
    </main>
</body>

</html>