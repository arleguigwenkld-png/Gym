<?php
session_start();
include 'config.php';
include 'content_functions.php';

header('Content-Type: application/json');

// Check if user is logged in and authorized
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$user_id = $_SESSION['user_id'];
if (!canEditContent($user_id)) {
    echo json_encode(['success' => false, 'message' => 'You do not have permission to edit content']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'update_about':
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            
            if (empty($title) || empty($content)) {
                echo json_encode(['success' => false, 'message' => 'Title and content are required']);
                exit;
            }
            
            $result = updateAboutContent($title, $content, null, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'About content updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update about content']);
            }
            break;
            
        case 'update_about_image':
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'No image file uploaded or upload error']);
                exit;
            }
            
            $image_path = handleImageUpload($_FILES['image']);
            
            if (!$image_path) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image. Please check file type and size.']);
                exit;
            }
            
            // Update only the image path
            $about_content = getAboutContent();
            if ($about_content) {
                $result = updateAboutContent($about_content['title'], $about_content['content'], $image_path, $user_id);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Image updated successfully', 'image_path' => $image_path]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update image in database']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'No about content found to update']);
            }
            break;
            
        case 'add_service':
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = !empty($_POST['price']) ? floatval($_POST['price']) : null;
            $display_order = intval($_POST['display_order'] ?? 0);
            
            if (empty($title) || empty($description)) {
                echo json_encode(['success' => false, 'message' => 'Title and description are required']);
                exit;
            }
            
            $image_path = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_path = handleImageUpload($_FILES['image']);
            }
            
            $result = saveService(null, $title, $description, $image_path, $price, $display_order, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Service added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add service']);
            }
            break;
            
        case 'update_service':
            $id = intval($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = !empty($_POST['price']) ? floatval($_POST['price']) : null;
            $display_order = intval($_POST['display_order'] ?? 0);
            
            if (!$id || empty($title) || empty($description)) {
                echo json_encode(['success' => false, 'message' => 'ID, title and description are required']);
                exit;
            }
            
            $image_path = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_path = handleImageUpload($_FILES['image']);
            }
            
            $result = saveService($id, $title, $description, $image_path, $price, $display_order, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Service updated successfully', 'image_path' => $image_path]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update service']);
            }
            break;
            
        case 'delete_service':
            $id = intval($_POST['id'] ?? 0);
            
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'Service ID is required']);
                exit;
            }
            
            $result = deleteService($id, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Service deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete service']);
            }
            break;
            
        case 'add_schedule':
            $class_name = trim($_POST['class_name'] ?? '');
            $instructor_name = trim($_POST['instructor_name'] ?? '');
            $day_of_week = $_POST['day_of_week'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $end_time = $_POST['end_time'] ?? '';
            $max_participants = intval($_POST['max_participants'] ?? 20);
            $description = trim($_POST['description'] ?? '');
            
            if (empty($class_name) || empty($instructor_name) || empty($day_of_week) || empty($start_time) || empty($end_time)) {
                echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
                exit;
            }
            
            $result = saveClassSchedule(null, $class_name, $instructor_name, $day_of_week, $start_time, $end_time, $max_participants, $description, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Schedule added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add schedule']);
            }
            break;
            
        case 'update_schedule':
            $id = intval($_POST['id'] ?? 0);
            $class_name = trim($_POST['class_name'] ?? '');
            $instructor_name = trim($_POST['instructor_name'] ?? '');
            $day_of_week = $_POST['day_of_week'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $end_time = $_POST['end_time'] ?? '';
            $max_participants = intval($_POST['max_participants'] ?? 20);
            $description = trim($_POST['description'] ?? '');
            
            if (!$id || empty($class_name) || empty($instructor_name) || empty($day_of_week) || empty($start_time) || empty($end_time)) {
                echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
                exit;
            }
            
            $result = saveClassSchedule($id, $class_name, $instructor_name, $day_of_week, $start_time, $end_time, $max_participants, $description, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Schedule updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update schedule']);
            }
            break;
            
        case 'delete_schedule':
            $id = intval($_POST['id'] ?? 0);
            
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'Schedule ID is required']);
                exit;
            }
            
            $result = deleteClassSchedule($id, $user_id);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Schedule deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete schedule']);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
    
} catch (Exception $e) {
    error_log("Edit content error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error occurred']);
}
?>