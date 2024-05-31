<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $list_name = htmlspecialchars(trim($_POST['list_name']));
    $user_id = $_SESSION['user_id'];

    if (!empty($list_name) && !empty($user_id)) {
        $stmt = $conn->prepare("INSERT INTO task_lists (list_name, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $list_name, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Η λίστα δημιουργήθηκε επιτυχώς!";
        } else {
            $_SESSION['error'] = "Σφάλμα κατά τη δημιουργία της λίστας.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Το όνομα της λίστας δεν μπορεί να είναι κενό.";
    }
}

header("Location: dashboard.php");
exit();
?>


