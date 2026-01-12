<?php
include '../config.php';

if (!isset($_GET['id'], $_GET['type'])) {
    die("Invalid request");
}

$id   = (int)$_GET['id'];
$type = $_GET['type'];

$q = mysqli_query($conn, "SELECT * FROM volunteers WHERE id=$id");
$v = mysqli_fetch_assoc($q);

if(!$v){
    die("Volunteer not found");
}

switch ($type) {

    case 'approve':

        // Generate ID ONLY if empty
        if (empty($v['volunteer_id'])) {
            $year = date('Y');
            $unique = str_pad($id, 4, '0', STR_PAD_LEFT);
            $volunteer_id = "VOL-$year-$unique";

            mysqli_query($conn, "
                UPDATE volunteers SET
                volunteer_id = '$volunteer_id',
                status = 'approved',
                is_active = 1
                WHERE id = $id
            ");
        }
        break;

    case 'reject':
        mysqli_query($conn, "
            UPDATE volunteers SET
            status = 'rejected',
            is_active = 0
            WHERE id = $id
        ");
        break;

    case 'activate':
        mysqli_query($conn, "
            UPDATE volunteers SET
            is_active = 1
            WHERE id = $id AND status='approved'
        ");
        break;

    case 'deactivate':
        mysqli_query($conn, "
            UPDATE volunteers SET
            is_active = 0
            WHERE id = $id AND status='approved'
        ");
        break;

    default:
        die("Invalid action");
}

header("Location: volunteer.php");
exit;
