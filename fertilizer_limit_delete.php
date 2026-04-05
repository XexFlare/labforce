<?php include("includes/header.php");
$id = $_GET['id'];
$query = "DELETE FROM tbl_fertilizer_limits WHERE  limitID= '$id' ";
$delete = mysql_query($query);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;