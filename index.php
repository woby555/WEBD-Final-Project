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
        <?php include('nav.php');?>

        <?php if(isset($_SESSION['username'])): ?>
            <h1>Welcome, <?php echo $_SESSION['username']; ?>. Your user Id is: <?php echo $_SESSION['user_id']; ?>!</h1>
        <?php endif; ?>
        <p>This is the main landing page.</p>
        <?php if(isset($_SESSION['username'])): ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    
        <?php include('footer.php');?>
    </main>
</body>
</html>
