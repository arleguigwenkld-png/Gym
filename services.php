<?php include __DIR__ . '/theme.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services - Fitness Gym Management</title>
  <link rel="icon" type="image/png" href="logo.png">
  <style>
  <?php theme_css_vars($theme); ?>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f9f9f9;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Header */
    header {
      background: var(--secondary);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 20px;
      flex-wrap: wrap;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
    }

    .highlight {
      color: #fff; /* ensure readable on dark header */
      font-size: 30px;
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      width: 60px;
      margin-right: 15px;
    }

    .gym-name {
      font-size: 30px;
      font-weight: bold;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: bold;
      transition: 0.3s;
    }

    nav ul li a:hover {
      color: var(--accent);
    }

    /* Log In button */
    .login-btn {
      background: var(--primary);
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
      cursor: pointer;
    }

    .login-btn:hover {
      background: var(--accent);
    }

    /* Hamburger */
    .menu-toggle {
      display: none;
      flex-direction: column;
      cursor: pointer;
    }

    .menu-toggle span {
      height: 3px;
      width: 25px;
      background: white;
      margin: 4px 0;
      border-radius: 2px;
    }

    /* Services Section */
    .services {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin: 40px auto;
      max-width: 1000px;
    }
    .service-card {
      position: relative;
      width: 300px;
      height: 200px;
      overflow: hidden;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .service-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .service-card:hover img { transform: scale(1.05); }
    .service-desc {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      background: rgba(0,0,0,0.7);
      color: white;
      padding: 12px;
      font-size: 14px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    @media (hover: hover) and (pointer: fine) {
      .service-card:hover .service-desc { opacity: 1; }
    }

    /* Book Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.85);
      justify-content: center;
      align-items: center;
    }
    .modal-content.book {
      background: #fff;
      width: 90%;
      max-width: 700px;
      height: auto;
      padding: 20px;
      border-radius: 10px;
      position: relative;
    }
    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      cursor: pointer;
      color: #333;
    }

    /* Flip Book */
    .book-container {
      position: relative;
      width: 100%;
      height: 400px;
      perspective: 2000px;
      overflow: hidden;
      margin: 20px 0;
    }
    .page {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0; left: 0;
      background: #fafafa;
      border-radius: 8px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.3);
      backface-visibility: hidden;
      transform-style: preserve-3d;
      transition: transform 0.8s ease;
      padding: 15px;
      text-align: center;
    }
    .page img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
    }
    .page p { margin-top: 12px; font-size: 16px; }
    .page.flipped {
      transform: rotateY(-180deg);
      z-index: 0;
    }

    /* Navigation */
    .book-nav {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }
    .book-nav button {
      padding: 8px 16px;
      border: none;
      background: var(--secondary);
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
    }
    .book-nav button:hover { background: #555; }

    /* Footer */
    footer {
      background: var(--secondary);
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: auto;
    }

    footer .social {
      margin-top: 10px;
    }

    footer .social a {
      margin: 0 10px;
      display: inline-block;
    }

    footer .social img {
      width: 28px;
      transition: 0.3s;
    }

    footer .social img:hover {
      transform: scale(1.2);
    }

    /* Login Modal */
    #loginModal {
      display: none;
      position: fixed;
      z-index: 3000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      justify-content: center;
      align-items: center;
    }

    #loginModal .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      max-width: 90%;
      text-align: center;
      position: relative;
    }

    #loginModal input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    #loginModal button {
      background: var(--primary);
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }

    #loginModal button:hover {
      background: var(--accent);
    }

    /* Responsive Design */
    @media (max-width: 900px) {
      nav {
        display: none;
        width: 100%;
      }
      nav ul {
        flex-direction: column;
        background: #333;
        padding: 15px;
      }
      nav ul li {
        margin: 10px 0;
      }
      .menu-toggle {
        display: flex;
      }
      nav.active {
        display: block;
      }
      .header-left {
        width: 100%;
        justify-content: space-between;
      }
    }

    @media (max-width: 768px) {
      .services {
        flex-direction: column;
        align-items: center;
        padding: 20px 10px;
      }
      .service-card {
        width: 95%;
        max-width: 400px;
        height: 220px;
        margin-bottom: 15px;
      }
      .service-desc {
        opacity: 1; /* Always show description on mobile */
      }
      .modal-content.book {
        width: 95%;
        max-width: 600px;
        padding: 15px;
      }
      .book-container {
        height: 350px;
      }
    }

    @media (max-width: 480px) {
      .service-card {
        width: 100%;
        height: 200px;
      }
      .service-desc h3 {
        font-size: 16px;
      }
      .service-desc p {
        font-size: 12px;
      }
      .modal-content.book {
        padding: 10px;
      }
      .book-container {
        height: 300px;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="header-left">
      <div class="logo">
        <img src="logo.png" alt="Gym Logo">
        <span class="gym-name"><span class="highlight">Fitness</span> Gym Management</span>
      </div>
      <div class="menu-toggle" onclick="document.querySelector('nav').classList.toggle('active')">
        <span></span><span></span><span></span>
      </div>
      <nav>
        <ul>
         <li><a href="First Page.php">Home</a></li>
          <li><a href="about.php" class="active">About</a></li>
          <li><a href="schedule.php">Schedule</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="prices.php">Price</a></li>
          <li><a href="contacts.php">Contacts</a></li>
        </ul>
      </nav>
    </div>
    <div class="login-btn" onclick="openJoinModal()">Join Us</div>
  </header>

  <!-- Services Section -->
  <section class="services">
    <div class="service-card" onclick="openBook('equipment')">
      <img src="https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=800" alt="Gym Equipment">
      <div class="service-desc">
        <h3>Gym Equipment</h3>
        <p>Explore our modern machines and free weights designed for every workout style.</p>
      </div>
    </div>
    <div class="service-card" onclick="openBook('coaches')">
      <img src="https://images.unsplash.com/photo-1605296867304-46d5465a13f1?w=800" alt="Personal Coaches">
      <div class="service-desc">
        <h3>Personal Coaches</h3>
        <p>Meet our certified coaches who will guide you on your fitness journey.</p>
      </div>
    </div>
    <div class="service-card" onclick="openBook('events')">
      <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07c?w=800" alt="Gym Events">
      <div class="service-desc">
        <h3>Events</h3>
        <p>Join our exciting gym events, competitions, and community workouts!</p>
      </div>
    </div>
  </section>

  <!-- Book Modal -->
  <div id="bookModal" class="modal">
    <div class="modal-content book">
      <span class="close-btn" onclick="closeBook()">&times;</span>
      <h2 id="bookTitle">Gallery</h2>
      <div class="book-container" id="bookContainer"></div>
      <div class="book-nav">
        <button onclick="prevPage()">⬅ Prev</button>
        <button onclick="nextPage()">Next ➡</button>
      </div>
    </div>
  </div>

  <!-- Login Modal -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2>Welcome AIA Fitness Gym</h2>
      <input type="text" placeholder="Username">
      <input type="password" placeholder="Password">
      <button>Login</button>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Fitness Gym Management. All Rights Reserved.</p>
    <div class="social">
      <a href="https://www.facebook.com/profile.php?id=61559825401594" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
      </a>
      <a href="https://www.instagram.com/aiafitnessgym/" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram">
      </a>
    </div>
  </footer>

  <script>
    // Login modal
    function openModal() { document.getElementById("loginModal").style.display = "flex"; }
    function closeModal() { document.getElementById("loginModal").style.display = "none"; }
    window.onclick = function(e) {
      let modal = document.getElementById("loginModal");
      if (e.target == modal) closeModal();
    }

    // Flip Book
    let currentPage = 0;
    let currentGallery = [];

    function openBook(type) {
      const modal = document.getElementById("bookModal");
      const title = document.getElementById("bookTitle");
      const container = document.getElementById("bookContainer");

      // Galleries
      const galleries = {
        equipment: [
          { img: "https://images.unsplash.com/photo-1583454110551-21f2fa02b60c?w=800", text: "Treadmill – For cardio & endurance." },
          { img: "https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=800", text: "Dumbbells – For strength training." },
          { img: "https://images.unsplash.com/photo-1599058917212-d750089bc07c?w=800", text: "Bench Press – Build your chest strength." }
        ],
        coaches: [
          { img: "https://images.unsplash.com/photo-1605296867304-46d5465a13f1?w=800", text: "Coach Alex – Strength expert." },
          { img: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800", text: "Coach Mia – Nutrition & fitness." },
          { img: "https://images.unsplash.com/photo-1558611848-73f7eb4001a1?w=800", text: "Coach Ryan – Cardio trainer." }
        ],
        events: [
          { img: "https://images.unsplash.com/photo-1605296867304-46d5465a13f1?w=800", text: "Summer Fitness Challenge." },
          { img: "https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800", text: "Bodybuilding Competition." },
          { img: "https://images.unsplash.com/photo-1599058917212-d750089bc07c?w=800", text: "Community Workout Day." }
        ]
      };

      // Reset
      currentGallery = galleries[type];
      currentPage = 0;
      title.innerText = type.charAt(0).toUpperCase() + type.slice(1);
      container.innerHTML = "";

      // Build pages
      currentGallery.forEach((data, i) => {
        const page = document.createElement("div");
        page.className = "page";
        page.style.zIndex = currentGallery.length - i;
        page.innerHTML = `<img src="${data.img}" alt=""><p>${data.text}</p>`;
        container.appendChild(page);
      });

      modal.style.display = "flex";
    }

    function nextPage() {
      const pages = document.querySelectorAll(".page");
      if (currentPage < pages.length) {
        pages[currentPage].classList.add("flipped");
        currentPage++;
      } else {
        // Reset to cover if last page
        pages.forEach(p => p.classList.remove("flipped"));
        currentPage = 0;
      }
    }

    function prevPage() {
      const pages = document.querySelectorAll(".page");
      if (currentPage > 0) {
        currentPage--;
        pages[currentPage].classList.remove("flipped");
      } else {
        // Jump to last page if at cover
        currentPage = pages.length;
        pages.forEach(p => p.classList.add("flipped"));
      }
    }

    function closeBook() {
      document.getElementById("bookModal").style.display = "none";
      // Reset pages when closed
      document.querySelectorAll(".page").forEach(p => p.classList.remove("flipped"));
      currentPage = 0;
    }
  </script>

  <!-- Join Us Modal -->
  <div id="joinModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 3000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; width: 400px; max-width: 90%; position: relative;">
      <span onclick="closeJoinModal()" style="position: absolute; top: 15px; right: 20px; font-size: 28px; cursor: pointer; color: #666;">&times;</span>
      <h2 style="text-align: center; margin-bottom: 10px;">Join Fitness Gym</h2>
      <p style="text-align: center; color: #666; margin-bottom: 20px;">Start your fitness journey today! Fill out the form below.</p>
      <form action="../../registration.php" method="GET">
        <input type="text" name="name" placeholder="Full Name" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
        <input type="email" name="email" placeholder="Email Address" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
        <input type="tel" name="phone" placeholder="Contact Number" pattern="[0-9]{11}" maxlength="11" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
        <select name="membership" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
          <option value="">Select Membership</option>
          <option value="daily">Daily - ₱150</option>
          <option value="monthly">1 Month - ₱1,500</option>
          <option value="3months">3 Months - ₱3,600</option>
          <option value="6months">6 Months - ₱6,000</option>
          <option value="yearly">12 Months - ₱9,000</option>
        </select>
        <button type="submit" style="width: 100%; background: #BA830F; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px;">Join Us</button>
      </form>
    </div>
  </div>

  <script>
    function openJoinModal() {
      document.getElementById("joinModal").style.display = "flex";
    }
    
    function closeJoinModal() {
      document.getElementById("joinModal").style.display = "none";
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
      const modal = document.getElementById("joinModal");
      if (e.target === modal) {
        closeJoinModal();
      }
    });
  </script>

</body>
</html>
