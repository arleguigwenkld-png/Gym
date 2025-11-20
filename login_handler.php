<?php
session_start();
header('Content-Type: application/json');

// Function to send JSON response and exit
function sendResponse($success, $message, $redirect = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($redirect) {
        $response['redirect'] = $redirect;
    }
    echo json_encode($response);
    exit;
}

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, 'Invalid request method');
}

try {
    // Include database connection
    include 'config.php';
    
    // Get and validate input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if (empty($username) || empty($password)) {
        sendResponse(false, 'Please enter both username and password');
    }
    
    // Initialize variables
    $user = null;
    $userType = null;
    
    // First, try the users table (for owner/front_desk)
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    if (!$stmt) {
        sendResponse(false, 'Database error: ' . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $userType = $user['role'];
    } else {
        // If not found in users table, try clients table (using id_number as username)
        $stmt->close();
        $stmt = $conn->prepare("SELECT id, id_number, password, family_name, given_name, membership_status FROM clients WHERE id_number = ?");
        
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $clientData = $result->fetch_assoc();
                // Convert client data to user format
                $user = [
                    'id' => $clientData['id'],
                    'username' => $clientData['id_number'],
                    'password' => $clientData['password'],
                    'role' => 'client',
                    'full_name' => trim($clientData['family_name'] . ' ' . $clientData['given_name']),
                    'membership_status' => $clientData['membership_status']
                ];
                $userType = 'client';
            }
        }
    }
    
    if ($user && isset($user['password'])) {
        // Verify password
        $passwordValid = false;
        
        // Try hashed password verification first
        if (password_verify($password, $user['password'])) {
            $passwordValid = true;
        }
        // If password is stored as plain text
        elseif ($password === $user['password']) {
            $passwordValid = true;
        }
        
        if ($passwordValid) {
            // Check if client account is active
            if ($userType === 'client' && isset($user['membership_status'])) {
                if ($user['membership_status'] !== 'Active') {
                    sendResponse(false, 'Your membership is not active. Please contact front desk.');
                }
            }
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $userType;
            $_SESSION['user_type'] = $userType;
            $_SESSION['logged_in'] = true;
            
            // Set full name
            if (isset($user['full_name'])) {
                $_SESSION['full_name'] = $user['full_name'];
            } else {
                $_SESSION['full_name'] = $user['username'];
            }
            
            // Get redirect URL based on user type
            $redirect = getRedirectUrl($userType);
            
            $stmt->close();
            $conn->close();
            
            sendResponse(true, 'Login successful', $redirect);
        }
    }
    
    // Close connections
    if (isset($stmt)) $stmt->close();
    $conn->close();
    
    sendResponse(false, 'Invalid username or password');
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    sendResponse(false, 'Database connection error. Please try again.');
}

function getRedirectUrl($userType) {
    $baseUrl = '/gym System/pages/';
    
    switch (strtolower($userType)) {
        case 'client':
        case 'member':
        case 'customer':
            return $baseUrl . 'client/dashboard.php';
        case 'front_desk':
        case 'staff':
        case 'receptionist':
            return $baseUrl . 'front_desk/Front_desk.php';
        case 'owner':
        case 'admin':
        case 'administrator':
            return $baseUrl . 'owner/owner.php';
        default:
            return $baseUrl . 'homepage/First Page.php';
    }
}
?>