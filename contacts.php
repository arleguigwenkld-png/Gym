<?php include __DIR__ . '/theme.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contact Us - Fitness Gym Management</title>
  <link rel="icon" type="image/png" href="logo.png">
  <style>
  <?php theme_css_vars($theme); ?>
    * { 
      box-sizing: border-box; 
      margin: 0; 
      padding: 0; 
      font-family: Arial, sans-serif; 
    }

    body {
      background: #f5f7fb;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

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
      color: #fff; /* ensure readable on dark header */
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

    /* ===== Main layout (Contact + Map) =====
       added extra top padding so cards appear lower on the page */
    main {
      flex: 1;
      display: flex;
      gap: 20px;
      padding: 60px 20px 20px; /* <-- increased top padding to "lower" the cards */
      align-items: flex-start;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* Contact card -> light gray background */
    .contact-card {
      flex: 1;
      min-width: 320px;
      max-width: 520px;
      background: #f2f2f2; /* light gray per request */
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      text-align: center;
    }

    .contact-card h2 {
      margin-bottom: 16px;
      color: #222;
    }

    .contact-info {
      display: flex;
      justify-content: space-between;
      gap: 12px;
    }

    .contact-info .info-item {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 10px;
    }

    .info-item img {
      width: 44px;
      margin-bottom: 8px;
    }

    .info-item p { 
      margin-top: 6px; 
      font-size: 14px; 
      color: #444; 
    }

    /* Map card stays white */
    .map-card {
      flex: 1;
      min-width: 320px;
      max-width: 520px;
      height: 300px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      background: #fff;
    }
    .map-card h2 {
      margin: 0;
      padding: 14px 18px;
      color: var(--primary);
      font-size: 18px;
      text-align: center;
      background: transparent;
    }
    .map-card iframe { 
      width: 100%; 
      height: 100%; 
      border: 0; 
      display:block; 
    }

    /* ===== Footer (RESTORED LOOK) ===== */
    footer {
      text-align: center;
      background: var(--secondary);
      color: white;
      padding: 18px 12px;
      margin-top: auto;
    }

    footer .social { 
      margin-top: 8px; 
    }

    footer .social a { 
      margin: 0 8px; 
      display:inline-block; 
    }

    footer .social img { 
      width: 26px; transition: 
      transform .2s; 
    }

    footer .social img:hover { 
      transform: scale(1.15); 
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
  color: #222;
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

    /* Responsive adjustments */
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

    @media (max-width: 720px) {
      header { 
        padding: 12px 14px; 
      }

      main { 
        padding: 30px 14px 14px; 
        gap: 14px;
        flex-direction: column;
      } 

      .map-card, .contact-card { 
        max-width: 100%; 
        min-width: 0; 
      }

      .contact-info {
        flex-direction: column;
        gap: 1rem;
      }

      .info-item {
        flex-direction: row;
        text-align: left;
        gap: 15px;
      }

      .info-item img {
        width: 36px;
        margin-bottom: 0;
      }

      .map-card {
        height: 250px;
      }
    }

    @media (max-width: 480px) {
      main {
        padding: 20px 10px 10px;
      }

      .contact-card {
        padding: 15px;
      }

      .contact-card h2 {
        font-size: 1.4rem;
      }

      .info-item {
        padding: 8px;
      }

      .info-item img {
        width: 32px;
      }

      .info-item p {
        font-size: 13px;
      }

      .map-card {
        height: 200px;
      }
    }
  </style>
</head>
<body>

  <!-- HEADER (restored style) -->
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
  <!-- Log In Button -->
    <div id="openJoin" class="join-btn">Join Us</div>
  </header>

  <!-- MAIN (contact info + map) -->
  <main>
    <section class="contact-card" aria-labelledby="contact-title">
      <h2 id="contact-title">Get in Touch</h2>

      <div class="contact-info">
        <div class="info-item">
          <img src="https://cdn-icons-png.flaticon.com/512/724/724664.png" alt="Phone icon">
          <strong>Phone</strong>
          <p>+63 912 345 6789</p>
        </div>

        <div class="info-item">
          <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email icon">
          <strong>Email</strong>
          <p>info@fitnessgym.com</p>
        </div>

        <div class="info-item">
          <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Location icon">
          <strong>Address</strong>
          <p>Blk E13 L3 Fatima Rd. Brgy. San Mateo Dbb D, Dasmariñas city, Cavite. 🇵🇭</p>
        </div>
      </div>
    </section>

    <section class="map-card" aria-label="Map">
      <h2>Find Us on Map</h2>
      <div class="map-container" style="width:100%;height:400px;border-radius:12px;overflow:hidden;">
  <iframe 
    src="https://www.google.com/maps?q=AIA+FITNESS+GYM+Area+D&hl=en&z=16&output=embed" 
    width="100%" 
    height="100%" 
    style="border:0;" 
    allowfullscreen 
    loading="lazy">
  </iframe>
</div>

  <!-- Join Modal -->
<div id="joinModal" class="join-modal">
  <div class="join-card">
    <span id="closeJoin" class="close-join">&times;</span>
    <h2>Join Fitness Gym</h2>
    <p>Start your fitness journey today! Fill out the form below.</p>
    <form>
      <input type="text" placeholder="Full Name" required>
      <input type="email" placeholder="Email Address" required>
      <input type="tel" placeholder="Contact Number" pattern="[0-9]{11}" maxlength="11" required>
      <select required>
        <option value="">Select Membership</option>
        <option value="daily">Daily - ₱150</option>
        <option value="monthly">1 Month - ₱1,500</option>
        <option value="3months">3 Months - ₱3,600</option>
        <option value="6months">6 Months - ₱6,000</option>
        <option value="yearly">12 Months - ₱9,000</option>
      </select>
          <div class="login-btn">Join Us</div>
    </form>
  </div>
</div>

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


    </section>
  </main>

  <!-- FOOTER (restored style) -->
  <footer>
    <p>&copy; 2025 Fitness Gym Management. All Rights Reserved.</p>
    <div class="social">
      <a href="https://facebook.com" target="_blank" rel="noopener">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
      </a>
      <a href="https://instagram.com" target="_blank" rel="noopener">
        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram">
      </a>
    </div>
  </footer>

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

</body>
</html>
