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
    <title>Καλωσορίσατε στην Πλατφόρμα Διαχείρισης Εργασιών</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Καλωσορίσατε στην Πλατφόρμα Διαχείρισης Εργασιών</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
        <nav>
            <ul>
                <li><a href="index.php">Αρχική</a></li>
                <li><a href="purpose.html">Σκοπός και Εγγραφή</a></li>
                <li><a href="help.html">Βοήθεια</a></li>
            </ul>
        </nav>
    </header>
    <main>
         <ul>
             <li><a href="login.php">Σύνδεση</a></li>
             
             <li><a href="register.php">Εγγραφή</a></li>
        </ul>
    </main>
</body>
</html>

