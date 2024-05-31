<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Η εργασία διαγράφηκε επιτυχώς!";
    } else {
        $_SESSION['error'] = "Σφάλμα κατά τη διαγραφή της εργασίας.";
    }

    $stmt->close();
}

header("Location: dashboard.php");
exit();
?>
