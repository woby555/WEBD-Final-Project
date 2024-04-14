<?php
session_start();
require_once 'connect.php';

// Check if character ID is provided and if the user is logged in
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    // Retrieve character ID from the URL
    $character_id = $_GET['id'];
    
    // Delete associated records from the Posts table
    $query_delete_posts = "DELETE FROM Posts WHERE character_id = :character_id";
    $statement_delete_posts = $db->prepare($query_delete_posts);
    $statement_delete_posts->bindValue(':character_id', $character_id);
    $statement_delete_posts->execute();
    
    // Delete associated records from the CharacterArmors table
    $query_delete_armors = "DELETE FROM CharacterArmors WHERE character_id = :character_id";
    $statement_delete_armors = $db->prepare($query_delete_armors);
    $statement_delete_armors->bindValue(':character_id', $character_id);
    $statement_delete_armors->execute();
    
    // Prepare and execute a query to delete the character from the Characters table
    $query_delete_character = "DELETE FROM Characters WHERE character_id = :character_id AND user_id = :user_id";
    $statement_delete_character = $db->prepare($query_delete_character);
    $statement_delete_character->bindValue(':character_id', $character_id);
    $statement_delete_character->bindValue(':user_id', $_SESSION['user_id']);
    
    if ($statement_delete_character->execute()) {
        // Character deleted successfully
        echo '<script>alert("Character deleted successfully!"); window.location.href = "characters.php";</script>';
        exit();
    } else {
        // Error occurred while deleting the character
        echo '<script>alert("Error deleting character."); window.location.href = "characters.php";</script>';
        exit();
    }
} else {
    // Redirect user if character ID is not provided or if the user is not logged in
    header('Location: characters.php');
    exit();
}
?>