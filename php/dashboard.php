<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch task lists for the user
$query = "SELECT * FROM task_lists WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$task_lists = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Function to translate task status to Greek
function translate_status($status) {
    switch ($status) {
        case 'Pending':
            return 'Σε Αναμονή';
        case 'In Progress':
            return 'Σε Εξέλιξη';
        case 'Completed':
            return 'Ολοκληρωμένη';
        default:
            return $status;
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Πίνακας Ελέγχου</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Πίνακας Ελέγχου</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
        <nav>
            <ul>
                <li><a href="edit_profile.php">Επεξεργασία Προφίλ</a></li>
                <li><a href="export_data.php">Εξαγωγή Δεδομένων</a></li>
                <li><a href="search_lists.php">Αναζήτηση Λιστών</a></li>
                <li><a href="logout.php">Αποσύνδεση</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Οι Λίστες Εργασιών Σας</h1>
        <?php foreach ($task_lists as $list): ?>
            <div>
                <h2><?php echo isset($list['list_name']) ? htmlspecialchars($list['list_name']) : 'Χωρίς Όνομα Λίστας'; ?></h2>
                <a href="delete_list.php?id=<?php echo $list['id']; ?>">Διαγραφή</a>
                <a href="create_task_form.php?list_id=<?php echo $list['id']; ?>">Προσθήκη Εργασίας</a>
                <?php
                // Fetch tasks for the current list
                $query = "SELECT * FROM tasks WHERE list_id = ? ORDER BY created_at DESC";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $list['id']);
                $stmt->execute();
                $task_result = $stmt->get_result();
                $tasks = $task_result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <?php echo htmlspecialchars($task['task_name']) . " (" . translate_status(htmlspecialchars($task['status'])) . ")"; ?>
                            <a href="edit_task.php?id=<?php echo $task['id']; ?>">Επεξεργασία</a>
                            <a href="delete_task.php?id=<?php echo $task['id']; ?>">Διαγραφή</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <a href="create_list_form.php">Δημιουργία Νέας Λίστας</a>
    </main>
</body>
</html>






