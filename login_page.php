<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Login</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <img class="logo" src="images/logos.png">
        </div>
    </header>

    <main>
        <?php include('nav.php'); ?>

        <div class="login-form">
            <h2>Login</h2>
            <?php if (isset($_GET['login_error']) && $_GET['login_error'] == 1) : ?>
                <p class="error-message">Incorrect username or password. Please try again.</p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="additional-options">
                <!--<a href="forgot_password.php">Forgot Password?</a>-->
                <span> | </span>
                <a href="register.php">Register</a>
            </div>
        </div>

        <?php include('footer.php'); ?>
    </main>
</body>

</html>