<?php
include "db.php"; // Database connection
// Fetch projects
$projects = [];
$res = $conn->query("SELECT * FROM tbl_projects ORDER BY created_at DESC");
if($res){ while($row = $res->fetch_assoc()) $projects[] = $row; }

// Fetch experience
$experience = [];
$res = $conn->query("SELECT * FROM tbl_experience ORDER BY created_at DESC");
if($res){ while($row = $res->fetch_assoc()) $experience[] = $row; }

// Fetch certificates
$certificates = [];
$res = $conn->query("SELECT * FROM tbl_certificates ORDER BY created_at DESC");
if($res){ while($row = $res->fetch_assoc()) $certificates[] = $row; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fetene Chali - Portfolio</title>
<link rel="stylesheet" href="style.css">
<style>
/* Navbar */
nav { display:flex; justify-content:space-between; align-items:center; padding:15px 20px; background:#2e7d32; color:#fff; position:sticky; top:0; z-index:1000; }
nav h1 { margin:0; font-size:1.5rem; }
nav ul { display:flex; list-style:none; gap:15px; margin:0; padding:0; }
nav ul li a { color:#fff; text-decoration:none; font-weight:bold; transition:0.3s; }
nav ul li a:hover { color:#c8e6c9; }
.menu-btn, .darkBtn { background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer; }

/* Sections */
section { padding:50px 20px; max-width:1200px; margin:0 auto; }
section h2 { text-align:center; margin-bottom:30px; color:#2e7d32; }

/* About */
.profile-img { max-width:200px; border-radius:50%; display:block; margin:0 auto 20px; }

/* Skills */
.skills-container { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.skill { flex:1 1 200px; }
.skill-name { font-weight:bold; margin-bottom:5px; }
.skill-bar { background:#ddd; border-radius:5px; overflow:hidden; height:15px; }
.skill-level { height:100%; background:#2e7d32; width:0; transition:width 1s; }

/* Experience */
.exp-card { background:#f1f8e9; padding:20px; margin:10px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); }

/* Projects & Certificates */
.projects, .certs-container { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.project, .cert-card { background:#fff; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1); padding:20px; flex:1 1 280px; text-align:center; transition:transform 0.3s; }
.project:hover, .cert-card:hover { transform:translateY(-5px); }
.project img, .cert-card img { max-width:100%; height:150px; object-fit:cover; border-radius:10px; margin-bottom:10px; }
.project h3, .cert-card h3 { color:#2e7d32; margin:5px 0; }
.project p, .cert-card p { margin:5px 0; }
.cert-card small { color:#555; }

/* Actions */
.actions a { display:inline-block; padding:5px 10px; margin-top:10px; border-radius:5px; background:#2e7d32; color:#fff; text-decoration:none; transition:0.3s; }
.actions a:hover { background:#1b5e20; }

/* Gallery */
.gallery { position:relative; overflow:hidden; max-width:100%; }
.gallery-track { display:flex; transition:transform 0.5s ease; }
.gallery-item { min-width:100%; }
.gallery-item img { width:100%; display:block; }

.gallery-btn {
    position:absolute; top:50%; transform:translateY(-50%);
    background:rgba(46,125,50,0.7); color:#fff; border:none; padding:10px; font-size:2rem; cursor:pointer; border-radius:50%; z-index:10; transition:0.3s;
}
.gallery-btn:hover { background:rgba(46,125,50,1); }
.gallery-btn.prev { left:10px; }
.gallery-btn.next { right:10px; }

/* Testimonials */
.testimonial-container { position:relative; max-width:800px; margin:0 auto; }
.testimonial { display:none; text-align:center; padding:20px; background:#f1f8e9; border-radius:10px; }
.testimonial.active { display:block; }

/* Contact */
#contact p a { color:#2e7d32; text-decoration:none; }

/* Footer */
footer { text-align:center; padding:20px; background:#2e7d32; color:#fff; }

/* Responsive */
@media(max-width:768px){
    nav ul { display:none; flex-direction:column; background:#2e7d32; position:absolute; top:60px; right:0; width:200px; }
    nav ul.show { display:flex; }
}
</style>
</head>
<body>
<!-- Navbar -->
<nav>
    <h1>Fetene Chali</h1>
    <button class="menu-btn" onclick="toggleMenu()">☰</button>
    <ul id="nav-links">
        <li><a href="#about">About</a></li>
        <li><a href="#skills">Skills</a></li>
        <li><a href="#photo">Photos</a></li>
        <li><a href="#experience">Experience</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#certificates">Certificates</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
           </nav>
<!-- About -->
<section id="about">
    <h2>About Me</h2>
    <img src="public html/image/profile.jpg" alt="Fetene Chali" class="profile-img">
    <p>Hello!Hello! I am Fetene Chali, a dedicated web developer and content creator with ten years of extensive experience in the field.
     My expertise lies in designing and developing visually striking and highly functional digital platforms that not only fulfill user requirements but also significantly improve their engagement with technology.
     I am committed to creating seamless user experiences that blend aesthetics with practicality, ensuring that every interaction is both enjoyable and efficient. 
     My work reflects a deep understanding of the evolving digital landscape, allowing me to stay ahead of trends and deliver innovative solutions that resonate with users..</p>
</section>

<!-- Skills -->
<section id="skills">
    <h2>My Skills</h2>
    <div class="skills-container">
        <?php
        $skills = ['HTML'=>90,'CSS'=>85,'JavaScript'=>80,'PHP'=>75,'Python'=>75,'Machine Learning & NLP'=>75];
        foreach($skills as $name=>$percent): ?>
            <div class="skill">
                <div class="skill-name"><?= $name; ?></div>
                <div class="skill-bar"><div class="skill-level" style="width:<?= $percent; ?>%;"></div></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Photo Gallery -->
<section id="photo">
    <h2>Photos</h2>
    <div class="gallery" id="gallery">
        <button class="gallery-btn prev" id="gallery-prev" aria-label="Previous">‹</button>
        <div class="gallery-track">
            <div class="gallery-item"><img src="public html/image/add.jpg" alt="Photo 1"></div>
            <div class="gallery-item"><img src="public html/image/mas.jpg" alt="Photo 2"></div>
            <div class="gallery-item"><img src="public html/image/families.jpg" alt="Photo 3"></div>
            <div class="gallery-item"><img src="public html/image/wedding.jpg" alt="Photo 4"></div>
            <div class="gallery-item"><img src="public html/image/staff.jpg" alt="Photo 5"></div>
            <div class="gallery-item"><img src="public html/image/training.jpg" alt="Photo 5"></div>
            <div class="gallery-item"><img src="public html/image/ceremony.jpg" alt="Photo 5"></div>
        </div>
        <button class="gallery-btn next" id="gallery-next" aria-label="Next">›</button>
    </div>
</section>
<!-- Experience -->
<section id="experience">
    <h2>Experience</h2>
    <?php if(count($experience)==0): ?>
        <p>No experience found.</p>
    <?php else: ?>
        <?php foreach($experience as $exp): ?>
            <div class="exp-card">
                <h3><?= htmlspecialchars($exp['title']); ?> - <?= htmlspecialchars($exp['company']); ?></h3>
                <small><?= htmlspecialchars($exp['years']); ?> years</small>
                <p><?= htmlspecialchars($exp['description']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<!-- Projects -->
<section id="projects">
    <h2>Projects</h2>
    <div class="projects">
        <?php if(count($projects)==0): ?>
            <p>No projects found.</p>
        <?php else: ?>
            <?php foreach($projects as $project): ?>
                <div class="project">
                    <h3><?= htmlspecialchars($project['title']); ?></h3>
                    <p><?= substr(htmlspecialchars($project['description']),0,100); ?>...</p>
                    <a href="project_details.php?id=<?= $project['id']; ?>" class="actions">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Certificates -->
<section id="certificates">
    <h2>Certificates</h2>
    <div class="certs-container">
        <?php if(count($certificates)==0): ?>
            <p>No certificates found.</p>
        <?php else: ?>
            <?php foreach($certificates as $cert): ?>
                <div class="cert-card">
                    <?php if($cert['image']): ?>
                        <img src="public html/image/<?= $cert['image']; ?>" alt="<?= htmlspecialchars($cert['title']); ?>">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($cert['title']); ?></h3>
                    <small><?= htmlspecialchars($cert['issuer']); ?> - <?= $cert['year']; ?></small>
                    <p><?= htmlspecialchars($cert['description']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials">
    <h2>Testimonials</h2>
    <div class="testimonial-container" id="testimonial-container">
        <div class="testimonial active">
            <p>"Fetene stands out as an extraordinary developer, consistently delivering work of the highest caliber. His technical expertise is complemented by a keen understanding of project requirements, allowing him to create solutions that not only meet but often exceed expectations. 
            Fetene's attention to detail ensures that every aspect of his projects is meticulously crafted, resulting in robust and efficient applications.
            Furthermore, his ability to collaborate effectively with team members and stakeholders enhances the overall development process, fostering an environment of innovation and creativity. 
            In a rapidly evolving field, Fetene's commitment to continuous learning and adaptation positions him as a valuable asset to any team or organization.."</p>
            <h4>Haile Alemayehu</h4>
        </div>
        <div class="testimonial">
            <p>"Professional, creative, and reliable. Highly recommended!"</p>
            <h4>Abdissa Fikadu</h4>
        </div>
        <div class="testimonial">
            <p>"Great communicator and strong technical skills."</p>
            <h4>Sintayehu Bekele</h4>
        </div>
    </div>
</section>
<!-- Floating Social Media Bar -->

<!-- Contact -->
     <section id="contact">
    <h2>Contact Me</h2>
    <p>Name: Fetene Chali Regassa</p>
    <p>Phone: <a href="tel:0913976770">0913976770</a></p>
    <p>Email: <a href="mailto:fetene.chali@mau.edu.et">fetene.chali@mau.edu.et</a></p>
</section>
<!-- Footer -->

<!-- Scripts -->
<script>
// Mobile menu
function toggleMenu() { document.getElementById('nav-links').classList.toggle('show'); }

// Dark mode
function toggleDarkMode() { document.body.classList.toggle('dark-mode'); }

// Gallery
const galleryTrack = document.querySelector('.gallery-track');
const galleryItems = document.querySelectorAll('.gallery-item');
const prevBtn = document.getElementById('gallery-prev');
const nextBtn = document.getElementById('gallery-next');
let index = 0;
let autoplay = true;

function updateGallery() { galleryTrack.style.transform = `translateX(-${index*100}%)`; }
prevBtn.addEventListener('click',()=>{ index=(index-1+galleryItems.length)%galleryItems.length; updateGallery(); });
nextBtn.addEventListener('click',()=>{ index=(index+1)%galleryItems.length; updateGallery(); });

// Autoplay
setInterval(()=>{ if(autoplay){ index=(index+1)%galleryItems.length; updateGallery(); } },3000);

// Swipe
let startX=0,endX=0;
const gallery=document.getElementById('gallery');
gallery.addEventListener('touchstart',e=>{ startX=e.touches[0].clientX; });
gallery.addEventListener('touchmove',e=>{ endX=e.touches[0].clientX; });
gallery.addEventListener('touchend',()=>{ 
    if(startX-endX>50){ index=(index+1)%galleryItems.length; updateGallery(); } 
    else if(endX-startX>50){ index=(index-1+galleryItems.length)%galleryItems.length; updateGallery(); } 
});

// Testimonials
const testimonials=document.querySelectorAll('.testimonial');
let tIndex=0;
setInterval(()=>{ testimonials[tIndex].classList.remove('active'); tIndex=(tIndex+1)%testimonials.length; testimonials[tIndex].classList.add('active'); },4000);

// Animate skill bars
window.addEventListener('scroll',()=>{
    document.querySelectorAll('.skill-level').forEach(skill=>{
        const rect=skill.getBoundingClientRect();
        if(rect.top<window.innerHeight) skill.style.width=skill.dataset.width||skill.style.width;
    });
});
</script>
</body>
</html>
<?php include "header.php"; ?>
<?php include "footer.php"; ?>
