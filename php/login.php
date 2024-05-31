<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        if ($user_id && password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Λανθασμένο όνομα χρήστη ή κωδικός.";
        }
    } else {
        $error = "Συμπληρώστε όλα τα πεδία.";
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Σύνδεση</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Σύνδεση</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
        <nav>
            <ul>
                <li><a href="index.php">Αρχική</a></li>
                <li><a href="purpose.html">Σκοπός και Εγγραφή</a></li>
                <li><a href="help.html">Βοήθεια</a></li>
                <li><a href="register.php">Εγγραφή</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        <form action="login.php" method="post">
            <label for="username">Όνομα Χρήστη:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Κωδικός:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Σύνδεση</button>
        </form>
    </main>
</body>
</html>


