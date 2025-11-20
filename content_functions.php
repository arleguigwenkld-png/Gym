<?php
// Content Management Functions for Gym System

include_once 'config.php';

/**
 * Get About page content
 */
function getAboutContent() {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM about_content ORDER BY updated_at DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching about content: " . $e->getMessage());
        return false;
    }
}

/**
 * Update About page content
 */
function updateAboutContent($title, $content, $image_path = null, $user_id = null) {
    global $pdo;
    try {
        // Get current content for logging
        $current = getAboutContent();
        
        if ($current) {
            // Update existing content
            $stmt = $pdo->prepare("
                UPDATE about_content 
                SET title = ?, content = ?, image_path = COALESCE(?, image_path), updated_by = ? 
                WHERE id = ?
            ");
            $result = $stmt->execute([$title, $content, $image_path, $user_id, $current['id']]);
        } else {
            // Insert new content
            $stmt = $pdo->prepare("
                INSERT INTO about_content (title, content, image_path, created_by) 
                VALUES (?, ?, ?, ?)
            ");
            $result = $stmt->execute([$title, $content, $image_path, $user_id]);
        }
        
        // Log the edit
        if ($result && $user_id) {
            logContentEdit('about_content', $current ? $current['id'] : $pdo->lastInsertId(), 
                          $current ? 'UPDATE' : 'CREATE', $current, 
                          ['title' => $title, 'content' => $content, 'image_path' => $image_path], 
                          $user_id);
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error updating about content: " . $e->getMessage());
        return false;
    }
}

/**
 * Get all active services
 */
function getServices($active_only = true) {
    global $pdo;
    try {
        $sql = "SELECT * FROM services";
        if ($active_only) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY display_order, title";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching services: " . $e->getMessage());
        return [];
    }
}

/**
 * Get single service by ID
 */
function getService($id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching service: " . $e->getMessage());
        return false;
    }
}

/**
 * Add or update service
 */
function saveService($id, $title, $description, $image_path = null, $price = null, $display_order = 0, $user_id = null) {
    global $pdo;
    try {
        if ($id) {
            // Update existing service
            $current = getService($id);
            $stmt = $pdo->prepare("
                UPDATE services 
                SET title = ?, description = ?, image_path = COALESCE(?, image_path), 
                    price = ?, display_order = ?, updated_by = ? 
                WHERE id = ?
            ");
            $result = $stmt->execute([$title, $description, $image_path, $price, $display_order, $user_id, $id]);
            
            if ($result && $user_id) {
                logContentEdit('services', $id, 'UPDATE', $current, 
                              ['title' => $title, 'description' => $description, 'image_path' => $image_path, 'price' => $price], 
                              $user_id);
            }
        } else {
            // Insert new service
            $stmt = $pdo->prepare("
                INSERT INTO services (title, description, image_path, price, display_order, created_by) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([$title, $description, $image_path, $price, $display_order, $user_id]);
            
            if ($result && $user_id) {
                logContentEdit('services', $pdo->lastInsertId(), 'CREATE', null, 
                              ['title' => $title, 'description' => $description, 'image_path' => $image_path, 'price' => $price], 
                              $user_id);
            }
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error saving service: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete service
 */
function deleteService($id, $user_id = null) {
    global $pdo;
    try {
        $current = getService($id);
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result && $user_id && $current) {
            logContentEdit('services', $id, 'DELETE', $current, null, $user_id);
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error deleting service: " . $e->getMessage());
        return false;
    }
}

/**
 * Get class schedules
 */
function getClassSchedules($active_only = true) {
    global $pdo;
    try {
        $sql = "SELECT * FROM class_schedules";
        if ($active_only) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching schedules: " . $e->getMessage());
        return [];
    }
}

/**
 * Get single schedule by ID
 */
function getClassSchedule($id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM class_schedules WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching schedule: " . $e->getMessage());
        return false;
    }
}

/**
 * Add or update class schedule
 */
function saveClassSchedule($id, $class_name, $instructor_name, $day_of_week, $start_time, $end_time, $max_participants = 20, $description = null, $user_id = null) {
    global $pdo;
    try {
        if ($id) {
            // Update existing schedule
            $current = getClassSchedule($id);
            $stmt = $pdo->prepare("
                UPDATE class_schedules 
                SET class_name = ?, instructor_name = ?, day_of_week = ?, start_time = ?, 
                    end_time = ?, max_participants = ?, description = ?, updated_by = ? 
                WHERE id = ?
            ");
            $result = $stmt->execute([$class_name, $instructor_name, $day_of_week, $start_time, $end_time, $max_participants, $description, $user_id, $id]);
            
            if ($result && $user_id) {
                logContentEdit('class_schedules', $id, 'UPDATE', $current, 
                              ['class_name' => $class_name, 'instructor_name' => $instructor_name, 'day_of_week' => $day_of_week], 
                              $user_id);
            }
        } else {
            // Insert new schedule
            $stmt = $pdo->prepare("
                INSERT INTO class_schedules (class_name, instructor_name, day_of_week, start_time, end_time, max_participants, description, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([$class_name, $instructor_name, $day_of_week, $start_time, $end_time, $max_participants, $description, $user_id]);
            
            if ($result && $user_id) {
                logContentEdit('class_schedules', $pdo->lastInsertId(), 'CREATE', null, 
                              ['class_name' => $class_name, 'instructor_name' => $instructor_name, 'day_of_week' => $day_of_week], 
                              $user_id);
            }
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error saving schedule: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete class schedule
 */
function deleteClassSchedule($id, $user_id = null) {
    global $pdo;
    try {
        $current = getClassSchedule($id);
        $stmt = $pdo->prepare("DELETE FROM class_schedules WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result && $user_id && $current) {
            logContentEdit('class_schedules', $id, 'DELETE', $current, null, $user_id);
        }
        
        return $result;
    } catch (PDOException $e) {
        error_log("Error deleting schedule: " . $e->getMessage());
        return false;
    }
}

/**
 * Log content edits for audit trail
 */
function logContentEdit($table_name, $record_id, $action, $old_data, $new_data, $user_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            INSERT INTO content_edit_logs (table_name, record_id, action, old_data, new_data, edited_by) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $table_name, 
            $record_id, 
            $action, 
            $old_data ? json_encode($old_data) : null, 
            $new_data ? json_encode($new_data) : null, 
            $user_id
        ]);
    } catch (PDOException $e) {
        error_log("Error logging content edit: " . $e->getMessage());
        return false;
    }
}

/**
 * Check if user is authorized to edit content
 */
function canEditContent($user_id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        return $user && in_array($user['role'], ['owner', 'front_desk']);
    } catch (PDOException $e) {
        error_log("Error checking user permissions: " . $e->getMessage());
        return false;
    }
}

/**
 * Handle file uploads
 */
function handleImageUpload($file, $upload_dir = '../../assets/img/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        return false;
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return '/gym System/assets/img/' . $filename;
    }
    
    return false;
}
?>