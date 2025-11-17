<?php
require_once "db.php";
 include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>Add Project</title>
</head>
<body>

<h2>Add New Project</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Project Title" required><br><br>
    <textarea name="description" placeholder="Project Description" required></textarea><br><br>
    <input type="file" name="image" required><br><br>
    <button type="submit" name="add">Add Project</button>
</form>

</body>
</html>

<?php
if (isset($_POST['add'])) {

    $title = $_POST['title'];
    $desc = $_POST['description'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $path = "uploads/" . $image;

    if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        try {
            // Prepare the INSERT statement
            $stmt = $conn->prepare("INSERT INTO projects(title, description, image) VALUES (:title, :desc, :image)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':desc', $desc);
            $stmt->bindParam(':image', $image);

            // Execute the statement
            $stmt->execute();

            echo "<script>alert('Project Added'); window.location='projects.php';</script>";
        } catch(PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location='projects.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to upload image'); window.location='add_project.php';</script>";
    }
}
?>
