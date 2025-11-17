<?php
require_once "db.php";

session_start();
$db_file = __DIR__ . '/nuvaira_db.sqlite';

$conn = new PDO("sqlite:$db_file");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create projects table
$conn->exec("
    CREATE TABLE IF NOT EXISTS projects (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        image TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");

// --- Handle Create ---
if (isset($_POST['create'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    }
    $stmt = $conn->prepare("INSERT INTO projects (title, description, image) VALUES (:title,:description,:image)");
    $stmt->execute([':title'=>$title, ':description'=>$description, ':image'=>$image]);
    $_SESSION['msg']="Project created successfully!";
    header("Location: projects.php"); exit;
}

// --- Handle Delete ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("SELECT image FROM projects WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['image'] && file_exists("uploads/".$row['image'])) unlink("uploads/".$row['image']);
    $stmt = $conn->prepare("DELETE FROM projects WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $_SESSION['msg']="Project deleted successfully!";
    header("Location: projects.php"); exit;
}

// --- Handle Edit ---
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $stmt = $conn->prepare("SELECT image FROM projects WHERE id=:id");
    $stmt->execute([':id'=>$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $image = $row['image'];
    if(!empty($_FILES['image']['name'])) {
        if($image && file_exists("uploads/$image")) unlink("uploads/$image");
        $image = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    }
    $stmt = $conn->prepare("UPDATE projects SET title=:title, description=:description, image=:image WHERE id=:id");
    $stmt->execute([':title'=>$title, ':description'=>$description, ':image'=>$image, ':id'=>$id]);
    $_SESSION['msg']="Project updated successfully!";
    header("Location: projects.php"); exit;
}

// --- Fetch Projects ---
$projects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Projects Management</title>
<style>
body { font-family: Arial, sans-serif; }
table { width:100%; border-collapse:collapse; margin-top:20px;}
th,td { border:1px solid #ccc; padding:10px; text-align:left;}
img { max-width:100px; }
.msg { background:#d4edda; color:#155724; padding:10px; margin-bottom:20px;}
button { padding:5px 10px; margin:2px;}
/* Modal Styles */
.modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);}
.modal-content { background:#fff; margin:10% auto; padding:20px; width:50%; position:relative;}
.close { position:absolute; top:10px; right:15px; font-size:24px; cursor:pointer;}
</style>
</head>
<body>
<h1>Projects Management</h1>

<?php if(isset($_SESSION['msg'])): ?>
<div class="msg"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
<?php endif; ?>

<!-- Button to open Create Modal -->
<button onclick="openCreateModal()">+ Add New Project</button>

<!-- Projects Table -->
<h2>All Projects</h2>
<table>
<tr>
<th>ID</th><th>Title</th><th>Description</th><th>Image</th><th>Actions</th>
</tr>
<?php foreach($projects as $p): ?>
<tr>
<td><?= $p['id']; ?></td>
<td><?= htmlspecialchars($p['title']); ?></td>
<td><?= htmlspecialchars($p['description']); ?></td>
<td><?php if($p['image']): ?><img src="uploads/<?= $p['image']; ?>"><?php endif; ?></td>
<td>
<button onclick="openEditModal(<?= $p['id']; ?>,'<?= htmlspecialchars(addslashes($p['title'])); ?>','<?= htmlspecialchars(addslashes($p['description'])); ?>')">Edit</button>
<a href="?delete=<?= $p['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<!-- Create Modal -->
<div class="modal" id="createModal">
<div class="modal-content">
<span class="close" onclick="closeCreateModal()">&times;</span>
<h2>Create Project</h2>
<form action="" method="POST" enctype="multipart/form-data">
<input type="text" name="title" placeholder="Project Title" required><br><br>
<textarea name="description" placeholder="Project Description" required></textarea><br><br>
<input type="file" name="image"><br><br>
<button type="submit" name="create">Create Project</button>
</form>
</div>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
<div class="modal-content">
<span class="close" onclick="closeEditModal()">&times;</span>
<h2>Edit Project</h2>
<form action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="edit_id">
<input type="text" name="title" id="edit_title" required><br><br>
<textarea name="description" id="edit_description" required></textarea><br><br>
<input type="file" name="image"><br><br>
<button type="submit" name="edit">Save Changes</button>
</form>
</div>
</div>

<script>
function openCreateModal(){ document.getElementById('createModal').style.display='block'; }
function closeCreateModal(){ document.getElementById('createModal').style.display='none'; }

function openEditModal(id, title, desc){
    document.getElementById('edit_id').value=id;
    document.getElementById('edit_title').value=title;
    document.getElementById('edit_description').value=desc;
    document.getElementById('editModal').style.display='block';
}
function closeEditModal(){ document.getElementById('editModal').style.display='none'; }

// Close modal if clicked outside
window.onclick = function(e){
    if(e.target == document.getElementById('createModal')) closeCreateModal();
    if(e.target == document.getElementById('editModal')) closeEditModal();
}
</script>
</body>
</html>
