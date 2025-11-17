<?php
try {
    // Create SQLite DB file
    $db = new PDO("sqlite:database.db");

    // Create users table
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE,
            password TEXT
        );
    ");

    // Insert a default user
    $email = "user@example.com";
    $password = password_hash("123456", PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT OR IGNORE INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $password]);

    echo "Database and user created successfully!";
} 
catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
