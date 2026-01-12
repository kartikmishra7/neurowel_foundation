<?php
include '../config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=volunteers.csv');

$output = fopen('php://output', 'w');

/* ---------- CSV HEADERS ---------- */
fputcsv($output, [
    'Volunteer ID',
    'Full Name',
    'Email',
    'Phone',
    'Location',
    'Aadhaar Number',
    'Status',
    'Active'
]);

$q = mysqli_query($conn, "SELECT * FROM volunteers ORDER BY id DESC");

while ($v = mysqli_fetch_assoc($q)) {

    fputcsv($output, [
        $v['volunteer_id'] ?: 'Not Assigned',
        $v['full_name'],
        $v['email'],
        $v['phone'],
        $v['address'],
        $v['aadhaar_number'],   
        $v['status'],
        $v['is_active'] ? 'Yes' : 'No'
    ]);
}

fclose($output);
exit;
