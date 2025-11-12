// ===== Smooth Scroll for Navbar =====
document.querySelectorAll('nav ul li a').forEach(anchor => {
    anchor.addEventListener('click', function(e){
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        target.scrollIntoView({ behavior: 'smooth' });
    });
});

// ===== Scroll Reveal =====
const revealElements = document.querySelectorAll('.reveal');
const revealOnScroll = () => {
    const windowHeight = window.innerHeight;
    revealElements.forEach(el => {
        const elementTop = el.getBoundingClientRect().top;
        if(elementTop < windowHeight - 100){
            el.classList.add('active');
        }
    });
};
window.addEventListener('scroll', revealOnScroll);
revealOnScroll(); // initial call

// ===== Skills Bar Animation =====
const skillLevels = document.querySelectorAll('.skill-level');
window.addEventListener('scroll', () => {
    skillLevels.forEach(skill => {
        const parent = skill.parentElement.parentElement;
        const rect = parent.getBoundingClientRect();
        if(rect.top < window.innerHeight - 50){
            skill.style.width = skill.getAttribute('data-width');
        }
    });
});

// ===== Testimonials Auto Slide =====
let testimonialIndex = 0;
const testimonials = document.querySelectorAll('#testimonial-container .testimonial');

function showTestimonials(){
    testimonials.forEach((t, i) => t.classList.remove('active'));
    testimonials[testimonialIndex].classList.add('active');
    testimonialIndex = (testimonialIndex + 1) % testimonials.length;
}
setInterval(showTestimonials, 5000); // change every 5s

// ===== Photo Gallery Carousel =====
const galleryTrack = document.querySelector('.gallery-track');
const prevBtn = document.getElementById('gallery-prev');
const nextBtn = document.getElementById('gallery-next');
let galleryIndex = 0;

const galleryItems = document.querySelectorAll('.gallery-item');
const totalItems = galleryItems.length;

function updateGallery(){
    galleryTrack.style.transform = `translateX(-${galleryIndex * 100}%)`;
}

prevBtn.addEventListener('click', () => {
    galleryIndex = (galleryIndex - 1 + totalItems) % totalItems;
    updateGallery();
});
nextBtn.addEventListener('click', () => {
    galleryIndex = (galleryIndex + 1) % totalItems;
    updateGallery();
});

// Auto play gallery
setInterval(() => {
    galleryIndex = (galleryIndex + 1) % totalItems;
    updateGallery();
}, 4000);

// ===== Dark Mode Toggle =====
const darkBtn = document.querySelector('.darkBtn');
darkBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
});
function toggleMenu(){
    document.getElementById('menu').classList.toggle('show');
}
// Hamburger menu toggle (already added)
function toggleMenu(){
    document.getElementById('menu').classList.toggle('show');
}

// Dark mode toggle
document.getElementById("theme-toggle").addEventListener("click", function(){
    document.body.classList.toggle("dark");

    // change text button
    if(document.body.classList.contains("dark")){
        this.innerText = "Light Mode";
    }else{
        this.innerText = "Dark Mode";
    }
});
function toggleMenu(){
    const menu = document.getElementById('menu');
    menu.classList.toggle('show');
}
