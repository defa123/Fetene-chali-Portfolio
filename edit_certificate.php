<?php
include "db.php"; // Database connection

// Get certificate ID
if(!isset($_GET['id'])){
    header("Location: certificates_admin.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch certificate data
$stmt = $conn->prepare("SELECT * FROM tbl_certificates WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows==0){
    echo "Certificate not found";
    exit;
}
$cert = $res->fetch_assoc();
$stmt->close();

// Handle update
if(isset($_POST['update_cert'])){
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    // Handle image upload
    $image = $cert['image']; // existing
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        // delete old image
        if(!empty($cert['image'])) @unlink("public html/image/".$cert['image']);
        $imgName = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public html/image/".$imgName);
        $image = $imgName;
    }

    $stmt = $conn->prepare("UPDATE tbl_certificates SET title=?, issuer=?, year=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("sssssi",$title,$issuer,$year,$description,$image,$id);
    $stmt->execute();
    $stmt->close();

    header("Location: certificates_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Certificate</title>
<style>
body{ font-family:Arial,sans-serif; background:#f5f5f5; margin:0; padding:0; }
header{ background:#2e7d32; color:#fff; padding:20px; text-align:center; }
.container{ max-width:600px; margin:20px auto; padding:0 20px; }
form{ background:#fff; padding:20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); }
form input, form textarea{ width:100%; padding:8px; margin:5px 0 10px 0; border-radius:5px; border:1px solid #ccc; }
form button{ background:#2e7d32; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer; transition:0.3s; }
form button:hover{ background:#1b5e20; }
#img-preview{ max-width:100%; max-height:150px; display:block; margin-bottom:10px; border-radius:10px; }
a.back-btn{ display:inline-block; margin-bottom:10px; text-decoration:none; padding:5px 10px; background:#1976d2; color:#fff; border-radius:5px; }
a.back-btn:hover{ background:#0d47a1; }
</style>
</head>
<body>

<header>
    <h1>Edit Certificate</h1>
</header>

<div class="container">
    <a href="certificates_admin.php" class="back-btn">← Back to Admin Panel</a>
    <form method="POST" enctype="multipart/form-data">
        <h2>Edit Certificate</h2>
        <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($cert['title']); ?>" required>
        <input type="text" name="issuer" placeholder="Issuer" value="<?= htmlspecialchars($cert['issuer']); ?>" required>
        <input type="text" name="year" placeholder="Year" value="<?= htmlspecialchars($cert['year']); ?>" required>
        <textarea name="description" placeholder="Description" required><?= htmlspecialchars($cert['description']); ?></textarea>
        <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
        <?php if($cert['image']): ?>
            <img id="img-preview" src="public html/image/<?= $cert['image']; ?>" alt="Certificate Image">
        <?php else: ?>
            <img id="img-preview" style="display:none;">
        <?php endif; ?>
        <button type="submit" name="update_cert">Update Certificate</button>
    </form>
</div>

<script>
// Image preview
function previewImage(event){
    const preview = document.getElementById('img-preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}
</script>

</body>
</html>
