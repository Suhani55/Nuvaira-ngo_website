<?php include 'db.php'; ?>

<?php
require_once "db.php";

$id = $_GET['id'];

// Fetch project data
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Project</title>
</head>
<body>

<h2>Edit Project</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= $data['title'] ?>" required><br><br>
    
    <textarea name="description" required><?= $data['description'] ?></textarea><br><br>

    <p>Current Image:</p>
    <img src="uploads/<?= $data['image'] ?>" width="150"><br><br>

    <input type="file" name="image"><br><br>

    <button type="submit" name="update">Update Project</button>
</form>

</body>
</html>

<?php
if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $desc = $_POST['description'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
    } else {
        $image = $data['image'];
    }

    // Update query (SQLite)
    $update = $conn->prepare("
        UPDATE projects 
        SET title = ?, description = ?, image = ?
        WHERE id = ?
    ");

    $update->execute([$title, $desc, $image, $id]);

    echo "<script>alert('Project Updated'); window.location='projects.php';</script>";
}
?>
