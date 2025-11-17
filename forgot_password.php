<?php
require_once "db.php";

session_start();

// --- Connect to SQLite ---
$db_file = 'nuvaira_db.sqlite';
$conn = new PDO("sqlite:$db_file");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!$email) {
        echo "<script>alert('Enter your email.'); window.history.back();</script>";
        exit;
    }

    // Check user
    $stmt = $conn->prepare("SELECT * FROM volunteers WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
        exit;
    }

    // Generate temporary password
    $tempPass = bin2hex(random_bytes(4));
    $hashedTemp = password_hash($tempPass, PASSWORD_DEFAULT);

    // Update password in DB
    $stmt = $conn->prepare("UPDATE volunteers SET password = :password WHERE email = :email");
    $stmt->bindParam(':password', $hashedTemp);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "<script>alert('Your temporary password is: $tempPass'); window.location='login.html';</script>";
    exit;
}
?>

<form method="POST" style="text-align:center;margin-top:50px;">
    <h2>Reset Password</h2>
    Enter your email: <input type="email" name="email" required>
    <button type="submit">Reset</button>
</form>
