<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

echo "Step 1: Beginning of script";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Step 2: POST request detected";
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = htmlspecialchars(trim($_POST['email']));
    $simplepush_key = htmlspecialchars(trim($_POST['simplepush_key']));

    echo "Step 3: Form data processed";

    // Check if the username or email already exists
    $query = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Step 4: Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    echo "Step 5: Username and email check executed";

    if ($stmt->num_rows > 0) {
        // Username or email already exists
        $_SESSION['error'] = "Το όνομα χρήστη ή το email υπάρχει ήδη. Δοκιμάστε άλλο.";
        $stmt->close();
        header("Location: register.php");
        exit();
    } else {
        // Insert new user
        $stmt->close();
        $query = "INSERT INTO users (first_name, last_name, username, password, email, simplepush_key) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "Step 6: Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit();
        }
        $stmt->bind_param("ssssss", $first_name, $last_name, $username, $password, $email, $simplepush_key);

        if ($stmt->execute()) {
            echo "Step 7: User inserted successfully";
            header("Location: login.php");
            exit();
        } else {
            echo "Step 8: Error inserting user: (" . $stmt->errno . ") " . $stmt->error;
            $_SESSION['error'] = "Σφάλμα κατά την εγγραφή.";
            header("Location: register.php");
            exit();
        }

        $stmt->close();
    }
} else {
    echo "Step 9: No POST request detected";
}
?>






