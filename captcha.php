<?php
/*
    Jake Licmo
    captcha.php - CAPTCHA script to display on comments page.
*/

session_start();

// Generate a random string for CAPTCHA
$captcha_string = generateRandomString(6); // Change 6 to the desired length of the CAPTCHA string

// Store the CAPTCHA string in the session
$_SESSION['captcha'] = $captcha_string;

header("Content-type: image/png");

// Create a new image with dimensions (width: 200px, height: 50px)
$image = imagecreate(200, 50);

// Define some colors
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $background_color);

imagettftext($image, 20, 0, 10, 40, $text_color, 'arial.ttf', $captcha_string);

imagepng($image);

// Free up memory
imagedestroy($image);

// Function to generate a random string
function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}
?>
