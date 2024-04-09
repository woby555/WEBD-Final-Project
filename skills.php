<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('nav.php'); ?>

    <h1>Skills</h1>

    <!-- Sorting buttons -->
    <div id="sorting-buttons">
        <button onclick="clearSort()">CLEAR SORTING</button> 
        <button onclick="sortTable(0)">Sort by Skill Name</button>
        <button onclick="sortTable(1)">Sort by Class</button>

        <!-- Additional buttons to sort by respective classes -->
        <?php
        // Fetch distinct class names from the database
        require_once 'connect.php';
        $stmt = $db->query("SELECT DISTINCT class_name FROM Classes");
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output buttons to sort by respective classes
        foreach ($classes as $class) {
            echo "<button onclick=\"sortTableByClass('{$class['class_name']}')\">Sort by {$class['class_name']}</button>";
        }
        ?>
    </div>

    <!-- Skills table -->
    <table id="skills-table">
        <thead>
            <tr>
                <th>Skill Name</th>
                <th>Class</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch skills and classes from the database
            require_once 'connect.php';
            $stmt = $db->query("SELECT Skills.skill_name, Classes.class_name 
                                FROM Skills 
                                INNER JOIN Classes ON Skills.class_id = Classes.class_id");
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Output skills in table rows without class colors initially
            foreach ($skills as $skill) {
                echo "<tr>";
                echo "<td>{$skill['skill_name']}</td>";
                echo "<td>{$skill['class_name']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script src="skills.js"></script>

    <?php include('footer.php'); ?>
</body>
</html>