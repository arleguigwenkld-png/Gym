<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Welcome to AIA Fitness Gym</h2>
        <form id="loginForm" onsubmit="handleLogin(event)">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="error-message" id="loginError"></div>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<style>
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
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal.show {
    opacity: 1;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    width: 350px;
    max-width: 90%;
    text-align: center;
    position: relative;
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.modal.show .modal-content {
    transform: translateY(0);
}

.form-group {
    margin-bottom: 15px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    border-color: #BA830F;
    outline: none;
}

.error-message {
    color: #ff3333;
    margin: 10px 0;
    font-size: 14px;
    display: none;
}

button[type="submit"] {
    background: #BA830F;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s ease;
}

button[type="submit"]:hover {
    background: #ff9800;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #333;
    transition: color 0.3s ease;
}

.close-btn:hover {
    color: #BA830F;
}
</style>

<script>
function openModal() {
    const modal = document.getElementById('loginModal');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}

function closeModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 300);
}

async function handleLogin(event) {
    event.preventDefault();
    const form = event.target;
    const errorDiv = document.getElementById('loginError');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    try {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Logging in...';
        
        const formData = new FormData(form);
        const response = await fetch('includes/login_handler.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            errorDiv.style.display = 'none';
            window.location.href = data.redirect;
        } else {
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Login';
        }
    } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.style.display = 'block';
        submitBtn.disabled = false;
        submitBtn.textContent = 'Login';
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('loginModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>