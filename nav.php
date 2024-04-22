<link rel="stylesheet" href="main.css">
<nav class="navbar">
    <ul class="container">
        <li><a href="index.php" class="button-primary-outline">Home</a></li>
        <li><a href="characters.php" class="button-primary-outline">Characters</a></li>
        <li><a href="elements.php" class="button-primary-outline">Elements</a></li>
        <li><a href="classes.php" class="button-primary-outline">Classes</a></li>
        <li><a href="skills.php" class="button-primary-outline">Skills</a></li>
        <li><a href="weapons.php" class="button-primary-outline">Weapons</a></li>
        <li><a href="armors.php" class="button-primary-outline">Armors</a></li>
        <?php
        session_start();
        if (isset($_SESSION['username']) && $_SESSION['role'] === 'Administrator') {
            echo '<li><a href="admin_dashboard.php" class="button-primary-outline">Admin Dashboard</a></li>';
            echo '<li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
        } else if (isset($_SESSION['username'])) {
            echo '<li><a href="logout.php" class="button-primary-outline">Log out</a></li>';
        } else {
            echo '<li><a href="login_page.php" class="button-primary-outline">Login</a></li>';
        }
        ?>
    </ul>
</nav>
