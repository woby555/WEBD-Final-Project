<?php
/*
    Jake Licmo
    delete.php - This is just a confirm delete script pop-up that redirects to delete_confirm.
*/
// Check if character ID is provided
if (isset($_GET['id'])) {
    $character_id = $_GET['id'];
    echo <<<HTML
    <script>
    var result = confirm("Are you sure you want to delete this character?");
    if (result) {
        window.location.href = "delete_confirm.php?id=$character_id";
    } else {
        window.location.href = "characters.php";
    }
    </script>
HTML;
} else {
    // Redirect if character ID is not provided
    header('Location: characters.php');
    exit();
}
?>
