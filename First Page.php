<?php include __DIR__ . '/theme.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fitness Gym Management</title>
  <link rel="icon" type="image/png" href="logo1.jpg">
  <style>
    <?php theme_css_vars($theme); ?>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #f9f9f9;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Header */
    header {
      background-color: var(--secondary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 20px;
      flex-wrap: wrap;
      position: relative;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
    }

    .highlight {
      color: var(--primary);
      font-size: 30px;
      font-weight: bold;
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
      background-color: var(--primary);
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
      cursor: pointer;
    }

    .login-btn:hover {
      background-color: var(--accent);
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

    /* Dashboard Section */
    .dashboard {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 40px 20px;
      max-width: 1100px;
      margin: auto;
      flex: 1;
      flex-wrap: wrap;
    }

    .dashboard-text {
      flex: 1;
      padding-right: 20px;
      min-width: 280px;
    }

    .dashboard-text h2 {
      font-size: 26px;
      margin-bottom: 15px;
      color: var(--secondary);
    }

    .dashboard-text p {
      font-size: 16px;
      line-height: 1.6;
    }

    /* Carousel */
    .carousel {
      position: relative;
      max-width: 600px;   /* smaller width */
      width: 100%;
      aspect-ratio: 16/9; /* force landscape ratio */
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
      margin: 20px auto;
    }

    .carousel-images {
      display: flex;
      transition: transform 0.5s ease-in-out;
      height: 100%;
    }

    .carousel-images img {
      width: 100%;
      height: 100%;
      object-fit: cover;  /* ensures landscape crop */
      flex-shrink: 0;
      border-radius: 10px;
    }

    

    /* Footer */
    footer {
      text-align: center;
      background: var(--secondary);
      color: white;
      padding: 20px;
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

/* Join Us Button */
.join-btn {
  background-color: var(--primary);
  color: white;
  padding: 10px 20px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;
  cursor: pointer;
}
.join-btn:hover {
  background-color: var(--accent);
}

/* Modal Background */
.join-modal {
  display: none; /* default hidden */
  position: fixed;
  z-index: 2000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  backdrop-filter: blur(5px);
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.join-modal.active {
  display: flex;
  opacity: 1;
}

.join-modal.fade-out {
  opacity: 0;
  transition: opacity 0.3s ease;
}

/* Join Card */
.join-card {
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(10px);
  padding: 30px;
  border-radius: 12px;
  width: 350px;
  max-width: 90%;
  text-align: center;
  box-shadow: 0px 4px 12px rgba(0,0,0,0.3);
  position: relative;
  animation: fadeIn 0.3s ease-in-out;
}

  .join-card h2 {
  color: var(--secondary);
  margin-bottom: 10px;
  font-size: 22px;
}

.join-card p {
  font-size: 14px;
  margin-bottom: 15px;
  color: #444;
}

  .join-card input,
  .join-card select {
   width: 100%;
   padding: 12px;
   margin: 8px 0;
   border-radius: 6px;
   border: 1px solid #ccc;
   font-size: 14px;
}

  .join-card button {
    width: 100%;
    background: var(--primary);
    color: white;
    padding: 12px;
    border-radius: 6px;
    border: none;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}
  .join-card button:hover {
    background: var(--accent);
}

/* Close Button */
  .close-join {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 22px;
    cursor: pointer;
    color: #333;
    font-weight: bold;
}

/* Fade Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
}

    /* Chatbot Styles */
    .chatbot-toggle {
      position: fixed;
      bottom: 20px;
      right: 20px;
  background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      cursor: pointer;
      font-size: 24px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.3);
      transition: 0.3s;
      z-index: 2000;
    }

    .chatbot-toggle:hover {
      background: var(--accent);
    }

    .chatbot-box {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      max-height: 400px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.3);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 2000;
    }

    .chatbot-header {
      background: var(--primary);
      color: #fff;
      padding: 10px;
      text-align: center;
      font-weight: bold;
    }

    .chatbot-messages {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      font-size: 14px;
      display: flex;
      flex-direction: column;
    }

    .message {
      margin: 8px 0;
      padding: 8px 12px;
      border-radius: 10px;
      max-width: 80%;
      line-height: 1.4;
    }

    .bot {
      background: #eee;
      align-self: flex-start;
    }

    .user {
      background: var(--primary);
      color: #fff;
      align-self: flex-end;
    }

    .chatbot-options {
      display: flex;
      flex-wrap: wrap;
      padding: 10px;
      gap: 5px;
    }

    .chatbot-options button {
      flex: 1;
      background: var(--secondary);
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 8px;
      cursor: pointer;
      font-size: 12px;
      transition: 0.3s;
    }

    .chatbot-options button:hover {
      background: var(--accent);
    }
    .chatbot-messages a img {
    width: 22px;
    height: 22px;
    margin: 5px 8px 0 0;
    vertical-align: middle;
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

    @media (max-width: 600px) {
      .gym-name {
        font-size: 20px;
      }
      .highlight {
        font-size: 22px;
      }
      .dashboard {
        flex-direction: column;
        text-align: center;
      }
      .dashboard-text {
        padding-right: 0;
      }
    }

    /* Responsive */
    @media (max-width: 600px) {
      .carousel {
        max-width: 100%;
        aspect-ratio: 16/9;
      }
    } 

    
  </style>
  <?php if ($preview === 1): ?>
  <!-- Preview mode: CSS variables already overridden above via $theme values -->
  <?php endif; ?>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="header-left">
      <div class="logo">
        <img src="logo.png" alt="Gym Logo">
        <span class="gym-name">Fitness Gym Management</span></span>
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
    <!-- Log In Button -->
    <div id="openJoin" class="join-btn">Join Us</div>
  </header>

  <!-- Dashboard Section -->
  <section class="dashboard">
    <div class="dashboard-text">
      <h2>Welcome to Fitness Gym Management</h2>
      <p>
        At Fitness Gym Management, we provide state-of-the-art equipment, 
        professional trainers, and customized workout plans to help you 
        achieve your fitness goals. Whether you're into strength training, 
        cardio, or group classes, our gym is designed for everyone.  
        Start your fitness journey with us today!
      </p>
    </div>

    <!-- Image Carousel -->
    <div class="carousel">
      
      <div class="carousel-images">
        <img src="https://images.pexels.com/photos/1552249/pexels-photo-1552249.jpeg" alt="Gym 1">
        <img src="https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg" alt="Gym 2">
        <img src="https://images.pexels.com/photos/3253498/pexels-photo-3253498.jpeg" alt="Gym 3">
        <img src="https://images.pexels.com/photos/6453392/pexels-photo-6453392.jpeg" alt="Gym 4">
        <img src="https://images.pexels.com/photos/4753891/pexels-photo-4753891.jpeg" alt="Gym 5">
      </div>
    </div>
  </section>

  <!-- Join Modal -->
<div id="joinModal" class="join-modal">
  <div class="join-card">
    <span id="closeJoin" class="close-join">&times;</span>
    <h2>Join Fitness Gym</h2>
    <p>Start your fitness journey today! Fill out the form below.</p>
    <form id="joinForm">
      <input id="fullName" name="full_name" type="text" placeholder="Full Name" required>
      <input id="email" name="email" type="email" placeholder="Email Address">
      <input id="contactNumber" name="contact_number" type="tel" placeholder="Contact Number" pattern="[0-9]{10,11}" maxlength="11" required>
      <select id="membership" name="membership" required>
        <option value="">Select Membership</option>
        <option value="daily">Daily - ₱150</option>
        <option value="1 month">1 Month - ₱1,500</option>
        <option value="3 months">3 Months - ₱3,600</option>
        <option value="6 months">6 Months - ₱6,000</option>
        <option value="12 months">12 Months - ₱9,000</option>
      </select>
      <div id="joinStatus" style="display:none;margin:8px 0;font-size:14px;"></div>
      <button type="submit" class="login-btn">Join Us</button>
    </form>
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

  <!-- Chatbot -->
<button class="chatbot-toggle" onclick="toggleChat()">💬</button>
<div class="chatbot-box" id="chatbot">
  <div class="chatbot-header">AI Assistant</div>
  <div class="chatbot-messages" id="chat-messages">
    <div class="message bot">Hello! How can I help you today?</div>
  </div>
  <div class="chatbot-options">
    <button onclick="sendChoice('What are today\'s gym hours?')">Gym Hours</button>
    <button onclick="sendChoice('Can I book a personal trainer?')">Book PT</button>
    <button onclick="sendChoice('Where is your gym located?')">Location</button>
    <button onclick="sendChoice('How can I contact you?')">Contact</button>
  </div>
</div>

<!-- Slide Images -->
<script>
  let currentIndex = 0;
  function showSlide(index) {
    const slides = document.querySelector(".carousel-images");
    const totalSlides = slides.children.length;
    if (index >= totalSlides) currentIndex = 0;
    else if (index < 0) currentIndex = totalSlides - 1;
    else currentIndex = index;
    slides.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  // Auto-slide every 5 seconds
  setInterval(() => {
    currentIndex++;
    showSlide(currentIndex);
  }, 2000);

  // Start first slide
  showSlide(currentIndex);
</script>


<!-- Chatbot Script -->
<script>
function toggleChat() {
  const chatbot = document.getElementById("chatbot");
  const messages = document.getElementById("chat-messages");

  // If opening chatbot -> reset conversation
  if (chatbot.style.display !== "flex") {
    messages.innerHTML = `<div class="message bot">Hello! How can I help you today?</div>`;
    chatbot.style.display = "flex";
  } else {
    // If closing chatbot
    chatbot.style.display = "none";
  }
}

function sendChoice(choice) {
  const messages = document.getElementById("chat-messages");

  // User message
  let userMsg = document.createElement("div");
  userMsg.className = "message user";
  userMsg.innerText = choice;
  messages.appendChild(userMsg);

  // Bot response
  let botMsg = document.createElement("div");
  botMsg.className = "message bot";

  if (choice.toLowerCase().includes("hours")) {
    botMsg.innerText = "We’re open from 6 AM to 10 PM daily!";
  } else if (choice.toLowerCase().includes("trainer")) {
    botMsg.innerText = "Yes! You can book a personal trainer from your profile or at the front desk.";
  } else if (choice.toLowerCase().includes("location") || choice.toLowerCase().includes("located")) {
    botMsg.innerText = "It's located in Blk E13 L3 Fatima Rd. Brgy. San Mateo Dbb D, Dasmariñas City, Cavite. 🇵🇭";
  } else if (choice.toLowerCase().includes("contact")) {
    botMsg.innerHTML = `
      📞 Contact Number: <b>+63 912 345 6789</b><br>
      📧 Email: <b>fitnessgym@gmail.com</b><br><br>
      💬 Messenger: 
      <a href="https://m.me/yourpage" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Messenger"> Chat with us
      </a><br>
      📸 Instagram: 
      <a href="https://instagram.com/aiafitnessgym" target="_blank">
        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram"> @aiafitnessgym
      </a>
    `;
  } else {
    botMsg.innerText = "I’m here to assist you!";
  }

  setTimeout(() => {
    messages.appendChild(botMsg);
    messages.scrollTop = messages.scrollHeight;
  }, 600);
}
</script>


  <!-- Join Modal Script -->
   <script>
    const openBtn = document.getElementById("openJoin");
    const modal = document.getElementById("joinModal");
    const closeBtn = document.getElementById("closeJoin");
    const joinForm = document.getElementById("joinForm");
    const successMsg = document.getElementById("successMsg");

    // Open modal
    openBtn.addEventListener("click", () => {
      modal.classList.add("active");
    });

    // Close modal
    closeBtn.addEventListener("click", () => {
      modal.classList.add("fade-out");
      setTimeout(() => {
        modal.classList.remove("active", "fade-out");
      }, 300);
    });

    // Close when clicking outside
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("fade-out");
        setTimeout(() => {
          modal.classList.remove("active", "fade-out");
        }, 300);
      }
    });
  </script>
  
  <script>
    // Join form submission via AJAX
    const joinFormEl = document.getElementById('joinForm');
    const joinStatusEl = document.getElementById('joinStatus');

    if (joinFormEl) {
      joinFormEl.addEventListener('submit', function(e) {
        e.preventDefault();
        joinStatusEl.style.display = 'none';
        joinStatusEl.textContent = '';

        const formData = new FormData(joinFormEl);

        // Basic client-side validation
        const fullName = formData.get('full_name') || '';
        const contact = formData.get('contact_number') || '';
        const membership = formData.get('membership') || '';
        if (!fullName.trim() || !contact.trim() || !membership.trim()) {
          joinStatusEl.style.display = 'block';
          joinStatusEl.style.color = 'red';
          joinStatusEl.textContent = 'Please fill in required fields.';
          return;
        }

        joinStatusEl.style.display = 'block';
        joinStatusEl.style.color = '#333';
        joinStatusEl.textContent = 'Sending...';

        fetch('join_handler.php', {
          method: 'POST',
          body: formData
        }).then(r => r.json()).then(json => {
          if (json.success) {
            joinStatusEl.style.color = 'green';
            joinStatusEl.textContent = json.message || 'Request submitted.';
            // Close modal after short delay
            setTimeout(() => {
              modal.classList.add('fade-out');
              setTimeout(() => {
                modal.classList.remove('active', 'fade-out');
              }, 300);
            }, 1500);
            // Optionally clear form
            joinFormEl.reset();
          } else {
            joinStatusEl.style.color = 'red';
            joinStatusEl.textContent = json.message || 'Submission failed.';
          }
        }).catch(err => {
          joinStatusEl.style.display = 'block';
          joinStatusEl.style.color = 'red';
          joinStatusEl.textContent = 'Network error. Please try again.';
          console.error('Join submit error', err);
        });
      });
    }
  </script>
  

</body>
</html>
