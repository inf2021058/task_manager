<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$list_id = intval($_GET['list_id']);
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προσθήκη Εργασίας</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Προσθήκη Εργασίας</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
    </header>
    <main>
        <form action="create_task.php" method="post">
            <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
            <label for="task_name">Όνομα Εργασίας:</label>
            <input type="text" id="task_name" name="task_name" required><br>
            <button type="submit">Προσθήκη Εργασίας</button>
        </form>
    </main>
</body>
</html>

