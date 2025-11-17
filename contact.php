<?php
require_once "db.php";

// ===============================
// Nuvaira Foundation — contact.php (SQLite Version, no subject)
// ===============================

// --- Database File ---
$db_file = __DIR__ . '/nuvaira_db.sqlite';

// --- Connect to SQLite Database ---
try {
    $conn = new PDO("sqlite:$db_file");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
    $conn->exec("
        CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (PDOException $e) {
    echo "<script>
        alert('Database connection failed: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
    exit;
}

// --- Get POST Data ---
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// --- Validate Inputs ---
$errors = [];
if ($name === '')    $errors[] = 'Name is required.';
if ($email === '')   $errors[] = 'Email is required.';
if ($message === '') $errors[] = 'Message is required.';
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';

if ($errors) {
    $errorMsg = implode("\n", $errors);
    echo "<script>alert('$errorMsg');window.history.back();</script>";
    exit;
}

// --- Insert Contact Message ---
try {
    $stmt = $conn->prepare("
        INSERT INTO contacts (name, email, message) 
        VALUES (:name, :email, :message)
    ");
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':message' => $message
    ]);

    $safeName = htmlspecialchars($name, ENT_QUOTES);
    echo "<script>
        alert('Thank you, $safeName! Your message has been sent successfully.');
        window.location.href='index.html';
    </script>";

} catch (PDOException $e) {
    echo "<script>
        alert('Error saving your message: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
}

// Close connection
$conn = null;
?>
