<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nuvaira Foundation — A Breath of Hope</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
</head>
<body>
  <header class="site-header">
  <div class="container">
    <a href="index.html" class="logo">Nuvaira<span>Foundation</span></a>

    <!-- Hamburger Menu Button -->
    <button class="nav-toggle" aria-label="Toggle Navigation">☰</button>

    <!-- Navigation Links -->
    <nav class="nav">

      <a href="index.html">Home</a>
      <a href="about.html">About</a>
      <a href="projects.html">Projects</a>
      <a href="donate.html" class="btn">Donate</a>
      <a href="contact.html">Contact</a>
      <a href="career.html">Career</a>
      <a href="events.html">Events</a>
      <a href="volunteer.html">Volunteer</a>    
      <a href="gallery.html">Gallery</a>
<div class="nav-right">
        <a href="login.html">
            <i id="userIcon">👤</i>
        </a>
    </div>

    </nav>
  </div>
</header>


  <!-- Hero -->
  <section class="hero" style="background-image: url('images/hero-bg.jpg.webp');">
    <div class="overlay"></div>
    <div class="hero-inner container" data-aos="fade-up">
      <h1>A Breath of Hope</h1>
      <p>Together we bring fresh energy — restoring lives, renewing Earth.</p>
      <div class="hero-cta">
        <a href="donate.html" class="btn">Donate Now</a>
        <a href="#our-work" class="btn ghost">Our Work</a>
      </div>
    </div>
  </section>

  <!-- About preview -->
  <section class="preview container" id="our-work">
    <div class="grid two">
      <div data-aos="fade-right">
        <h2>Who We Are</h2>
        <p>Nuvaira Foundation works on community health, education, and environment projects — helping communities breathe new life through sustainable programs and local partnerships.</p>
        <img src="images\about.jpg" alt="project" width="800" height="600">
        <a href="about.html" class="images\about.jpg">Learn more about us →</a>
      </div>
      <div class="impact-cards" data-aos="fade-left">
        <div class="card counter-card">
          <h3 data-target="12000">0</h3>
          <p>Meals Served</p>
        </div>
        <div class="card counter-card">
          <h3 data-target="850">0</h3>
          <p>Volunteers</p>
        </div>
        <div class="card counter-card">
          <h3 data-target="7200">0</h3>
          <p>Lives Touched</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Projects preview -->
  <section class="projects container" data-aos="fade-up">
    <h2>Featured Projects</h2>
    <div class="grid three">
      <article class="project">
        <img src="images\project1.jpeg" alt="project">
        <h3>Clean Water Initiative</h3>
        <p>Installing water filters and teaching hygiene practices to rural communities.</p>
      </article>
      <article class="project">
        <img src="images/project2.jpeg" alt="project">
        <h3>Community Classrooms</h3>
        <p>Low-cost learning centers for children who lack access to regular schooling.</p>
      </article>
      <article class="project">
        <img src="images/project3.jpeg" alt="project">
        <h3>Green Villages</h3>
        <p>Tree-planting drives and sustainable livelihood trainings for farmers.</p>
      </article>
    </div>
    <p class="center"><a href="projects.html" class="link">See all projects →</a></p>
  </section>

  <!-- CTA banner -->
  <section class="cta-banner" data-aos="zoom-in">
    <div class="container">
      <h2>Ready to bring a fresh start?</h2>
      <a href="donate.html" class="btn">Support Nuvaira</a>
    </div>
  </section>
  <!-- Events Section -->
  <section class="events">
    <h2>Our Upcoming Events</h2>
    <div class="event-cards">
      <div class="event-card">
        <img src="images/health.jpg.jpg" alt="Health Camp">
        <h3>Rural Health Camp</h3>
        <p>Free health check-ups and awareness programs for villagers in remote areas.</p>
        <a href="events.html" class="btn-small">Know More</a>
      </div>
      <div class="event-card">
        <img src="images/plant.jpg.jpg" alt="Tree Plantation">
        <h3>Tree Plantation Drive</h3>
        <p>Join us in restoring green cover and promoting sustainable living.</p>
        <a href="events.html" class="btn-small">Join Now</a>
      </div>
    </div>
  </section>

  <!-- Volunteer Section -->
  <section class="volunteer">
    <h2>Be a Volunteer</h2>
    <p>Join hands with us to bring positive change in communities through your support and efforts.</p>
    <a href="volunteer.html" class="btn">Sign Up</a>
  </section>

  <!-- Gallery Section -->
  <section class="gallery-preview">
    <h2>Our Work in Action</h2>
    <div class="gallery-images">
      <img src="images/project2.jpeg" alt="Gallery Image 1">
      <img src="images/project1.jpeg" alt="Gallery Image 2">
      <img src="images/project3.jpeg" alt="Gallery Image 3">
    </div>
    <a href="gallery.html" class="btn">View Full Gallery</a>
  </section>

  <!-- Career Section -->
  <section class="career">
    <h2>Join Our Mission</h2>
    <p>Looking to contribute professionally? Join Nuvaira Foundation to make a difference.</p>
    <a href="career.html" class="btn">Explore Opportunities</a>
  </section>


  <footer class="site-footer">
    <div class="container grid two">
      <div>
        <h4>Nuvaira Foundation</h4>
        <p>A Breath of Hope — Renewing lives, restoring Earth.</p>
      </div>
      <div>
        <h4>Contact</h4>
        <p>email: info@nuvaira.org<br>phone: +91 90000 00000</p>
      </div>
    </div>
    <div class="container center small">&copy; <span id="year"></span> Nuvaira Foundation — All rights reserved</div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="script.js"></script>
  <script> AOS.init(); </script>

  <!-- Floating Chatbot -->
<div id="chatbot-icon" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; cursor: pointer;">
    <img src="images/chatbot.png" alt="Chatbot" width="60" height="60">
</div>

<iframe id="chatbot-frame" src="chatbot-float.html" 
        style="position: fixed; bottom: 90px; right: 20px; width: 350px; height: 500px; display: none; border: none; z-index: 9999; box-shadow: 0 0 15px rgba(0,0,0,0.3); border-radius: 10px;">
</iframe>

<script>
    const icon = document.getElementById('chatbot-icon');
    const iframe = document.getElementById('chatbot-frame');

    icon.addEventListener('click', () => {
        iframe.style.display = iframe.style.display === 'none' ? 'block' : 'none';
    });
</script>


</body>

</html>