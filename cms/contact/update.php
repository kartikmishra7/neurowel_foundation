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

/* ---------- GET OLD DATA ---------- */
$old = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM contact_page WHERE id=$id")
);

if (!$old) {
    die("Record not found");
}

/* ---------- UPDATE LOGIC ---------- */
$sql = "";

switch ($section) {

    case "contact_title":
        $oldImage = $old['contact_image'] ?? '';
        if (isset($old['contact_image'])) {
            $sql = "
            UPDATE contact_page SET
            contact_title='".esc_sql($conn,$_POST['contact_title'])."',
            contact_description='".esc_sql($conn,$_POST['contact_description'])."',
            contact_image='".uploadFile('contact_image', $oldImage)."'
            WHERE id=$id";
        } else {
            $sql = "
            UPDATE contact_page SET
            contact_title='".esc_sql($conn,$_POST['contact_title'])."',
            contact_description='".esc_sql($conn,$_POST['contact_description'])."'
            WHERE id=$id";
        }
        break;

    case "form_title":
        $sql = "
        UPDATE contact_page SET
        form_title='".esc_sql($conn,$_POST['form_title'])."',
        first_name='".esc_sql($conn,$_POST['first_name'])."',
        last_name='".esc_sql($conn,$_POST['last_name'])."',
        email_Address='".esc_sql($conn,$_POST['email_Address'])."',
        phonenumber='".esc_sql($conn,$_POST['phonenumber'])."',
        message='".esc_sql($conn,$_POST['message'])."',
        send_message='".esc_sql($conn,$_POST['send_message'])."'
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


