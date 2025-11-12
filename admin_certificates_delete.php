<?php
include "db.php";

$id = $_GET['id'];
// Optionally remove image from folder
$res = $conn->query("SELECT image FROM tbl_certificates WHERE id=$id");
$row = $res->fetch_assoc();
if($row['image']) unlink("public html/image/".$row['image']);

$conn->query("DELETE FROM tbl_certificates WHERE id=$id");
header("Location: admin_certificates.php");
