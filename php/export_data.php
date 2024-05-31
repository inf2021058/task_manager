<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=tasks.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Όνομα Εργασίας', 'ID Λίστας', 'ID Χρήστη', 'Κατάσταση', 'Ημερομηνία Δημιουργίας'));

$query = "SELECT task_name, list_id, user_id, status, created_at FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>



