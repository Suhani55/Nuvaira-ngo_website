<?php
require_once "db.php";

session_start();

// --- Connect to SQLite ---
$db_file = 'nuvaira_db.sqlite';
$conn = new PDO("sqlite:$db_file");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Get form data ---
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// --- Validation ---
if (!$email || !$password) {
    echo "<script>alert('Please fill all fields.'); window.location='login.html';</script>";
    exit;
}

// --- Check user ---
$stmt = $conn->prepare("SELECT * FROM volunteers WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<script>alert('Email not found. Please signup.'); window.location='signup.html';</script>";
    exit;
}

// --- Verify password ---
if (!password_verify($password, $user['password'])) {
    echo "<script>alert('Incorrect password.'); window.location='login.html';</script>";
    exit;
}

// --- Login successful ---
$_SESSION['user'] = $user['email'];
echo "<script>alert('Login successful! Welcome back.'); window.location='dashboard.php';</script>";
exit;
?>
