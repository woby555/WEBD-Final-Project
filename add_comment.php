<?php
/*
    Jake Licmo
    add_comment.php - Create controls for comments.
*/

session_start();

require_once 'connect.php';

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT); // Sanitize as number
    $comment_content = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Sanitize as full special chars
    $captcha_input = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_STRING);

    // Validate CAPTCHA
    if (isset($_SESSION['captcha']) && $_SESSION['captcha'] === $captcha_input) {

        $stmt = $db->prepare("INSERT INTO Comments (post_id, user_id, content, date_posted) VALUES (:post_id, :user_id, :content, NOW())");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming the user is logged in and their user_id is stored in the session
        $stmt->bindParam(':content', $comment_content);

        // Execute the statement and redirect to appropriate page
        if ($stmt->execute()) {
            header("Location: show.php?post_id=$post_id&comment_added=1");
            exit();
        } else {
            header("Location: show.php?post_id=$post_id&comment_error=1");
            exit();
        }
    } else {
        header("Location: show.php?post_id=$post_id&captcha_error=1");
        exit();
    }
} else {
    // Redirect back to the show.php page if form is not submitted
    header("Location: show.php");
    exit();
}
?>
