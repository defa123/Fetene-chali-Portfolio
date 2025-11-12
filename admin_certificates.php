<?php
include "db.php";

// Handle Add Certificate
if(isset($_POST['add_certificate'])){
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public html/image/".$image);
    }

    $stmt = $conn->prepare("INSERT INTO tbl_certificates (title, issuer, year, description, image) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssiss", $title, $issuer, $year, $description, $image);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_certificates.php");
}

// Fetch all certificates
$certificates = [];
$res = $conn->query("SELECT * FROM tbl_certificates ORDER BY created_at DESC");
if($res){
    while($row = $res->fetch_assoc()) $certificates[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Certificates</title>
<link rel="stylesheet" href="style.css">
<style>
body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f9f9f9; }
.container { max-width: 1200px; margin: 80px auto 50px; padding: 0 20px; }
h1,h2 { color:#2e7d32; text-align:center; }

/* Add certificate form */
.add-form { 
    background:#fff; 
    padding:20px; 
    border-radius:10px; 
    box-shadow:0 3px 10px rgba(0,0,0,0.1); 
    margin-bottom:40px; 
    max-width:500px; 
    margin-left:auto; margin-right:auto; 
    display:flex; flex-direction:column; gap:10px; 
}
.add-form input, .add-form textarea, .add-form button { 
    padding:10px; font-size:1rem; border-radius:5px; border:1px solid #ccc; 
}
.add-form button { 
    background:#2e7d32; color:#fff; border:none; cursor:pointer; transition:0.3s; 
}
.add-form button:hover { background:#1b5e20; }

/* Certificates cards layout */
.certs-container { 
    display:flex; flex-wrap:wrap; gap:20px; justify-content:center; 
}
.cert-card { 
    background:#fff; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); 
    padding:20px; flex:1 1 280px; text-align:center; transition:transform 0.3s; 
}
.cert-card:hover { transform:translateY(-5px); }
.cert-card img { max-width:100%; height:150px; object-fit:cover; border-radius:10px; margin-bottom:10px; }
.cert-card h3 { margin:5px 0; color:#2e7d32; }
.cert-card p { margin:5px 0; }
.cert-card small { color:#555; }

.cert-card .actions { margin-top:10px; display:flex; justify-content:center; gap:10px; }
.cert-card .actions a { text-decoration:none; padding:5px 10px; background:#2e7d32; color:#fff; border-radius:5px; transition:0.3s; }
.cert-card .actions a:hover { background:#1b5e20; }

@media(max-width:768px){
    .cert-card { flex:1 1 100%; }
}
</style>
</head>
<body>

<div class="container">
    <h1>Certificates Dashboard</h1>

    <!-- Add Certificate Form -->
    <h2>Add New Certificate</h2>
    <form class="add-form" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Certificate Title" required>
        <input type="text" name="issuer" placeholder="Issuer" required>
        <input type="number" name="year" placeholder="Year" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit" name="add_certificate">Add Certificate</button>
    </form>

    <!-- Certificates List -->
    <h2>Existing Certificates</h2>
    <div class="certs-container">
        <?php foreach($certificates as $cert): ?>
            <div class="cert-card">
                <?php if($cert['image']): ?>
                    <img src="public html/image/<?= $cert['image']; ?>" alt="<?= htmlspecialchars($cert['title']); ?>">
                <?php endif; ?>
                <h3><?= htmlspecialchars($cert['title']); ?></h3>
                <small><?= htmlspecialchars($cert['issuer']); ?> - <?= $cert['year']; ?></small>
                <p><?= htmlspecialchars($cert['description']); ?></p>
                <div class="actions">
                    <a href="admin_certificates_edit.php?id=<?= $cert['id']; ?>">Edit</a>
                    <a href="admin_certificates_delete.php?id=<?= $cert['id']; ?>" onclick="return confirm('Delete this certificate?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
