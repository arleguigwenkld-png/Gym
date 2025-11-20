<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif; 
      background-color: #f9f9f9;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Sidebar */
    header {
      background-color: #222;
      color: white;
      width: 250px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 20px 15px;
      position: fixed;
      top: 0;
      left: 0;
      align-items: center;
      transition: transform 0.3s ease-in-out;
      z-index: 200;
    }
    header.hidden { transform: translateX(-100%); }

    .close-btn {
      display: none;
      align-self: flex-end;
      background: none;
      border: none;
      font-size: 24px;
      color: white;
      cursor: pointer;
      margin-bottom: 15px;
    }

    /* Logo at Title */
    .logo {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 30px;
    }
    .logo img { width: 80px; margin-bottom: 12px; }
    .gym-name {
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      line-height: 1.4;
    }
    .highlight { color: #BA830F; }

    /* Navigation */
    nav ul {
      list-style: none;
      padding: 0;
      margin: 0 0 20px 0;
      display: flex;
      flex-direction: column;
      gap: 15px;
      width: 100%;
    }
    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: bold;
      transition: 0.3s;
      display: block;
      padding: 8px 12px;
      border-radius: 6px;
    }
    nav ul li a:hover { background-color: #BA830F; }

    /* Logout button */
    .logout-btn {
      background-color: #BA830F;
      color: white;
      padding: 10px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      text-align: center;
      transition: 0.3s;
      width: 100%;
    }
    .logout-btn:hover { background-color: #ff9800; }

    /* Top Bar */
    .topbar {
      margin-left: 250px;
      background: white;
      padding: 8px 15px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .menu-toggle {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
    }
    .menu-toggle img { width: 26px; }

    .right-controls {
      display: flex;
      align-items: center;
    }

    .notification {
      margin-right: 20px;
      position: relative;
      cursor: pointer;
    }
    .notification img { width: 22px; }
    .notification span {
      position: absolute;
      top: -5px;
      right: -5px;
      background: red;
      color: white;
      font-size: 11px;
      padding: 2px 6px;
      border-radius: 50%;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .profile img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
    }
    .profile span {
      font-weight: bold;
      color: #333;
      font-size: 14px;
    }

    /* Main content */
    main {
      margin-left: 250px;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
      text-align: center;
      transition: margin-left 0.3s ease-in-out;
    }
    .greeting {
      font-size: 26px;
      font-weight: bold;
      margin-bottom: 15px;
    }
    .card {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 400px;
      width: 100%;
    }
    .card .profile-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 15px;
    }
    .card .profile-card img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin-bottom: 8px;
    }
    .status {
      display:inline-block; padding:5px 15px; border-radius:20px;
      background:#e6f9f0; color:#027a4b; font-weight:bold;
      margin-top: 10px;
    }

    /* Footer */
    footer {
      margin-left: 250px;
      text-align: center;
      background: #222;
      color: white;
      padding: 20px;
      transition: margin-left 0.3s ease-in-out;
    }
    footer .social { margin-top: 10px; }
    footer .social a { margin: 0 10px; display: inline-block; }
    footer .social img { width: 28px; transition: 0.3s; }
    footer .social img:hover { transform: scale(1.2); }

    /* Responsive */
    @media (max-width: 768px) {
      header { transform: translateX(-100%); }
      header.show { transform: translateX(0); }
      .close-btn { display: block; }
      .topbar { margin-left: 0; }
      main, footer { margin-left: 0; }
      .menu-toggle { display: block; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <header id="sidebar">
    <button class="close-btn" onclick="toggleMenu()">✖</button>
    <div class="logo">
      <img src="logo.png" alt="Gym Logo">
      <span class="gym-name">
        <span class="highlight">Fitness</span> Gym<br>Management
      </span>
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

    <a href="login.html" class="logout-btn">Logout</a>
  </header>

  <!-- Top Bar -->
  <div class="topbar">
    <button class="menu-toggle" onclick="toggleMenu()">
      <img src="https://cdn-icons-png.flaticon.com/512/1828/1828859.png" alt="Menu">
    </button>
    <div class="right-controls">
      <div class="notification">
        <img src="https://cdn-icons-png.flaticon.com/512/1827/1827392.png" alt="Notification">
        <span>3</span>
      </div>
      <div class="profile">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile">
        <span>Juan Dela Cruz</span>
      </div>
    </div>
  </div>

  <!-- Main -->
  <main>
    <div class="greeting">
      Welcome to <span class="highlight">AIA FITNESS GYM</span>
    </div>

    <div class="card">
      <div class="profile-card">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile Picture">
        <h3>Welcome, Juan!</h3>
      </div>
      <p>Status: <span class="status">Active</span></p>
      <p>Membership valid until: <strong>October 30, 2025</strong></p>
      <h3>Attendance</h3>
      <p>You checked in <strong>24 times</strong> this month.</p>
    </div>
  </main>

  <script>
    function toggleMenu() {
      document.getElementById("sidebar").classList.toggle("show");
    }
  </script>
</body>
</html>
