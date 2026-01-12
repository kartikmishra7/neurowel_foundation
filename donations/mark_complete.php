<?php
include '../config.php';

$id = (int)$_POST['campaign_id'];

mysqli_query($conn,"UPDATE campaigns SET status='completed' WHERE id=$id");

header("Location: campaigns.php");
exit;
?>
