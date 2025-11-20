<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors directly, log them instead

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = trim($_POST['username'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $birthday = $_POST['birthday'] ?? '';
    $contact_number = trim($_POST['contact_number'] ?? '');
    $membership_availed = $_POST['membership_availed'] ?? '';
    $payment_mode = $_POST['payment_mode'] ?? '';
    
    // Validate required fields
    if (empty($username) || empty($full_name) || empty($birthday) || 
        empty($contact_number) || empty($membership_availed) || 
        empty($payment_mode)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }
    
    // Validate email format for username
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
        exit;
    }
    
    // Validate phone number format
    if (!preg_match('/^09\d{9}$/', $contact_number)) {
        echo json_encode(['success' => false, 'message' => 'Contact number must be in format 09XXXXXXXXX.']);
        exit;
    }
    
    // Calculate membership rate
    $membership_rates = [
        '1 month' => 1200.00,
        '3 months' => 3000.00,
        '6 months' => 6000.00,
        '1 year' => 10000.00
    ];
    
    if (!isset($membership_rates[$membership_availed])) {
        echo json_encode(['success' => false, 'message' => 'Invalid membership type.']);
        exit;
    }
    
    $membership_rate = $membership_rates[$membership_availed];
    
    // Check if database connection exists
    if (!isset($conn) || $conn->connect_error) {
        error_log("Database connection failed: " . ($conn->connect_error ?? 'Connection object not found'));
        echo json_encode(['success' => false, 'message' => 'Database connection failed. Please try again later.']);
        exit;
    }
    
    try {
        // Generate unique ID number with collision detection
        // FIXED: Now checks BOTH pending_clients AND clients tables
        $current_year = date('y'); // Last 2 digits of year
        $max_attempts = 10;
        $id_number = null;
        
        for ($attempt = 0; $attempt < $max_attempts; $attempt++) {
            // Get the highest ID number from BOTH tables for current year
            $query_pending = "SELECT id_number FROM pending_clients 
                             WHERE id_number LIKE '%-{$current_year}' 
                             ORDER BY CAST(SUBSTRING_INDEX(id_number, '-', 1) AS UNSIGNED) DESC LIMIT 1";
            
            $query_clients = "SELECT id_number FROM clients 
                             WHERE id_number LIKE '%-{$current_year}' 
                             ORDER BY CAST(SUBSTRING_INDEX(id_number, '-', 1) AS UNSIGNED) DESC LIMIT 1";
            
            $result_pending = $conn->query($query_pending);
            $result_clients = $conn->query($query_clients);
            
            $max_pending = 0;
            $max_clients = 0;
            
            // Get max from pending_clients
            if ($result_pending && $result_pending->num_rows > 0) {
                $row = $result_pending->fetch_assoc();
                $parts = explode('-', $row['id_number']);
                $max_pending = intval($parts[0]);
            }
            
            // Get max from clients
            if ($result_clients && $result_clients->num_rows > 0) {
                $row = $result_clients->fetch_assoc();
                $parts = explode('-', $row['id_number']);
                $max_clients = intval($parts[0]);
            }
            
            // Use the highest number from BOTH tables
            $next_number = max($max_pending, $max_clients) + 1;
            
            // Format: NNNNNN-YY (e.g., 000001-25)
            $id_number = str_pad($next_number, 6, '0', STR_PAD_LEFT) . '-' . $current_year;
            
            // Check for collision in BOTH tables
            $check1 = $conn->prepare("SELECT id FROM pending_clients WHERE id_number = ?");
            $check1->bind_param("s", $id_number);
            $check1->execute();
            $check1->store_result();
            $collision1 = $check1->num_rows > 0;
            $check1->close();
            
            $check2 = $conn->prepare("SELECT id FROM clients WHERE id_number = ?");
            $check2->bind_param("s", $id_number);
            $check2->execute();
            $check2->store_result();
            $collision2 = $check2->num_rows > 0;
            $check2->close();
            
            if (!$collision1 && !$collision2) {
                break; // Unique ID found in both tables
            }
        }
        
        if (!$id_number) {
            throw new Exception("Failed to generate unique ID after {$max_attempts} attempts");
        }        // Check if email already exists in either table using MySQLi
        $check_query = "SELECT 'pending' as source, id FROM pending_clients WHERE family_name = ? 
                        UNION 
                        SELECT 'active' as source, id FROM clients WHERE family_name = ? OR email = ?";
        $stmt = $conn->prepare($check_query);
        
        if (!$stmt) {
            throw new Exception("Failed to prepare check statement: " . $conn->error);
        }
        
        $stmt->bind_param("sss", $username, $username, $username);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute check query: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $existing = $result->fetch_assoc();
            $source = $existing['source'] == 'pending' ? 'pending approval' : 'already active';
            echo json_encode(['success' => false, 'message' => "This email is {$source} in our system. Please use a different email or contact our front desk."]);
            $stmt->close();
            exit;
        }
        $stmt->close();
        
        // Use username as family_name and full_name as given_name for consistency
        $family_name = $username; // Store email in family_name field
        $given_name = $full_name; // Store full name in given_name field
        
        // Generate default password
        $default_password = 'Password_12345';
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
        
        // Insert into pending_clients table using MySQLi
        // Note: status column is used instead of membership_status
        $insert_query = "INSERT INTO pending_clients (
                        id_number, family_name, given_name, birthday, contact_number, 
                        membership_availed, membership_rate, payment_mode, password, 
                        status, entry_date
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', CURDATE())";
        
        $stmt = $conn->prepare($insert_query);
        
        if (!$stmt) {
            throw new Exception("Failed to prepare insert statement: " . $conn->error);
        }
        
        $stmt->bind_param("ssssssdss", 
            $id_number, 
            $family_name, 
            $given_name, 
            $birthday, 
            $contact_number,
            $membership_availed, 
            $membership_rate, 
            $payment_mode, 
            $hashed_password
        );
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true, 
                'message' => 'Application submitted successfully! Your membership is pending approval by our front desk staff. Your ID: ' . $id_number,
                'id_number' => $id_number,
                'username' => $username
            ]);
        } else {
            // Check if it's a duplicate key error
            if (strpos($stmt->error, 'Duplicate entry') !== false) {
                if (strpos($stmt->error, 'id_number') !== false) {
                    throw new Exception("ID number conflict detected. Please try again.");
                } else {
                    throw new Exception("This email is already registered. Please use a different email.");
                }
            } else {
                throw new Exception("Failed to insert data: " . $stmt->error);
            }
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>