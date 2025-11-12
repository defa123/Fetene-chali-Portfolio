<?php
include "db.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tbl_certificates WHERE id=$id");
$cert = $result->fetch_assoc();

if(isset($_POST['update_certificate'])){
    $title = $_POST['title'];
    $issuer = $_POST['issuer'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    
    $image = $cert['image'];
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $image = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "public html/image/".$image);
    }

    $stmt = $conn->prepare("UPDATE tbl_certificates SET title=?, issuer=?, year=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssissi", $title, $issuer, $year, $description, $image, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_certificates.php");
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($cert['title']); ?>" required>
    <input type="text" name="issuer" value="<?= htmlspecialchars($cert['issuer']); ?>" required>
    <input type="number" name="year" value="<?= $cert['year']; ?>" required>
    <textarea name="description"><?= htmlspecialchars($cert['description']); ?></textarea>
    <input type="file" name="image" accept="image/*">
    <button type="submit" name="update_certificate">Update Certificate</button>
</form>
