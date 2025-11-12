<?php
include "../db.php";  // connect to database
$success = $error = "";

// Add project
if(isset($_POST['add'])){
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $image = $_FILES['image']['name'];
    $target = "../public/html/image/" . basename($image);

    if($title && $description && $image){
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            $stmt = $conn->prepare("INSERT INTO projects (title,image,description) VALUES (?,?,?)");
            $stmt->bind_param("sss",$title,$target,$description);
            if($stmt->execute()){
                $success = "Project added successfully!";
            } else $error = $conn->error;
        } else $error = "Image upload failed!";
    } else $error = "All fields are required!";
}

// Delete project
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM projects WHERE id=$id");
}

// Fetch all projects for table display
$result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Projects</title>
<style>
body{font-family:Arial;padding:30px;background:#f0f0f0;}
form{display:flex;flex-direction:column;gap:10px;max-width:500px;}
input,textarea{padding:10px;}
button{padding:10px;background:#2e8b57;color:white;border:none;cursor:pointer;}
button:hover{background:#246b45;}
.success{color:green;}
.error{color:red;}
table{border-collapse:collapse;width:100%;margin-top:20px;}
th,td{border:1px solid #ccc;padding:10px;}
th{background:#2e8b57;color:white;}
</style>
</head>
<body>
<h1>Manage Projects</h1>
<?php if($success) echo "<p class='success'>$success</p>"; ?>
<?php if($error) echo "<p class='error'>$error</p>"; ?>

<h2>Add New Project</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Project Title" required>
    <textarea name="description" placeholder="Project Description" rows="4" required></textarea>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit" name="add">Add Project</button>
</form>

<h2>All Projects</h2>
<table>
<tr><th>ID</th><th>Title</th><th>Image</th><th>Description</th><th>Action</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['title'] ?></td>
<td><img src="../<?= $row['image'] ?>" width="100"></td>
<td><?= $row['description'] ?></td>
<td><a href="projects.php?delete=<?= $row['id'] ?>" style="color:red;">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
<?php
include "db.php";

$projects = [];
$result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $projects[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Projects - Fetene Chali</title>
<style>
body{font-family:Arial;padding:30px;background:#f9f9f9;}
h1{color:#2e8b57;text-align:center;margin-bottom:30px;}
.projects{display:flex;flex-wrap:wrap;gap:20px;justify-content:center;}
.project{background:white;padding:15px;border-radius:10px;width:300px;box-shadow:0 4px 8px rgba(0,0,0,0.1);text-align:center;}
.project img{width:100%;border-radius:10px;margin-bottom:10px;}
.project h3{color:#2e8b57;margin-bottom:10px;}
.project p{font-size:0.95em;}
a{display:inline-block;margin-top:10px;padding:5px 10px;background:#2e8b57;color:white;text-decoration:none;border-radius:5px;}
a:hover{background:#246b45;}
</style>
</head>
<body>

<h1>My Projects</h1>

<div class="projects">
<?php foreach($projects as $project): ?>
    <div class="project">
        <img src="<?= $project['image']; ?>" alt="<?= $project['title']; ?>">
        <h3><?= $project['title']; ?></h3>
        <p><?= substr($project['description'],0,100) ?>...</p>
        <a href="project_details.php?id=<?= $project['id'] ?>">View Details</a>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
