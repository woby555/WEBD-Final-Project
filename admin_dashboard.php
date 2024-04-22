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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Hash and salt the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to insert user into database
    $stmt = $db->prepare("INSERT INTO Users (username, email, hashed_password, role) VALUES (:username, :email, :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindValue(':role', $_POST['role']);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "User successfully registered.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['register_error'] = "An error occurred while registering. Please try again later.";
        header("Location: admin_dashboard.php");
        exit();
    }
}


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
                    <?php if (isset($_SESSION['update_error_details'])) {
                        echo "Update Error: " . $_SESSION['update_error_details'][0]; // This will display the error message
                        // Optionally, you can also display additional error details like error code and SQL statement
                        echo "<br>Error Code: " . $_SESSION['update_error_details'][1];
                        echo "<br>SQL Statement: " . $_SESSION['update_error_details'][2];

                        // Clear the session variable to avoid displaying the same error message on subsequent page loads
                        unset($_SESSION['update_error_details']);
                    } ?>
                </tbody>
            </table>
        </section>

        <section id="admin-controls" class="flex-container">
            <!-- Add New User Section -->
            <section>
                <h2>Add New User</h2>
                <form action="admin_dashboard.php" method="post">
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

            <section>
                <h2>Quick Access Controls</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Add Armor</td>
                            <td><a href="add_armor.php">Add Armor</a></td>
                        </tr>
                        <tr>
                            <td>Add Class</td>
                            <td><a href="add_class.php">Add Class</a></td>
                        </tr>
                        <tr>
                            <td>Add Element</td>
                            <td><a href="add_element.php">Add Element</a></td>
                        </tr>
                        <tr>
                            <td>Add Skill</td>
                            <td><a href="add_skill.php">Add Skill</a></td>
                        </tr>
                        <tr>
                            <td>Add Weapon</td>
                            <td><a href="add_weapon.php">Add Weapon</a></td>
                        </tr>
                        <tr>
                            <td>Delete Armor</td>
                            <td><a href="delete_armor.php">Delete Armor</a></td>
                        </tr>
                        <tr>
                            <td>Delete Character</td>
                            <td><a href="delete_char.php">Delete Character</a></td>
                        </tr>
                        <tr>
                            <td>Delete Class</td>
                            <td><a href="delete_class.php">Delete Class</a></td>
                        </tr>
                        <tr>
                            <td>Delete Element</td>
                            <td><a href="delete_element.php">Delete Element</a></td>
                        </tr>
                        <tr>
                            <td>Delete Skill</td>
                            <td><a href="delete_skill.php">Delete Skill</a></td>
                        </tr>
                        <tr>
                            <td>Delete Weapon</td>
                            <td><a href="delete_weapon.php">Delete Weapon</a></td>
                        </tr>
                    </tbody>
                </table>
            </section>

        </section>
    </main>
</body>

</html>