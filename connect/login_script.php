<?php session_start();
ob_start();
include_once("connect/dbconnect.php");

if (!isset($_SESSION['user'])) {
	header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
} else {
	$res = mysql_query("SELECT * FROM tbl_system_users WHERE userID=" . $_SESSION['user']);
	$userRow = mysql_fetch_array($res);
	$myLevel = $userRow['userLevel'];
	if(isset($requiredLevel) && $myLevel > $requiredLevel){
		header("Location: not-allowed.html");
	}
	$myID = $userRow['userID'];
	$myFirst = $userRow['firstname'];
	$myLast = $userRow['lastname'];
	$myCountry = $userRow['country'];
	$myUnit = $userRow['unit'];
	$myPin = $userRow['pin'];
	$myPhone = $userRow['mobile'];
	$myEmail = $userRow['email'];
	$myPic = $userRow['image'];
}
