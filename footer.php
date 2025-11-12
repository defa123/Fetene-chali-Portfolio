<?php
// Footer.php
?>
<footer>
    <div class="footer-container">
        <p>&copy; <?php echo date("Y"); ?> Fetene Chali. All Rights Reserved.</p>

        <!-- Footer Social Icons -->
    </div>
</footer>

<style>
footer {
    background:#2e7d32;
    color:#fff;
    padding:20px 0;
    text-align:center;
}

footer .social-links {
    display:flex;
    justify-content:center;
    gap:15px;
    list-style:none;
    margin-top:10px;
}

footer .social-links li a {
    color:#28a745;
    font-size:22px;
    transition:0.3s;
}

footer .social-links li a:hover {
    color:#1e7e34;
}

/* Floating social bar on right side */
.social-floating {
    position:fixed;
    top:40%;
    right:0;
    display:flex;
    flex-direction:column;
    gap:10px;
    z-index:999;
}

.social-floating a {
    display:flex;
    justify-content:center;
    align-items:center;
    width:40px;
    height:40px;
    background:#28a745;
    color:#fff;
    text-decoration:none;
    border-radius:50%;
    transition:0.3s;
}

.social-floating a:hover {
    background:#1e7e34;
}
</style>
<!-- Visitor Indicators in Footer -->
<!-- Floating social bar -->
<div class="social-floating">
    <a href="https://facebook.com/yourusername" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <a href="https://instagram.com/yourusername" target="_blank"><i class="fab fa-instagram"></i></a>
    <a href="https://wa.me/0913976770" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="https://imo.im/0913976770" target="_blank"><i class="fas fa-comment"></i></a>
    <a href="https://t.me/yourusername" target="_blank"><i class="fab fa-telegram-plane"></i></a>
</div>
