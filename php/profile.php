<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT first_name, last_name, email, simplepush_key FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h1>Profile</h1>";
    echo "<p>First Name: " . $row['first_name'] . "</p>";
    echo "<p>Last Name: " . $row['last_name'] . "</p>";
    echo "<p>Email: " . $row['email'] . "</p>";
    echo "<p>Simplepush Key: " . $row['simplepush_key'] . "</p>";
} else {
    echo "No profile information found.";
}

$conn->close();
?>

