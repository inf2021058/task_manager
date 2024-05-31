<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information
$query = "SELECT first_name, last_name, username, email, simplepush_key FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $username, $email, $simplepush_key);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $simplepush_key = htmlspecialchars(trim($_POST['simplepush_key']));

    if (!empty($first_name) && !empty($last_name) && !empty($username) && !empty($email)) {
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ?, simplepush_key = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $first_name, $last_name, $username, $email, $simplepush_key, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Το προφίλ ενημερώθηκε επιτυχώς!";
            header("Location: dashboard.php"); // Redirect to dashboard after successful update
            exit();
        } else {
            $_SESSION['error'] = "Σφάλμα κατά την ενημέρωση του προφίλ.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Όλα τα πεδία είναι υποχρεωτικά.";
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Προφίλ</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Επεξεργασία Προφίλ</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
    </header>
    <main>
        <?php if (isset($_SESSION['message'])) { echo "<p>{$_SESSION['message']}</p>"; unset($_SESSION['message']); } ?>
        <?php if (isset($_SESSION['error'])) { echo "<p>{$_SESSION['error']}</p>"; unset($_SESSION['error']); } ?>
        <form action="edit_profile.php" method="post">
            <label for="first_name">Όνομα:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required><br>
            <label for="last_name">Επώνυμο:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required><br>
            <label for="username">Όνομα Χρήστη:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
            <label for="simplepush_key">Simplepush Key:</label>
            <input type="text" id="simplepush_key" name="simplepush_key" value="<?php echo htmlspecialchars($simplepush_key); ?>"><br>
            <button type="submit">Ενημέρωση</button>
        </form>
    </main>
</body>
</html>



