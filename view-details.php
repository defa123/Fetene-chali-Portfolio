<?php
include "db.php";

if(!isset($_GET['id'])){
    echo "Invalid Project";
    exit;
}

$id = intval($_GET['id']);

$res = $conn->query("SELECT * FROM tbl_projects WHERE id=$id LIMIT 1");
if($res && $res->num_rows>0){
    $project = $res->fetch_assoc();
}else{
    echo "Project not found";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $project['title']; ?></title>
<style>
    body{
        font-family: Arial, sans-serif;
        background:#f5f5f5;
        padding:40px;
    }
    .container{
        max-width:700px;
        margin:auto;
        background:white;
        padding:25px;
        border-radius:8px;
        box-shadow:0 0 10px rgba(0,0,0,0.2);
    }
    img{
        max-width:100%;
        border-radius:6px;
        margin-bottom:20px;
    }
</style>
</head>

<body>
<div class="container">
    <h2><?php echo $project['title']; ?></h2>
    <img src="public_html/image/<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>">
    <p><?php echo nl2br($project['description']); ?></p>
    <br>
    <a href="index.php"><< Back</a>
</div>
</body>
</html>
