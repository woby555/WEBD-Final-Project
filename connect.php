 <?php
    /*
        Jake Licmo
        connect.php - Connection to the database.
    */
    define('DB_DSN', 'mysql:host=localhost;dbname=serverside;charset=utf8');
    define('DB_USER', 'serveruser');
    define('DB_PASS', 'gorgonzola7!');

    try {
        // Try creating new PDO connection to MySQL.
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
        //,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
    ?>