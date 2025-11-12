<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: admin_login.php");
    exit();
}
include "db.php";

$message = "";

// Add Testimonial
if(isset($_POST['add_testimonial'])){
    $client_name = $_POST['client_name'];
    $msg = $_POST['message'];

    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public html/image/" . $imageName);
    } else {
        $imageName = "";
    }

    $stmt = $conn->prepare("INSERT INTO tbl_testimonials (client_name, message, image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $client_name, $msg, $imageName);
    if($stmt->execute()){
        $message = "Testimonial added successfully!";
    }
    $stmt->close();
}

// Delete Testimonial
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $res = $conn->query("SELECT image FROM tbl_testimonials WHERE id=$id");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        if(!empty($row['image']) && file_exists("public html/image/".$row['image'])){
            unlink("public html/image/".$row['image']);
        }
    }
    $conn->query("DELETE FROM tbl_testimonials WHERE id=$id");
    header("Location: admin_testimonials.php");
    exit();
}

// Edit Testimonial
if(isset($_POST['edit_testimonial'])){
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    $msg = $_POST['message'];

    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $res = $conn->query("SELECT image FROM tbl_testimonials WHERE id=$id");
        $row = $res->fetch_assoc();
        if(!empty($row['image']) && file_exists("public html/image/".$row['image'])){
            unlink("public html/image/".$row['image']);
        }
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public html/image/" . $imageName);
        $stmt = $conn->prepare("UPDATE tbl_testimonials SET client_name=?, message=?, image=? WHERE id=?");
        $stmt->bind_param("sssi", $client_name, $msg, $imageName, $id);
    } else {
        $stmt = $conn->prepare("UPDATE tbl_testimonials SET client_name=?, message=? WHERE id=?");
        $stmt->bind_param("ssi", $client_name, $msg, $id);
    }

    if($stmt->execute()){
        $message = "Testimonial updated successfully!";
    }
    $stmt->close();
}

// Fetch all testimonials
$testimonials = [];
$res = $conn->query("SELECT * FROM tbl_testimonials ORDER BY created_at DESC");
if($res){
    while($row = $res->fetch_assoc()){
        $testimonials[] = $row;
    }
}

// For edit
$editTestimonial = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM tbl_testimonials WHERE id=$id");
    if($res->num_rows > 0){
        $editTestimonial = $res->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Testimonials</title>
<style>
body { font-family: Arial,sans-serif; background:#f4f4f4; }
.container { max-width:900px; margin:auto; padding:20px; }
h1 { color:#2e8b57; margin-bottom:20px; }
.message { color:green; font-weight:bold; margin-bottom:15px; }
form { background:white; padding:20px; border-radius:10px; margin-bottom:20px; }
input[type=text], textarea { width:100%; padding:10px; margin-bottom:10px; border-radius:5px; border:1px solid #ccc; }
button { padding:10px 20px; border:none; background:#2e8b57; color:white; border-radius:5px; cursor:pointer; }
button:hover { background:#246b45; }
table { width:100%; border-collapse: collapse; background:white; border-radius:10px; overflow:hidden; }
th, td { padding:10px; text-align:left; border-bottom:1px solid #ddd; }
img { width:80px; height:50px; object-fit:cover; border-radius:5px; }
a { text-decoration:none; color:#2e8b57; margin-right:10px; }
a:hover { text-decoration:underline; }
</style>
</head>
<body>
<div class="container">
<h1>Admin Panel - Testimonials</h1>

<?php if($message != ""): ?>
<div class="message"><?= $message; ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $editTestimonial['id'] ?? ''; ?>">
    <label>Client Name:</label>
    <input type="text" name="client_name" value="<?= $editTestimonial['client_name'] ?? ''; ?>" required>
    <label>Message:</label>
    <textarea name="message" required><?= $editTestimonial['message'] ?? ''; ?></textarea>
    <label>Image: <?php if($editTestimonial) echo "(leave blank to keep existing)"; ?></label>
    <input type="file" name="image">
    <?php if($editTestimonial): ?>
        <button type="submit" name="edit_testimonial">Update Testimonial</button>
        <a href="admin_testimonials.php"><button type="button">Cancel</button></a>
    <?php else: ?>
        <button type="submit" name="add_testimonial">Add Testimonial</button>
    <?php endif; ?>
</form>

<table>
<tr>
<th>ID</th>
<th>Client Name</th>
<th>Message</th>
<th>Image</th>
<th>Created At</th>
<th>Actions</th>
</tr>
<?php if(count($testimonials) == 0): ?>
<tr><td colspan="6">No testimonials found.</td></tr>
<?php else: ?>
<?php foreach($testimonials as $t): ?>
<tr>
<td><?= $t['id']; ?></td>
<td><?= htmlspecialchars($t['client_name']); ?></td>
<td><?= substr(htmlspecialchars($t['message']),0,50); ?>...</td>
<td><?php if($t['image'] != ""): ?><img src="public html/image/<?= $t['image']; ?>" alt="<?= htmlspecialchars($t['client_name']); ?>"><?php endif; ?></td>
<td><?= $t['created_at']; ?></td>
<td>
<a href="admin_testimonials.php?edit=<?= $t['id']; ?>">Edit</a>
<a href="admin_testimonials.php?delete=<?= $t['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>
</div>
</body>
</html>
