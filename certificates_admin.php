<?php
include "db.php"; // Database connection

// Handle Add Certificate
if(isset($_POST['add_cert'])){
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    
    // Handle image upload
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $imgName = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public html/image/".$imgName);
        $image = $imgName;
    }
    
    $stmt = $conn->prepare("INSERT INTO tbl_certificates (title, issuer, year, description, image) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss",$title,$issuer,$year,$description,$image);
    $stmt->execute();
    $stmt->close();
}

// Handle Delete Certificate
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    // delete image file
    $res = $conn->query("SELECT image FROM tbl_certificates WHERE id=$id");
    if($res && $row=$res->fetch_assoc() && !empty($row['image'])){
        @unlink("public html/image/".$row['image']);
    }
    $conn->query("DELETE FROM tbl_certificates WHERE id=$id");
    header("Location: certificates_admin.php");
    exit;
}

// Fetch Certificates
$certificates = [];
$res = $conn->query("SELECT * FROM tbl_certificates ORDER BY created_at DESC");
if($res){ while($row=$res->fetch_assoc()) $certificates[] = $row; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certificate Admin Panel</title>
<style>
body{ font-family:Arial,sans-serif; background:#f5f5f5; margin:0; padding:0; }
header{ background:#2e7d32; color:#fff; padding:20px; text-align:center; }
.container{ max-width:1200px; margin:20px auto; padding:0 20px; }
.card-container{ display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.cert-card{ background:#fff; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); width:280px; padding:15px; text-align:center; transition:transform 0.3s; position:relative; }
.cert-card:hover{ transform:translateY(-5px); }
.cert-card img{ max-width:100%; height:150px; object-fit:cover; border-radius:10px; margin-bottom:10px; }
.cert-card h3{ color:#2e7d32; margin:5px 0; }
.cert-card small{ color:#555; display:block; margin-bottom:5px; }
.cert-card p{ font-size:14px; color:#333; }
.actions{ display:flex; justify-content:center; gap:10px; margin-top:10px; }
.actions a, .actions button{ padding:5px 10px; border-radius:5px; text-decoration:none; border:none; cursor:pointer; transition:0.3s; }
.actions a{ background:#1976d2; color:#fff; }
.actions a:hover{ background:#0d47a1; }
.actions button{ background:#d32f2f; color:#fff; }
.actions button:hover{ background:#b71c1c; }

/* Form */
form{ background:#fff; padding:20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); margin-bottom:20px; }
form input, form textarea{ width:100%; padding:8px; margin:5px 0 10px 0; border-radius:5px; border:1px solid #ccc; }
form button{ background:#2e7d32; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer; transition:0.3s; }
form button:hover{ background:#1b5e20; }

/* Image preview */
#img-preview{ max-width:100%; max-height:150px; display:block; margin-bottom:10px; border-radius:10px; }
</style>
</head>
<body>

<header>
    <h1>Certificate Admin Panel</h1>
</header>

<div class="container">
    <!-- Add Certificate Form -->
    <form method="POST" enctype="multipart/form-data">
        <h2>Add New Certificate</h2>
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="issuer" placeholder="Issuer" required>
        <input type="text" name="year" placeholder="Year" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
        <img id="img-preview" style="display:none;">
        <button type="submit" name="add_cert">Add Certificate</button>
    </form>

    <!-- Certificates List -->
    <div class="card-container">
        <?php foreach($certificates as $cert): ?>
            <div class="cert-card">
                <?php if($cert['image']): ?>
                    <img src="public html/image/<?= $cert['image']; ?>" alt="<?= htmlspecialchars($cert['title']); ?>">
                <?php endif; ?>
                <h3><?= htmlspecialchars($cert['title']); ?></h3>
                <small><?= htmlspecialchars($cert['issuer']); ?> - <?= $cert['year']; ?></small>
                <p><?= htmlspecialchars($cert['description']); ?></p>
                <div class="actions">
                    <a href="edit_certificate.php?id=<?= $cert['id']; ?>">Edit</a>
                    <a href="certificates_admin.php?delete=<?= $cert['id']; ?>" onclick="return confirm('Are you sure to delete this certificate?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
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
