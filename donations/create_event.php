<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $target = (int) $_POST['target_amount'];

    mysqli_query($conn,"
        INSERT INTO campaigns (title, target_amount, status)
        VALUES ('$title', $target, 'upcoming')
    ");

    header("Location: campaigns.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Upcoming Event</title>
    <style>
        body{font-family:Arial;background:#f5f7fb;padding:40px}
        .box{max-width:500px;margin:auto;background:#fff;padding:25px;border-radius:12px}
        input,button{width:100%;padding:10px;margin-top:10px}
        button{background:#28c76f;color:white;border:none;border-radius:6px}
    </style>
</head>
<body>

<div class="box">
    <h2>Create Upcoming Event</h2>

    <form method="POST">
        <input type="text" name="title" placeholder="Event Title" required>
        <input type="number" name="target_amount" placeholder="Target Amount" required>
        <button>Create Event</button>
    </form>
</div>

</body>
</html>
