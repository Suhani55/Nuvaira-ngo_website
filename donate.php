<?php
require_once "db.php";

// ===============================
// Nuvaira Foundation — donate.php (SQLite Version)
// ===============================

// --- Database File ---
$db_file = __DIR__ . '/nuvaira_db.sqlite';

// --- Connect to SQLite Database ---
try {
    $conn = new PDO("sqlite:$db_file");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create table if not exists
    $conn->exec("CREATE TABLE IF NOT EXISTS donations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        amount REAL NOT NULL,
        message TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    echo "<script>
        alert('Sorry, could not connect to the database: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
    exit;
}

// --- Get Form Data ---
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$amount  = trim($_POST['amount'] ?? '');
$message = trim($_POST['message'] ?? '');

// --- Validate Inputs ---
$errors = [];
if ($name === '') $errors[] = 'Name is required.';
if ($email === '') $errors[] = 'Email is required.';
if ($amount === '') $errors[] = 'Amount is required.';
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
if ($amount && (!is_numeric($amount) || $amount <= 0)) $errors[] = 'Please enter a valid donation amount.';

if ($errors) {
    $errorMsg = implode("\n", $errors);
    echo "<script>alert('$errorMsg');window.history.back();</script>";
    exit;
}

// --- Insert Donation ---
try {
    $stmt = $conn->prepare("INSERT INTO donations (name, email, amount, message) VALUES (:name, :email, :amount, :message)");
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':amount'  => $amount,
        ':message' => $message
    ]);

    $safeName   = htmlspecialchars($name, ENT_QUOTES);
    $safeAmount = htmlspecialchars($amount, ENT_QUOTES);
    echo "<script>
        alert('Thank you, $safeName! Your donation of ₹$safeAmount has been recorded.');
        window.location.href='donate.html';
    </script>";

} catch (PDOException $e) {
    echo "<script>
        alert('Sorry, something went wrong while recording your donation: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
}

// Close connection
$conn = null;
?>
