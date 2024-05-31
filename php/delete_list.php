<?php
session_start();
require 'config.php'; 

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $list_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Διαγραφή όλων των εργασιών που ανήκουν στη λίστα
    $stmt = $conn->prepare("DELETE FROM tasks WHERE list_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $list_id, $user_id);

    if ($stmt->execute()) {
        // Διαγραφή της λίστας αφού έχουν διαγραφεί όλες οι εργασίες
        $stmt = $conn->prepare("DELETE FROM task_lists WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $list_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Η λίστα διαγράφηκε επιτυχώς!";
        } else {
            $_SESSION['error'] = "Σφάλμα κατά τη διαγραφή της λίστας.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Σφάλμα κατά τη διαγραφή των εργασιών της λίστας.";
    }
}

header("Location: dashboard.php");
exit();
?>
