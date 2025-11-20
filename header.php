<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Gym Management</title>
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        /* ... (previous styles remain the same) ... */
        
        /* Page Transition Effects */
        .page-transition {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Active Navigation Link */
        nav ul li a.active {
            color: #BA830F;
            position: relative;
        }

        nav ul li a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #BA830F;
        }

        /* Navigation Link Hover Effect */
        nav ul li a {
            position: relative;
            overflow: hidden;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: -100%;
            width: 100%;
            height: 2px;
            background-color: #ff9800;
            transition: left 0.3s ease;
        }

        nav ul li a:hover::after {
            left: 0;
        }

        /* Join/Login Button Styles */
        .join-btn, .login-btn {
            background-color: #BA830F;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .join-btn:hover, .login-btn:hover {
            background-color: #ff9800;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: black;
        }

        .modal-content input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-content button {
            width: 95%;
            padding: 10px;
            background-color: #BA830F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #9a6d0c;
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
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
            <nav>
                <ul>
                <li><a href="/gym System/pages/homepage/First Page.php">Home</a></li>
                <li><a href="/gym System/pages/homepage/about.php">About</a></li>
                <li><a href="/gym System/pages/homepage/schedule.php">Schedule</a></li>
                <li><a href="/gym System/pages/homepage/services.php">Services</a></li>
                <li><a href="/gym System/pages/homepage/prices.php">Price</a></li>
                <li><a href="/gym System/pages/homepage/contacts.php">Contacts</a></li>
                </ul>
            </nav>
        </div>
        <!-- Join Button -->
        <div class="join-btn" onclick="openJoinModal()">Join Now</div>
    </header>

    <!-- Join Modal -->
    <div id="joinModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeJoinModal()">&times;</span>
            <h2>Join AIA Fitness Gym</h2>
            <form id="joinForm">
                <input type="text" name="username" id="join_username" placeholder="Username" required>
                <input type="text" name="full_name" id="full_name" placeholder="Full Name" required>
                <input type="date" name="birthday" id="birthday" placeholder="Birthday" required>
                <input type="tel" name="contact_number" id="contact_number" placeholder="Contact Number" required>
                <select name="membership_availed" id="membership_availed" required>
                    <option value="">Select Membership</option>
                    <option value="1 month">1 Month - ₱1,200</option>
                    <option value="3 months">3 Months - ₱3,000</option>
                    <option value="6 months">6 Months - ₱6,000</option>
                    <option value="1 year">1 Year - ₱10,000</option>
                </select>
                <select name="payment_mode" id="payment_mode" required>
                    <option value="">Select Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="GCash">GCash</option>
                    <option value="PayMaya">PayMaya</option>
                </select>
                <input type="password" name="password" id="join_password" placeholder="Password" required>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Join Now</button>
            </form>
            <div id="joinError" style="color: red; margin-top: 10px; display: none;"></div>
            <div style="margin-top: 10px; text-align: center;">
                <a href="#" onclick="switchToLogin()">Already have an account? Log In</a>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeLoginModal()">&times;</span>
            <h2>Welcome AIA Fitness Gym</h2>
            <form id="loginForm">
                <input type="text" name="username" id="login_username" placeholder="Username or ID Number" required>
                <input type="password" name="password" id="login_password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <div id="loginError" style="color: red; margin-top: 10px; display: none;"></div>
            <div style="margin-top: 10px; text-align: center;">
                <a href="#" onclick="switchToJoin()">Don't have an account? Join Now</a>
            </div>
        </div>
    </div>

    <script>
        // Add page transition effect
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('page-transition');
        });

        // Handle navigation clicks
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.body.style.opacity = '0';
                setTimeout(() => {
                    window.location.href = this.href;
                }, 300);
            });
        });

        // Toggle mobile menu
        function toggleMenu() {
            const nav = document.querySelector('nav');
            nav.classList.toggle('active');
        }

        // Modal functions
        function openJoinModal() {
            document.getElementById("joinModal").style.display = "flex";
            closeLoginModal();
        }
        
        function closeJoinModal() {
            document.getElementById("joinModal").style.display = "none";
            document.getElementById("joinError").style.display = "none";
            document.getElementById("joinForm").reset();
        }

        function openLoginModal() {
            document.getElementById("loginModal").style.display = "flex";
            closeJoinModal();
        }
        
        function closeLoginModal() {
            document.getElementById("loginModal").style.display = "none";
            document.getElementById("loginError").style.display = "none";
            document.getElementById("loginForm").reset();
        }

        function switchToLogin() {
            closeJoinModal();
            openLoginModal();
        }

        function switchToJoin() {
            closeLoginModal();
            openJoinModal();
        }

        // Legacy function for backward compatibility
        function openModal() {
            openLoginModal();
        }

        function closeModal() {
            closeLoginModal();
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const loginModal = document.getElementById("loginModal");
            const joinModal = document.getElementById("joinModal");
            if (event.target == loginModal) {
                closeLoginModal();
            }
            if (event.target == joinModal) {
                closeJoinModal();
            }
        }

        // Handle login form submission
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const username = document.getElementById('login_username').value.trim();
                    const password = document.getElementById('login_password').value.trim();
                    const loginError = document.getElementById('loginError');
                    const submitBtn = this.querySelector('button[type="submit"]');
                    
                    // Clear previous errors
                    loginError.style.display = 'none';
                    
                    // Validate inputs
                    if (!username || !password) {
                        loginError.textContent = 'Please enter both username and password';
                        loginError.style.display = 'block';
                        return;
                    }
                    
                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Logging in...';
                    
                    const formData = new FormData();
                    formData.append('username', username);
                    formData.append('password', password);
                    
                    fetch('/gym System/pages/homepage/includes/login_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text(); // Get as text first
                    })
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            
                            if (data.success) {
                                loginError.style.color = 'green';
                                loginError.textContent = 'Login successful! Redirecting...';
                                loginError.style.display = 'block';
                                
                                // Redirect after a short delay
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 1000);
                            } else {
                                loginError.style.color = 'red';
                                loginError.textContent = data.message || 'Login failed';
                                loginError.style.display = 'block';
                            }
                        } catch (parseError) {
                            console.error('JSON Parse Error:', parseError);
                            console.error('Response text:', text);
                            loginError.textContent = 'Server response error. Please try again.';
                            loginError.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        loginError.textContent = 'Connection error. Please check your internet and try again.';
                        loginError.style.display = 'block';
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Login';
                    });
                });
            }

            // Handle join form submission
            const joinForm = document.getElementById('joinForm');
            if (joinForm) {
                joinForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const joinError = document.getElementById('joinError');
                    const submitBtn = this.querySelector('button[type="submit"]');
                    
                    // Password confirmation check
                    const password = document.getElementById('join_password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;
                    
                    if (password !== confirmPassword) {
                        joinError.textContent = 'Passwords do not match';
                        joinError.style.display = 'block';
                        return;
                    }
                    
                    // Clear previous errors
                    joinError.style.display = 'none';
                    
                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Joining...';
                    
                    fetch('/gym System/pages/homepage/includes/join_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            
                            if (data.success) {
                                joinError.style.color = 'green';
                                joinError.textContent = 'Registration successful! You can now login.';
                                joinError.style.display = 'block';
                                
                                // Clear form and switch to login after delay
                                setTimeout(() => {
                                    joinForm.reset();
                                    switchToLogin();
                                }, 2000);
                            } else {
                                joinError.style.color = 'red';
                                joinError.textContent = data.message || 'Registration failed';
                                joinError.style.display = 'block';
                            }
                        } catch (parseError) {
                            console.error('JSON Parse Error:', parseError);
                            console.error('Response text:', text);
                            joinError.textContent = 'Server response error. Please try again.';
                            joinError.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        joinError.textContent = 'Connection error. Please check your internet and try again.';
                        joinError.style.display = 'block';
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Join Now';
                    });
                });
            }
        });
    </script>
</body>
</html>