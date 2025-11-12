<?php
include "db.php";
include "header.php";

// Get project ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0){
    echo "<p>Invalid project ID.</p>";
    include "footer.php";
    exit;
}

// Fetch project from DB
$stmt = $conn->prepare("SELECT * FROM tbl_projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$project = $res->fetch_assoc();

if(!$project){
    echo "<p>Project not found.</p>";
    include "footer.php";
    exit;
}
?>

<section id="project-details" style="max-width:800px;margin:50px auto;text-align:center;">
    <h2><?= htmlspecialchars($project['title']); ?></h2>
    
    <?php if(!empty($project['image'])): ?>
        <img src="public html/image/<?= htmlspecialchars($project['image']); ?>" alt="<?= htmlspecialchars($project['title']); ?>" style="max-width:100%;height:auto;margin-bottom:20px;">
    <?php endif; ?>
    
    <p><?= nl2br(htmlspecialchars($project['description'])); ?></p>
    
    <a href="index.php" style="display:inline-block;margin-top:20px;padding:10px 15px;background:#2e7d32;color:#fff;text-decoration:none;border-radius:5px;">Back to Projects</a>
</section>

<?php include "footer.php"; ?>
