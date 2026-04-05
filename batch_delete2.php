<?php include("includes/header.php");
$id = $_GET['id'];
$query = "DELETE FROM tbl_batches WHERE  batchID= '$id' ";
$delete = mysql_query($query);
header("Location: reports.php#top");
exit;
