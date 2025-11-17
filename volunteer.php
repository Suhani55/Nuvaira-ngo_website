<?php
require_once "db.php";

// ===================================
// Nuvaira Foundation — volunteer.php (SQLite Version)
// ===================================

// Start session
session_start();

// Path to SQLite database
$db_path = __DIR__ . "/nuvaira.db";

try {
    // Connect to SQLite
    $conn = new PDO("sqlite:$db_path");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists
    $conn->exec("
        CREATE TABLE IF NOT EXISTS volunteers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            interest TEXT NOT NULL,
            message TEXT,
            password TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

// Get form data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$interest = trim($_POST['interest'] ?? '');
$message = trim($_POST['message'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validation
if ($name == '' || $email == '' || $phone == '' || $interest == '') {
    echo "<script>alert('Please fill all required fields.');window.history.back();</script>";
    exit;
}

// Insert data
$stmt = $conn->prepare("
    INSERT INTO volunteers (name, email, phone, interest, message, password)
    VALUES (:name, :email, :phone, :interest, :message, :password)
");

$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':phone' => $phone,
    ':interest' => $interest,
    ':message' => $message,
    ':password' => $password
]);

// Redirect
header("Location: thankyou.html");
exit;

?>
