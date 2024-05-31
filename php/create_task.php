<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Function to send a Simplepush notification
function sendSimplepushNotification($key, $title, $message) {
    $url = 'https://api.simplepush.io/send';
    $data = [
        'key' => $key,
        'title' => $title,
        'msg' => $message
    ];
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = htmlspecialchars(trim($_POST['task_name']));
    $list_id = intval($_POST['list_id']);
    $user_id = $_SESSION['user_id'];

    if (!empty($task_name) && !empty($list_id) && !empty($user_id)) {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, list_id, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $task_name, $list_id, $user_id);
        $execute_result = $stmt->execute();
        $stmt->close();

        if ($execute_result) {
            // Get the user's Simplepush key
            $stmt = $conn->prepare("SELECT simplepush_key FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($simplepush_key);
            $stmt->fetch();
            $stmt->close();

            // Send the Simplepush notification if the key is available
            if (!empty($simplepush_key)) {
                sendSimplepushNotification($simplepush_key, 'Νέα Εργασία', 'Δημιουργήθηκε νέα εργασία: ' . $task_name);
            }

            $_SESSION['message'] = "Η εργασία δημιουργήθηκε επιτυχώς!";
        } else {
            $_SESSION['error'] = "Σφάλμα κατά τη δημιουργία της εργασίας.";
        }
    } else {
        $_SESSION['error'] = "Το όνομα της εργασίας και το ID λίστας δεν μπορούν να είναι κενά.";
    }
}

header("Location: dashboard.php");
exit();
?>



