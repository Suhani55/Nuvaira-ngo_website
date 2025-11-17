<?php
try {
    $db = new PDO("sqlite:database.db");

    $query = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT UNIQUE,
        password TEXT
    )";

    $db->exec($query);

    echo "Table created successfully!";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
