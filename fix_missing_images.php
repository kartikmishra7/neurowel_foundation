<?php
include "config.php";

// Function to check and fix image paths
function fix_image_path($table, $column, $id_column, $id_value) {
    global $conn;

    // Get current path
    $query = "SELECT $column FROM $table WHERE $id_column = $id_value";
    $result = mysqli_query($conn, $query);
    if (!$result || mysqli_num_rows($result) == 0) return;

    $row = mysqli_fetch_assoc($result);
    $current_path = $row[$column];

    if (empty($current_path)) return;

    // Check if file exists in uploads/aadhaar/
    $server_path_aadhaar = "C:/xampp/htdocs/NGO dashboard/uploads/aadhaar/" . basename($current_path);
    if (file_exists($server_path_aadhaar)) {
        echo "File exists in aadhaar: $current_path\n";
        return;
    }

    // If not, check in uploads/
    $server_path_uploads = "C:/xampp/htdocs/NGO dashboard/uploads/" . basename($current_path);
    if (file_exists($server_path_uploads)) {
        // Update path to uploads/aadhaar/filename
        $new_path = "uploads/aadhaar/" . basename($current_path);
        $update_query = "UPDATE $table SET $column = '$new_path' WHERE $id_column = $id_value";
        if (mysqli_query($conn, $update_query)) {
            // Move file to aadhaar directory
            $new_server_path = "C:/xampp/htdocs/NGO dashboard/uploads/aadhaar/" . basename($current_path);
            if (rename($server_path_uploads, $new_server_path)) {
                echo "Fixed and moved: $current_path -> $new_path\n";
            } else {
                echo "Updated path but failed to move file: $current_path\n";
            }
        } else {
            echo "Failed to update path for: $current_path\n";
        }
    } else {
        echo "File not found anywhere: $current_path\n";
    }
}

// Fix images in about_page table
$query = "SELECT id FROM about_page ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];

    $images = ['hero_image', 'who_image', 'vision_image', 'mission_image', 'approach_image', 'founder_image'];
    foreach ($images as $image) {
        fix_image_path('about_page', $image, 'id', $id);
    }
}

echo "Image path fixing completed.\n";
mysqli_close($conn);
?>
