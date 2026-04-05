<?php include("includes/header.php");
$id = $_GET['id'];
$query = "DELETE FROM tbl_analysis WHERE  analysisID= '$id' ";
$delete = mysql_query($query);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
