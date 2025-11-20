<?php include __DIR__ . '/theme.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule - Fitness Gym Management</title>
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
      position: relative;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 40px;
      flex-wrap: wrap;
    }

    .highlight {
      color: #fff; /* keep brand text readable on dark header */
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

    /* Schedule Section */
    .schedule {
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
      flex: 1;
    }

    .schedule h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 26px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    table th, table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }

    table th {
      background: var(--secondary);
      color: #fff;
    }

    /* Schedule card styles (rendered when schedules.json is available) */
    .schedule-card {
      background: #fff;
      border-left: 4px solid var(--primary);
      padding: 12px;
      margin-bottom: 12px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.06);
      cursor: pointer;
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .schedule-card:hover { transform: translateY(-4px); box-shadow: 0 6px 12px rgba(0,0,0,0.12); }
    
    /* Days grid: multi-column colored vertical columns */
    .days-grid {
      display: grid;
      gap: 18px;
      grid-template-columns: repeat(5, 1fr); /* default wide layout */
      align-items: start;
    }

    .day-block {
      display: flex;
      flex-direction: column;
      border-radius: 8px;
      overflow: visible;
    }

  .day-header {
      color: #fff;
      padding: 12px 10px;
      text-align: center;
      font-weight: 700;
      border-radius: 6px;
      margin-bottom: 8px;
      text-transform: uppercase;
      font-size: 13px;
  /* keep existing site color scheme */
  background: var(--primary);
    }

    .day-cards {
      background: #fff;
      padding: 10px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.06);
      min-height: 120px;
    }

    /* Card inside a day column */
    .day-cards .schedule-card {
      margin-bottom: 12px;
      border-left-width: 6px;
      border-left-color: rgba(0,0,0,0.08);
    }

  /* Use site color for all day headers to preserve existing styling */

    /* Responsive breakpoints */
    @media (max-width: 1400px) { .days-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 1100px) { .days-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 800px) { .days-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .days-grid { grid-template-columns: 1fr; } }
    
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
    background: #BA830F;
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
    background: #ff9800;
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

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 350px;
      max-width: 90%;
      text-align: center;
      position: relative;
    }

    .modal-content h2 {
      margin-bottom: 20px;
      color: #222;
    }

    .modal-content input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .modal-content button {
      background: #BA830F;
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }

    .modal-content button:hover {
      background: #ff9800;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      cursor: pointer;
      color: #333;
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
      table th, table td {
        font-size: 14px;
        padding: 8px;
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
     <!-- Log In Button -->
    <div id="openJoin" class="join-btn">Join Us</div>
  </header>

  <!-- Schedule Section -->
  <section class="schedule">
    <h2>Weekly Class Schedule</h2>
    <?php
    // Attempt to load schedules.json generated by owner editor. If missing, fall back to the static table.
    $jsonPath = __DIR__ . '/schedules.json';
    $daysOrder = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    if (is_readable($jsonPath)) {
        $json = @file_get_contents($jsonPath);
        $data = $json ? json_decode($json, true) : null;
    } else {
        $data = null;
    }

    if (is_array($data) && isset($data['days'])):
    ?>
      <div id="weekly-schedule">
        <div class="days-grid">
        <?php foreach ($daysOrder as $day):
            $items = $data['days'][$day] ?? [];
        ?>
          <div class="day-block" id="day-<?php echo htmlspecialchars($day); ?>" data-day="<?php echo htmlspecialchars($day); ?>">
            <div class="day-header"><?php echo $day; ?></div>
            <div class="day-cards">
            <?php if (count($items) === 0): ?>
              <div class="alert alert-info">No schedules for this day</div>
            <?php else: ?>
              <?php foreach ($items as $it): ?>
                <div class="schedule-card" data-id="<?php echo htmlspecialchars($it['id']); ?>">
                  <div class="d-flex justify-content-between align-items-start">
                    <div>
                      <h6 class="mb-2"><?php echo htmlspecialchars($it['class_name']); ?></h6>
                      <div class="mb-2"><span class="time-badge"><?php echo date('g:i A', strtotime($it['start_time'])); ?> - <?php echo date('g:i A', strtotime($it['end_time'])); ?></span></div>
                      <div class="mb-1">
                        <?php if (!empty($it['trainer'])): ?>
                          <span class="trainer-badge me-2"><?php echo htmlspecialchars($it['trainer']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($it['capacity'])): ?>
                          <span class="capacity-badge me-2">Max: <?php echo (int)$it['capacity']; ?></span>
                        <?php endif; ?>
                        <?php if (!empty($it['location'])): ?>
                          <span class="badge bg-secondary"><?php echo htmlspecialchars($it['location']); ?></span>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    <?php else: ?>
      <!-- fallback static table when no schedules.json available -->
      <table>
        <tr>
          <th>Day</th>
          <th>Morning</th>
          <th>Evening</th>
        </tr>
        <tr>
          <td>Monday</td>
          <td>7:00 AM</td>
          <td>10:00 PM</td>
        </tr>
        <tr>
          <td>Tuesday</td>
          <td>7:00 AM</td>
          <td>10:00 PM</td>
        </tr>
        <tr>
          <td>Wednesday</td>
          <td>7:00 AM</td>
          <td>10:00 PM</td>
        </tr>
        <tr>
          <td>Thursday</td>
          <td>7:00 AM</td>
          <td>10:00 PM</td>
        </tr>
        <tr>
          <td>Friday</td>
          <td>7:00 AM</td>
          <td>10:00 PM</td>
        </tr>
        <tr>
          <td>Saturday</td>
          <td>7:00 AM</td>
          <td>10:00 PM</td>
        </tr>
        <tr>
          <td>Sunday</td>
          <td>7:00 AM</td>
          <td>8:00 PM</td>
        </tr>
      </table>
    <?php endif; ?>
  </section>

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

<!-- Schedule Detail Modal -->
<div id="scheduleDetailModal" class="join-modal">
  <div class="join-card" style="width:420px;max-width:95%;text-align:left;">
    <span id="closeScheduleDetail" class="close-join">&times;</span>
    <h2 id="sd_class_name" style="margin-bottom:6px;">Class Name</h2>
    <div style="color:#666;margin-bottom:8px;font-weight:700;" id="sd_time">Time</div>
    <div id="sd_trainer" style="margin-bottom:6px;"><strong>Trainer:</strong> —</div>
    <div id="sd_location" style="margin-bottom:6px;"><strong>Location:</strong> —</div>
    <div id="sd_capacity" style="margin-bottom:6px;"><strong>Capacity:</strong> —</div>
    <div style="text-align:right;margin-top:8px;">
      <button id="sd_close_btn" class="login-btn">Close</button>
    </div>
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

  <!-- Schedule Detail Script -->
  <script>
    (function(){
      let cachedSchedules = null;
      const modal = document.getElementById('scheduleDetailModal');
      const closeX = document.getElementById('closeScheduleDetail');
      const closeBtn = document.getElementById('sd_close_btn');

      function showModal() {
        modal.classList.add('active');
      }
      function hideModal() {
        modal.classList.remove('active');
      }

      closeX.addEventListener('click', hideModal);
      closeBtn.addEventListener('click', function(e){ e.preventDefault(); hideModal(); });
      modal.addEventListener('click', function(e){ if (e.target === modal) hideModal(); });

      async function loadSchedules() {
        if (cachedSchedules) return cachedSchedules;
        try {
          const res = await fetch('/pages/homepage/schedules.json?_=' + Date.now(), {cache:'no-store'});
          if (!res.ok) return null;
          const j = await res.json();
          cachedSchedules = j;
          return j;
        } catch (e) { return null; }
      }

      async function findItemById(id) {
        const j = await loadSchedules();
        if (!j || !j.days) return null;
        for (const d in j.days) {
          const arr = j.days[d];
          for (const it of arr) {
            if (it.id === id || String(it.schedule_id) === String(id).replace(/^s/, '')) return Object.assign({}, it, {day: d});
          }
        }
        return null;
      }

      // Event delegation: listen for clicks on schedule-card
      document.addEventListener('click', async function(e){
        const card = e.target.closest && e.target.closest('.schedule-card');
        if (!card) return;
        const id = card.getAttribute('data-id');
        if (!id) return;
        const item = await findItemById(id);
        if (!item) {
          // try to extract from DOM as fallback
          const title = card.querySelector('h6')?.innerText || 'Schedule';
          document.getElementById('sd_class_name').innerText = title;
          document.getElementById('sd_time').innerText = card.querySelector('.time-badge')?.innerText || '';
          document.getElementById('sd_trainer').innerHTML = '<strong>Trainer:</strong> ' + (card.querySelector('.trainer-badge')?.innerText || '—');
          document.getElementById('sd_location').innerHTML = '<strong>Location:</strong> ' + (card.querySelector('.badge')?.innerText || '—');
          document.getElementById('sd_capacity').innerHTML = '<strong>Capacity:</strong> ' + (card.querySelector('.capacity-badge')?.innerText || '—');
          showModal();
          return;
        }

        document.getElementById('sd_class_name').innerText = item.class_name || 'Schedule';
        const start = item.start_time ? new Date('1970-01-01T' + item.start_time) : null;
        const end = item.end_time ? new Date('1970-01-01T' + item.end_time) : null;
        const formatTime = t => {
          if (!t) return '';
          let hrs = t.getHours();
          let mins = t.getMinutes();
          const ampm = hrs >= 12 ? 'PM' : 'AM';
          hrs = hrs % 12 || 12;
          return hrs + ':' + String(mins).padStart(2,'0') + ' ' + ampm;
        };
        const timeStr = (item.start_time ? formatTime(start) : '') + (item.end_time ? ' - ' + formatTime(end) : '');
        document.getElementById('sd_time').innerText = (item.day ? item.day + ' · ' : '') + timeStr;
        document.getElementById('sd_trainer').innerHTML = '<strong>Trainer:</strong> ' + (item.trainer || '—');
        document.getElementById('sd_location').innerHTML = '<strong>Location:</strong> ' + (item.location || '—');
        document.getElementById('sd_capacity').innerHTML = '<strong>Capacity:</strong> ' + (item.capacity ? item.capacity : '—');
        showModal();
      });

      // Handle clicks on fallback table rows/cells: show modal for morning/evening cell click
      document.addEventListener('click', async function(e){
        const tr = e.target.closest && e.target.closest('.schedule table tr');
        if (!tr) return;
        // skip header row
        if (tr.querySelector('th')) return;
        // find clicked cell (td)
        const td = e.target.closest && e.target.closest('td');
        if (!td) return;
        const cells = Array.from(tr.children).filter(n => n.tagName.toLowerCase() === 'td');
        if (cells.length < 3) return; // expect Day / Morning / Evening
        const day = cells[0].innerText.trim();
        // determine which time cell was clicked: morning (1) or evening (2)
        const idx = cells.indexOf(td);
        let displayTime = '';
        if (idx === -1) {
          // clicked inside td but not direct child? fallback to morning
          displayTime = cells[1].innerText.trim();
        } else if (idx === 1 || idx === 2) {
          displayTime = cells[idx].innerText.trim();
        } else {
          // clicked other cell; ignore
          return;
        }

        // try to find a matching schedule item by day and display time
        async function parseDisplayTimeToHHMM(t) {
          if (!t) return null;
          const m = t.match(/(\d{1,2}):(\d{2})\s*(AM|PM)/i);
          if (!m) return null;
          let hh = parseInt(m[1],10);
          const mm = parseInt(m[2],10);
          const ampm = m[3].toUpperCase();
          if (ampm === 'PM' && hh < 12) hh += 12;
          if (ampm === 'AM' && hh === 12) hh = 0;
          return (hh<10? '0'+hh: ''+hh) + ':' + (mm<10? '0'+mm: ''+mm);
        }

        function toMinutes(hhmm) {
          const parts = hhmm.split(':');
          return parseInt(parts[0],10)*60 + parseInt(parts[1],10);
        }

        async function findByDayAndTime(day, displayTime) {
          const j = await loadSchedules();
          if (!j || !j.days) return null;
          const target = await parseDisplayTimeToHHMM(displayTime);
          if (!target) return null;
          const tMin = toMinutes(target);
          const arr = j.days[day] || [];
          for (const it of arr) {
            if (!it.start_time || !it.end_time) continue;
            const s = it.start_time;
            const e = it.end_time;
            try {
              const sMin = toMinutes(s);
              const eMin = toMinutes(e);
              if (sMin <= tMin && tMin <= eMin) return Object.assign({}, it, {day});
            } catch (ex) {
              // ignore parsing errors
            }
          }
          return null;
        }

        const matched = await findByDayAndTime(day, displayTime);
        if (matched) {
          document.getElementById('sd_class_name').innerText = matched.class_name || 'Schedule';
          const start = matched.start_time ? new Date('1970-01-01T' + matched.start_time) : null;
          const end = matched.end_time ? new Date('1970-01-01T' + matched.end_time) : null;
          const formatTime = t => {
            if (!t) return '';
            let hrs = t.getHours();
            let mins = t.getMinutes();
            const ampm = hrs >= 12 ? 'PM' : 'AM';
            hrs = hrs % 12 || 12;
            return hrs + ':' + String(mins).padStart(2,'0') + ' ' + ampm;
          };
          document.getElementById('sd_time').innerText = (matched.day ? matched.day + ' · ' : '') + (start ? formatTime(start) : '') + (end ? ' - ' + formatTime(end) : '');
          document.getElementById('sd_trainer').innerHTML = '<strong>Trainer:</strong> ' + (matched.trainer || '—');
          document.getElementById('sd_location').innerHTML = '<strong>Location:</strong> ' + (matched.location || '—');
          document.getElementById('sd_capacity').innerHTML = '<strong>Capacity:</strong> ' + (matched.capacity ? matched.capacity : '—');
          showModal();
          return;
        }

        // fallback: show the cell text
        document.getElementById('sd_class_name').innerText = displayTime + ' class';
        document.getElementById('sd_time').innerText = day + ' · ' + displayTime;
        document.getElementById('sd_trainer').innerHTML = '<strong>Trainer:</strong> —';
        document.getElementById('sd_location').innerHTML = '<strong>Location:</strong> —';
        document.getElementById('sd_capacity').innerHTML = '<strong>Capacity:</strong> —';
        showModal();
      });

      // Invalidate cache when schedule marker changes (optional)
      (function(){
        const markerUrl = location.origin + '/pages/homepage/schedule_last_update.txt';
        let last = null;
        async function check(){
          try {
            const r = await fetch(markerUrl + '?_=' + Date.now(), {cache:'no-store'});
            if (!r.ok) return;
            const t = (await r.text()).trim();
            if (last === null) { last = t; return; }
            if (t !== last) { last = t; cachedSchedules = null; }
          } catch(e){}
        }
        setInterval(check, 5000);
        check();
      })();
    })();
  </script>

      <!-- Realtime poller: reload page when schedule marker changes -->
      <script>
        (function(){
          const markerUrl = location.origin + '/pages/homepage/schedule_last_update.txt';
          let last = null;

          async function checkMarker(){
            try {
              const res = await fetch(markerUrl + '?_=' + Date.now(), {cache: 'no-store'});
              if (!res.ok) return; // ignore
              const text = (await res.text()).trim();
              if (last === null) {
                last = text;
                return;
              }
              if (text !== last) {
                // changed — reload to show updated schedule
                location.reload();
              }
            } catch (e) {
              // network or 404 — ignore silently
            }
          }

          // initial check and then poll every 5s
          checkMarker();
          setInterval(checkMarker, 5000);
        })();
      </script>

</body>
</html>

