<?php include("includes/header.php"); 
$batch = $_GET['id'];
echo "You sent: $batch";
$record = "INSERT INTO tbl_tests (batchID) VALUES ('" . $batch . "')";
$add = mysql_query($record) or die(mysql_error());
echo $add;
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;