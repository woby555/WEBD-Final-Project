<?php

/*******w******** 
    
    Name: Jake Licmo
    Date: Febuary 11, 2024
    Description: index.php for Assignment 3. Displays all blog posts.

****************/

require('connect.php');

$query = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT 5";

$statement = $db->prepare($query);

$statement -> execute();
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
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <main>
        
        <?php include('nav.php');?>

        <?php include('footer.php');?>

    </main>
</body>
</html>