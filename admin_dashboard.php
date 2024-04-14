<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: index.php"); // Redirect to login page if not logged in as an administrator
    exit();
}

// Include database connection
require_once 'connect.php';

// Fetch all users from the database
$stmt = $db->query("SELECT * FROM Users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <header class="header">
        <div class="text-center">
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['username']; ?>! Account status: <?php echo $_SESSION['role']; ?>, ID: <?php echo $_SESSION['user_id']; ?></p>
            <a href="index.php"> Home </a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main>
        <section>
            <h2>Registered Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td>
                                <a href="update_user.php?id=<?php echo $user['user_id']; ?>">Update</a>
                                <a href="delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Add New User</h2>
            <form action="add_user.php" method="post">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="User">User</option>
                        <option value="Administrator">Administrator</option>
                    </select>
                </div>
                <button type="submit">Add User</button>
            </form>
        </section>
    </main>
</body>

</html>