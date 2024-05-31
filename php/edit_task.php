<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = intval($_GET['id']);

// Fetch task information
$query = "SELECT task_name, status FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$stmt->bind_result($task_name, $status);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = htmlspecialchars(trim($_POST['task_name']));
    $status = htmlspecialchars(trim($_POST['status']));

    if (!empty($task_name) && !empty($status)) {
        $stmt = $conn->prepare("UPDATE tasks SET task_name = ?, status = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $task_name, $status, $task_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Η εργασία ενημερώθηκε επιτυχώς!";
            header("Location: dashboard.php"); // Redirect to dashboard after successful update
            exit();
        } else {
            $_SESSION['error'] = "Σφάλμα κατά την ενημέρωση της εργασίας.";
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
    <title>Επεξεργασία Εργασίας</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Επεξεργασία Εργασίας</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
    </header>
    <main>
        <?php if (isset($_SESSION['message'])) { echo "<p>{$_SESSION['message']}</p>"; unset($_SESSION['message']); } ?>
        <?php if (isset($_SESSION['error'])) { echo "<p>{$_SESSION['error']}</p>"; unset($_SESSION['error']); } ?>
        <form action="edit_task.php?id=<?php echo $task_id; ?>" method="post">
            <label for="task_name">Όνομα Εργασίας:</label>
            <input type="text" id="task_name" name="task_name" value="<?php echo htmlspecialchars($task_name); ?>" required><br>
            <label for="status">Κατάσταση:</label>
            <select id="status" name="status" required>
                <option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Σε Αναμονή</option>
                <option value="In Progress" <?php if ($status == 'In Progress') echo 'selected'; ?>>Σε Εξέλιξη</option>
                <option value="Completed" <?php if ($status == 'Completed') echo 'selected'; ?>>Ολοκληρωμένη</option>
            </select><br>
            <button type="submit">Ενημέρωση</button>
        </form>
    </main>
</body>
</html>



