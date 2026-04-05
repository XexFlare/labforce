<?php include("includes/header.php");
$id = $_GET['id'];
$query  = "SELECT is_blend FROM tbl_contracts WHERE contractID= '$id'";
$results = mysql_query($query);
$row = mysql_fetch_array($results);
$is_blend = $row[0] ? 0 : 1;
$query = "UPDATE tbl_contracts SET is_blend = $is_blend WHERE contractID= '$id'";
mysql_query($query) or die(mysql_error());
header("Location: /contract_add.php");
