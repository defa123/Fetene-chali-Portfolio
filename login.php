<?php
session_start();
include "db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Hardcoded credentials
    $admin_user = 'admin';
    $admin_pass = 'Mauict@2025';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; display:flex; align-items:center; justify-content:center; height:100vh; }
    .login-box { background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); width:300px; }
    input { width:100%; padding:10px; margin-bottom:15px; border-radius:6px; border:1px solid #ccc; }
    button { width:100%; padding:10px; background:#27ae60; color:#fff; border:none; border-radius:6px; cursor:pointer; }
    .error { color:red; margin-bottom:15px; }
</style>
</head>
<body>
<div class="login-box">
    <h2>Admin Login</h2>
    <?php if($error) echo "<div class='error'>$error</div>"; ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
