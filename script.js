// Smooth scroll for internal links
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', function(e){
    const href = this.getAttribute('href');
    if (!href || href === '#') return;
    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({behavior: 'smooth', block: 'start'});
    }
  });
});

// Gallery modal interactions
const modal = document.getElementById('modal');
const modalImg = document.getElementById('modalImage');
const modalCaption = document.getElementById('modalCaption');
const modalClose = document.getElementById('modalClose');

document.querySelectorAll('.gallery-item img').forEach(img => {
  img.addEventListener('click', () => {
    modalImg.src = img.src || img.dataset.src;
    modalCaption.textContent = img.alt || '';
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
  });

  // keyboard accessible open
  img.parentElement.addEventListener('keydown', (e)=>{
    if(e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      img.click();
    }
  });
});

modalClose && modalClose.addEventListener('click', closeModal);

// close on overlay click or Esc
modal.addEventListener('click', (e) => {
  if (e.target === modal) closeModal();
});
document.addEventListener('keydown', (e)=>{
  if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
});

function closeModal(){
  modal.classList.remove('open');
  modal.setAttribute('aria-hidden', 'true');
  modalImg.src = '';
}

// Small entrance animations using IntersectionObserver
if ('IntersectionObserver' in window) {
  const obs = new IntersectionObserver((entries, o) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('reveal');
        o.unobserve(entry.target);
      }
    });
  }, {threshold: 0.12});
  document.querySelectorAll('.card, .gallery-item, .hero-inner').forEach(el => obs.observe(el));
}

// tiny parallax hover on hero image (decorative)
const heroImg = document.querySelector('.glass-hero');
if (heroImg) {
  heroImg.addEventListener('mousemove', (e) => {
    const r = heroImg.getBoundingClientRect();
    const x = (e.clientX - r.left) / r.width;
    const y = (e.clientY - r.top) / r.height;
    heroImg.style.transform = `translate3d(${(x-0.5)*6}px, ${(y-0.5)*6}px, 0)`;
  });
  heroImg.addEventListener('mouseleave', ()=> heroImg.style.transform = '');
}
