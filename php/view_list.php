<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$list_id = intval($_GET['id']);

// Fetch the task list details
$query = "SELECT * FROM task_lists WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $list_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$task_list = $result->fetch_assoc();
$stmt->close();

if (!$task_list) {
    echo "Η λίστα δεν βρέθηκε ή δεν έχετε δικαίωμα πρόσβασης σε αυτή.";
    exit();
}

// Fetch tasks for the current list
$query = "SELECT * FROM tasks WHERE list_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $list_id);
$stmt->execute();
$task_result = $stmt->get_result();
$tasks = $task_result->fetch_all(MYSQLI_ASSOC);
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
    <title>Προβολή Λίστας Εργασιών</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Προβολή Λίστας Εργασιών</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
        <nav>
            <ul>
                <li><a href="dashboard.php">Οι Λίστες Εργασιών Σας</a></li>
                <li><a href="edit_profile.php">Επεξεργασία Προφίλ</a></li>
                <li><a href="export_data.php">Εξαγωγή Δεδομένων</a></li>
                <li><a href="search_lists.php">Αναζήτηση Λιστών</a></li>
                <li><a href="logout.php">Αποσύνδεση</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2><?php echo htmlspecialchars($task_list['list_name']); ?></h2>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo htmlspecialchars($task['task_name']) . " (" . translate_status(htmlspecialchars($task['status'])) . ")"; ?>
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>">Επεξεργασία</a>
                    <a href="delete_task.php?id=<?php echo $task['id']; ?>">Διαγραφή</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="window.location.href='dashboard.php'">Επιστροφή στις Λίστες Εργασιών</button>
    </main>
</body>
</html>


