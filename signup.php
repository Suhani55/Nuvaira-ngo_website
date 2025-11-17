<?php
require_once "db.php";

session_start();

// --- Connect to SQLite ---
$db_file = 'nuvaira_db.sqlite';
$conn = new PDO("sqlite:$db_file");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Create volunteers table if not exists ---
$conn->exec("CREATE TABLE IF NOT EXISTS volunteers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    phone TEXT,
    interest TEXT,
    message TEXT,
    password TEXT NOT NULL
)");

// --- Get form data ---
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$interest= trim($_POST['interest'] ?? '');
$message = trim($_POST['message'] ?? '');
$password= trim($_POST['password'] ?? '');

// --- Validation ---
if (!$name || !$email || !$password) {
    echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email.'); window.history.back();</script>";
    exit;
}

// --- Check if email already exists ---
$stmt = $conn->prepare("SELECT * FROM volunteers WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
if ($stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<script>alert('Email already registered. Please login.'); window.location='login.html';</script>";
    exit;
}

// --- Hash password ---
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// --- Insert user ---
$stmt = $conn->prepare("INSERT INTO volunteers (name,email,phone,interest,message,password) 
                        VALUES (:name,:email,:phone,:interest,:message,:password)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':interest', $interest);
$stmt->bindParam(':message', $message);
$stmt->bindParam(':password', $hashedPassword);
$stmt->execute();

// --- Login user immediately after signup ---
$_SESSION['user'] = $email;
echo "<script>alert('Signup successful! Welcome, $name'); window.location='dashboard.php';</script>";
exit;
?>
