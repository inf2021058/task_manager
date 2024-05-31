<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Εργασιών</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="dashboard.php">Πίνακας Ελέγχου</a></li>
                    <li><a href="profile.php">Προφίλ</a></li>
                    <li><a href="logout.php">Αποσύνδεση</a></li>
                <?php else: ?>
                    <li><a href="index.php">Αρχική</a></li>
                    <li><a href="register.html">Εγγραφή</a></li>
                    <li><a href="login.php">Σύνδεση</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>


