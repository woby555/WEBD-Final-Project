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
    <title>Welcome to my Blog!</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <main>
        <?php include('nav.php'); ?>

        <div class="post-details">
            <?php if (isset($post) && $post) : ?>
                <!-- Display character details -->
                <h3>Character Details</h3>
                <p>Character Name: <?php echo $post['character_name']; ?></p>
                <p>Level: <?php echo $post['level']; ?></p>
                <p>Class: <?php echo $post['class_name']; ?></p>
                <p>Weapon: <?php echo $post['weapon_name'] ?? 'None'; ?></p>
                <p>Element: <?php echo $post['element_name']; ?></p>
                <?php if ($post['image_path']) : ?>
                    <img src="<?php echo $post['image_path']; ?>" alt="Character Image" width="200">
                <?php else : ?>
                    <img src="images/unavailable.png" alt="Character Image" width="100">
                <?php endif; ?>
                <h2><?php echo $post['title']; ?></h2>
                <p><?php echo $post['content']; ?></p>
                <p>Date Posted: <?php echo $post['date_posted']; ?></p>
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