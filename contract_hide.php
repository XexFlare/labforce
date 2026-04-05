<?php include("includes/header.php"); 
$id = $_GET['id'];
$query  = "SELECT hidden FROM tbl_contracts WHERE contractID= '$id'";
$results = mysql_query($query);
$row = mysql_fetch_array($results);
$hidden = $row[0] ? 0 : 1;
$query = "UPDATE tbl_contracts SET hidden = $hidden WHERE contractID= '$id'";
mysql_query($query) or die(mysql_error());
header("Location: /contract_add.php");
