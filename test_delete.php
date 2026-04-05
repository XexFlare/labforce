<?php include("includes/header.php");
$id = $_GET['id'];
$query = "DELETE FROM tbl_tests WHERE  testID= '$id' ";
$delete = mysql_query($query);
$query2 = "DELETE FROM tbl_analysis WHERE  testID= '$id' ";
$delete2 = mysql_query($query2);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
