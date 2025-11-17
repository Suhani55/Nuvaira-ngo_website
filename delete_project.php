<?php
require_once "db.php";

include 'db.php';

// Get the project ID safely
$id = $_GET['id'];

// Prepare the DELETE statement
$stmt = $conn->prepare("DELETE FROM projects WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the statement
if ($stmt->execute()) {
    echo "<script>alert('Project Deleted'); window.location='projects.php';</script>";
} else {
    echo "<script>alert('Error deleting project'); window.location='projects.php';</script>";
}
?>
