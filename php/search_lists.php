<?php
session_start();
require 'config.php';

// Έλεγχος αν ο χρήστης είναι συνδεδεδεμένος
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = htmlspecialchars(trim($_GET['search']));
    $query = "SELECT * FROM task_lists WHERE user_id = ? AND (list_name LIKE ?)";
    $stmt = $conn->prepare($query);
    $search_param = "%{$search}%";
    $stmt->bind_param("is", $user_id, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $search_results = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Αναζήτηση Λιστών Εργασιών</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <header>
        <h1>Αναζήτηση Λιστών Εργασιών</h1>
        <button onclick="toggleTheme()">Αλλαγή Θέματος</button>
        <nav>
            <ul>
                <li><a href="dashboard.php">Οι Λίστες Εργασιών Σας</a></li>
                <li><a href="edit_profile.php">Επεξεργασία Προφίλ</a></li>
                <li><a href="export_data.php">Εξαγωγή Δεδομένων</a></li>
                <li><a href="logout.php">Αποσύνδεση</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="search_lists.php" method="get">
            <label for="search">Αναζήτηση:</label>
            <input type="text" id="search" name="search" required>
            <button type="submit">Αναζήτηση</button>
        </form>
        <?php if (!empty($search_results)): ?>
            <h2>Αποτελέσματα Αναζήτησης</h2>
            <ul>
                <?php foreach ($search_results as $list): ?>
                    <li>
                        <?php echo htmlspecialchars($list['list_name']); ?>
                        <a href="view_list.php?id=<?php echo $list['id']; ?>">Προβολή</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])): ?>
            <p>Δεν βρέθηκαν αποτελέσματα.</p>
        <?php endif; ?>
        
    </main>
</body>
</html>



