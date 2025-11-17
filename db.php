<?php
// SQLite Database Path
$db_path = __DIR__ . "/nuvaira.db";

try {
    $conn = new PDO("sqlite:" . $db_path);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ============================
    // TABLE 1: Volunteers (Login/Signup)
    // ============================
    $conn->exec("
        CREATE TABLE IF NOT EXISTS volunteers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            phone TEXT,
            interest TEXT,
            message TEXT,
            password TEXT NOT NULL
        );
    ");

    // ============================
    // TABLE 2: Projects (CRUD system)
    // ============================
    $conn->exec("
        CREATE TABLE IF NOT EXISTS projects (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT NOT NULL,
            image TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>
