/* ==========================================
   Nuvaira Foundation — Main JavaScript
   ========================================== */
   const API_KEY = "sk-...b9sA";

const response = await fetch("https://api.openai.com/v1/chat/completions", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "Authorization": "Bearer " + API_KEY
  },
  body: JSON.stringify({
    model: "gpt-4o-mini",
    messages: [{ role: "user", content: userMessage }]
  })
});


/* ---------- Smooth Scroll for Navigation ---------- */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      window.scrollTo({
        top: target.offsetTop - 60,
        behavior: 'smooth'
      });
    }
  });
});

/* ---------- Fade-In Animation on Scroll ---------- */
const faders = document.querySelectorAll('.fade-in');

const appearOptions = {
  threshold: 0.2,
  rootMargin: "0px 0px -50px 0px"
};

const appearOnScroll = new IntersectionObserver(function(entries, observer) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    entry.target.classList.add('visible');
    observer.unobserve(entry.target);
  });
}, appearOptions);

faders.forEach(fader => appearOnScroll.observe(fader));

/* ---------- Animated Counters (Impact Section) ---------- */
function animateCounter(id, target) {
  const el = document.getElementById(id);
  if (!el) return;
  let count = 0;
  const speed = 50; // smaller = faster
  const increment = Math.ceil(target / 100);

  const updateCounter = () => {
    if (count < target) {
      count += increment;
      el.textContent = count > target ? target : count;
      setTimeout(updateCounter, speed);
    }
  };
  updateCounter();
}

// Run when page fully loaded
window.addEventListener('load', () => {
  animateCounter('volunteers-count', 120);
  animateCounter('projects-count', 45);
  animateCounter('lives-count', 5000);
});

/* ---------- Contact Form Validation ---------- */
const contactForm = document.querySelector('.contact-form');

if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    const name = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const message = document.querySelector('textarea[name="message"]').value.trim();

    if (name === '' || email === '' || message === '') {
      e.preventDefault();
      alert("Please fill in all fields before submitting!");
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      e.preventDefault();
      alert("Please enter a valid email address!");
    }
  });
}

/* ---------- Mobile Navigation Toggle ---------- */
const menuBtn = document.querySelector('.nav-toggle');
const navMenu = document.querySelector('.nav');

if (menuBtn && navMenu) {
  menuBtn.addEventListener('click', () => {
    navMenu.classList.toggle('open');
    menuBtn.classList.toggle('active');
  });
}

document.getElementById("addProjectBtn").addEventListener("click", function() {
    alert("Create Project form will open here.");
});

document.querySelectorAll(".edit-btn").forEach(btn => {
    btn.addEventListener("click", function() {
        alert("Edit Project form will open here.");
    });
});

document.querySelectorAll(".delete-btn").forEach(btn => {
    btn.addEventListener("click", function() {
        if (confirm("Are you sure you want to delete this project?")) {
            alert("Project deleted.");
        }
    });
});

