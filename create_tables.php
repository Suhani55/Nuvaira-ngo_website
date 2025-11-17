<?php
// Create SQLite DB and tables
$db_file = 'nuvaira_db.sqlite';

$conn = new PDO("sqlite:$db_file");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

echo "Database and tables created successfully!";
?>
