<?php
include "../../config.php";

$id = (int)($_POST['id'] ?? 0);
$section = $_POST['section'] ?? '';

if ($id <= 0 || empty($section)) {
    die("Invalid request");
}

/* ---------- HELPER FUNCTIONS ---------- */
function esc_sql($conn, $val){
    return mysqli_real_escape_string($conn, $val ?? '');
}

function uploadFile($field, $oldFile = ''){
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== 0 || empty($_FILES[$field]['name'])) {
        return $oldFile;
    }

    $uploadDir = "../../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES[$field]['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
        return $fileName;
    }

    return $oldFile;
}

function uploadMultiple($field, $oldValue = ''){
    if (!isset($_FILES[$field]) || empty($_FILES[$field]['name'][0])) {
        return $oldValue;
    }

    $files = $_FILES[$field];
    $uploadDir = "../../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $uploaded = [];

    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] === 0 && !empty($files['name'][$i])) {
            $name = time() . "_" . $i . "_" . basename($files['name'][$i]);
            $targetPath = $uploadDir . $name;
            if (move_uploaded_file($files['tmp_name'][$i], $targetPath)) {
                $uploaded[] = $name;
            }
        }
    }

    return !empty($uploaded) ? implode(',', $uploaded) : $oldValue;
}

/* ---------- GET OLD DATA ---------- */
$old = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM welcome_homepage WHERE id=$id")
);

if (!$old) {
    die("Record not found");
}

/* ---------- UPDATE LOGIC ---------- */
$sql = "";

switch ($section) {

    case "hero_title":
        $sql = "
        UPDATE welcome_homepage SET
        hero_title='".esc_sql($conn,$_POST['hero_title'])."',
        hero_description='".esc_sql($conn,$_POST['hero_description'])."',
        hero_donation_btn='".esc_sql($conn,$_POST['hero_donation_btn'])."',
        hero_volunteers_btn='".esc_sql($conn,$_POST['hero_volunteers_btn'])."',
        hero_image='".uploadFile('hero_image', $old['hero_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "welcome_page_title":
        $sql = "
        UPDATE welcome_homepage SET
        welcome_page_title='".esc_sql($conn,$_POST['welcome_page_title'])."',
        welome_page_description='".esc_sql($conn,$_POST['welcome_page_description'])."',
        welcome_page_image='".uploadFile('welcome_page_image', $old['welcome_page_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "our_focus_title":
        $sql = "
        UPDATE welcome_homepage SET
        our_focus_title='".esc_sql($conn,$_POST['our_focus_title'])."'
        WHERE id=$id";
        break;

    case "food_security_title":
        $oldImage = $old['food_security_image'] ?? '';
        // Check if column exists by checking if it's in the old data
        if (isset($old['food_security_image'])) {
            $sql = "
            UPDATE welcome_homepage SET
            food_security_title='".esc_sql($conn,$_POST['food_security_title'])."',
            food_security_description='".esc_sql($conn,$_POST['food_security_description'])."',
            food_security_image='".uploadFile('food_security_image', $oldImage)."'
            WHERE id=$id";
        } else {
            // Column doesn't exist, update without image
            $sql = "
            UPDATE welcome_homepage SET
            food_security_title='".esc_sql($conn,$_POST['food_security_title'])."',
            food_security_description='".esc_sql($conn,$_POST['food_security_description'])."'
            WHERE id=$id";
        }
        break;

    case "clothing_title":
        $sql = "
        UPDATE welcome_homepage SET
        clothing_title='".esc_sql($conn,$_POST['clothing_title'])."',
        clothing_description='".esc_sql($conn,$_POST['clothing_description'])."',
        clothing_image='".uploadFile('clothing_image', $old['clothing_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "eduction_title":
        $sql = "
        UPDATE welcome_homepage SET
        eduction_title='".esc_sql($conn,$_POST['eduction_title'])."',
        eduction_description='".esc_sql($conn,$_POST['eduction_description'])."',
        eduction_image='".uploadFile('eduction_image', $old['eduction_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "livelihood_title":
        $sql = "
        UPDATE welcome_homepage SET
        livelihood_title='".esc_sql($conn,$_POST['livelihood_title'])."',
        livelihood_description='".esc_sql($conn,$_POST['livelihood_description'])."',
        livelihood_image='".uploadFile('livelihood_image', $old['livelihood_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "community_title":
        $sql = "
        UPDATE welcome_homepage SET
        community_title='".esc_sql($conn,$_POST['community_title'])."',
        community_description='".esc_sql($conn,$_POST['community_description'])."',
        community_image='".uploadFile('community_image', $old['community_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "our_impact_title":
        $sql = "
        UPDATE welcome_homepage SET
        our_impact_title='".esc_sql($conn,$_POST['our_impact_title'])."',
        our_impact_description='".esc_sql($conn,$_POST['our_impact_description'])."',
        our_impact_image='".uploadFile('our_impact_image', $old['our_impact_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "mental_title":
        $sql = "
        UPDATE welcome_homepage SET
        mental_title='".esc_sql($conn,$_POST['mental_title'])."',
        mental_description='".esc_sql($conn,$_POST['mental_description'])."',
        mental_image='".uploadFile('mental_image', $old['mental_image'] ?? '')."'
        WHERE id=$id";
        break;

    case "media_title":
        $mediaFiles = uploadMultiple('media_video_image', $old['media_video_image'] ?? '');
        $sql = "
        UPDATE welcome_homepage SET
        media_title='".esc_sql($conn,$_POST['media_title'])."',
        media_description='".esc_sql($conn,$_POST['media_description'])."',
        media_video_title='".esc_sql($conn,$_POST['media_video_title'])."',
        media_video_image='".esc_sql($conn,$mediaFiles)."'
        WHERE id=$id";
        break;

    default:
        die("Invalid section: " . htmlspecialchars($section));
}

/* ---------- EXECUTE ---------- */
if (mysqli_query($conn, $sql)) {
    header("Location: veiw.php?updated=1");
    exit;
} else {
    die("Error: " . mysqli_error($conn) . "<br>SQL: " . htmlspecialchars($sql));
}

