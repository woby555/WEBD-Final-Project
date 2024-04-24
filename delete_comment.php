<?php
/*
    Jake Licmo
    delete_comment.php - Deletes a commment on a respective post (User and Administrator access).
*/
session_start();

require_once 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the comment_id is provided and valid
if (!isset($_POST['comment_id'])) {
    // Redirect if comment_id is not provided
    header("Location: index.php");
    exit();
}

// Fetch the comment_id from the POST data
$comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT);

// Check if the user is an administrator or the comment author
$stmt = $db->prepare("SELECT user_id FROM Comments WHERE comment_id = :comment_id");
$stmt->bindParam(':comment_id', $comment_id);
$stmt->execute();
$comment = $stmt->fetch(PDO::FETCH_ASSOC);

// If the user is an administrator or the comment author, delete the comment
if ($_SESSION['role'] === 'Administrator' || $comment['user_id'] === $_SESSION['user_id']) {
    $stmt = $db->prepare("DELETE FROM Comments WHERE comment_id = :comment_id");
    $stmt->bindParam(':comment_id', $comment_id);
    $stmt->execute();
}
// Redirect back to the show.php page with the correct post_id parameter
$post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
if ($post_id) {
    header("Location: show.php?post_id=" . $post_id);
} else {
    header("Location: index.php");
}
exit();

?>
