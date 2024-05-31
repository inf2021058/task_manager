<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Εγγραφή Χρήστη</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Εγγραφή Χρήστη</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
    </header>
    <main>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>{$_SESSION['error']}</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="register_action.php" method="post">
            <label for="first_name">Όνομα:</label>
            <input type="text" id="first_name" name="first_name" required><br>
            <label for="last_name">Επώνυμο:</label>
            <input type="text" id="last_name" name="last_name" required><br>
            <label for="username">Όνομα Χρήστη:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Κωδικός:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="simplepush_key">Simplepush Key:</label>
            <input type="text" id="simplepush_key" name="simplepush_key"><br>
            <button type="submit">Εγγραφή</button>
        </form>
    </main>
</body>
</html>







