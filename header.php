<?php
// Header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>important links</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Navbar */
nav {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    background:#2e7d32;
    color:#fff;
    position:sticky;
    top:0;
    z-index:1000;
}

nav h1 { margin:0; font-size:1.5rem; }

nav ul { display:flex; list-style:none; gap:15px; margin:0; padding:0; }

nav ul li a {
    color:#fff;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

nav ul li a:hover { color:#c8e6c9; }

/* External links on right */
nav .external-links {
    display:flex;
    gap:12px;
    list-style:none;
    margin-left:auto;
}

nav .external-links li a {
    color:#28a745;
    font-weight:bold;
    text-decoration:none;
    transition:0.3s;
}

nav .external-links li a:hover { color:#1e7e34; }

nav .external-links .ext { font-size:0.75rem; margin-left:4px; opacity:0.7; }
nav .external-links li a:hover .ext { opacity:1; }

/* Menu button for mobile */
.menu-btn { background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer; }

@media(max-width:768px){
    nav ul#nav-links { display:none; flex-direction:column; background:#2e7d32; position:absolute; top:60px; right:0; width:200px; }
    nav ul#nav-links.show { display:flex; }
}
</style>
</head>
<body>
<nav>
    <h1>Important links</h>
    <button class="menu-btn" onclick="toggleMenu()">☰</button>

    <!-- Internal Menu -->
    <ul id="nav-links">
          </ul>

    <!-- External Links -->
    <ul class="external-links">
        <li><a href="https://www.meu.u.et/" target="_blank">Mattu University <span class="ext">↗</span></a></li>
        <li><a href="https://ejas.meu.edu.et/"get="_blank">Research Journal <span class="ext">↗</span></a></li>
        <li><a href="https://https://courses.meu.edu.et/=get="_blank">e-SHEE<span class="exit"></span></a></li>
    </ul>
</nav>

<script>
// Mobile menu toggle
function toggleMenu() {
    document.getElementById('nav-links').classList.toggle('show');
}
</script>
