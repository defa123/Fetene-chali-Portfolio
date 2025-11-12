<?php
include "db.php";
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "public/html/image/";
    $target_file = $target_dir . basename($image);

    if ($title && $description && $image) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO projects (title, image, description) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $target_file, $description);
            if ($stmt->execute()) {
                $success = "Project added successfully!";
            } else {
                $error = "Database error: " . $conn->error;
            }
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Add Project</title>
<style>
body { font-family: Arial, sans-serif; background:#f9f9f9; padding:50px; }
form { max-width:500px; margin:auto; display:flex; flex-direction:column; gap:15px; }
input, textarea { padding:10px; font-size:1rem; }
button { padding:10px; background:#2e8b57; color:white; border:none; cursor:pointer; }
.success { color:green; }
.error { color:red; }
</style>
</head>
<body>
<h2>Add New Project</h2>
<?php if($success) echo "<p class='success'>$success</p>"; ?>
<?php if($error) echo "<p class='error'>$error</p>"; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Project Title" required>
    <textarea name="description" placeholder="Project Description" rows="5" required></textarea>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Add Project</button>
</form>
</body>
</html>
