<?php
include "../../config.php";

$table=$_GET['table'];
$id=$_GET['id'];

$data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT image FROM $table WHERE id=$id"));
if($data['image'] && file_exists("../../uploads/".$data['image'])){
unlink("../../uploads/".$data['image']);
}

mysqli_query($conn,"DELETE FROM $table WHERE id=$id");
header("Location: gallery_admin.php");
