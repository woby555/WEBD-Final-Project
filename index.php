<!-- 
    Jake Licmo
    Web Development 2 Project
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to Blue Protocol Community Creations!</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <img class="logo" src="images/logos.png" alt="logo">
        </div>
    </header>

    <main>
        <?php include('nav.php'); ?>

        <?php if (isset($_SESSION['username'])) : ?>
            <p class="welcome">Welcome, <?php echo $_SESSION['username']; ?>. Your user Id is: <?php echo $_SESSION['user_id']; ?>!</p>
        <?php endif; ?>

        <h1>Welcome to Blue Protocol Community Creations!</h1>
        <p>Dive into the vibrant world of Blue Protocol with our community-driven platform designed exclusively for avid gamers like you. Whether you're a seasoned veteran or just stepping into the fray, our CMS website offers a dynamic space to unleash your creativity and connect with fellow players.</p>

        <h2>Forge Your Legend</h2>
        <p>Craft your own character from the ground up, shaping every aspect of their identity. Choose from a diverse array of classes, each with unique abilities and playstyles. Harness the elemental forces of Wind, Fire, Ice, and more to tailor your character's power to your liking. Arm yourself with a vast selection of weapons and armor, customizing your loadout for every encounter.</p>

        <h2>Share and Connect</h2>
        <p>Join a thriving community of Blue Protocol enthusiasts eager to share their creations and insights. Showcase your characters, movesets, and layouts with ease, inspiring and collaborating with fellow members. Engage in lively discussions on strategy, theorycrafting the ultimate builds, and unraveling the game's deepest mysteries.</p>
        <br>
        <p>Ready to take the next step in your Blue Protocol adventure? Sign up now and become part of our vibrant community. The future of Blue Protocol awaits, and it's yours to shape.</p>
        <?php if (isset($_SESSION['username'])) : ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>

        <?php include('footer.php'); ?>
    </main>
</body>

</html>