<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Δημιουργία Νέας Λίστας</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Δημιουργία Νέας Λίστας</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
    </header>
    <main>
        <form action="create_list.php" method="post">
            <label for="list_name">Όνομα Λίστας:</label>
            <input type="text" id="list_name" name="list_name" required><br>
            <button type="submit">Δημιουργία Νέας Λίστας</button>
        </form>
    </main>
</body>
</html>

