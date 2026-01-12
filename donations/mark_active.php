<?php
include '../config.php';

$id = $_POST['campaign_id'];

mysqli_query($conn, "UPDATE campaigns SET status='active' WHERE id='$id'");

header("Location: campaigns.php");
exit;
?>
