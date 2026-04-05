<?php session_start();
ob_start();

if (isset($_SESSION['user'])) {
	header("Location: index.php");
}
include_once("connect/dbconnect.php");
$state = $_SESSION['state'];

if(!strlen($state) > 0 && $state == $_GET['state']){
	echo 'unauthorized';
	return;
}
$response = file_get_contents(getenv('FORCEHUB_URL').'/oauth/token', false, stream_context_create([
	'http' => [
			'method' => 'POST',
			'content' => http_build_query([
				'grant_type' => 'authorization_code',
				'client_id' => getenv('FORCEHUB_CLIENT_ID'),
				'client_secret' => getenv('FORCEHUB_CLIENT_SECRET'),
				'redirect_uri' => getenv('APP_URL').'/login-callback.php',
				'code' => $_GET['code'],
			])
		]
	])
);
$body = json_decode($response);
$userResponse = file_get_contents(getenv('FORCEHUB_URL').'/api/user', false, stream_context_create([
	'http' => [
		'method' => 'GET',
		'header'  => [
			"Authorization: {$body->token_type} {$body->access_token}",
			"Accept: application/json"
		]
	]
]));
$user = json_decode($userResponse);
$res = mysql_query("SELECT userID,pin FROM tbl_system_users WHERE email ='{$user->email}'");
$appUser = mysql_fetch_array($res);
if(!$appUser) {
	$firstname = explode(' ', $user->name)[0];
	$lastname = explode(' ', $user->name)[1] ?? '';
	$record = "INSERT INTO tbl_system_users 
		(firstname,lastname,userLevel,country,unit,email) 
		VALUES ('$firstname','$lastname','3','128','3','{$user->email}')";
	// $record = "INSERT INTO tbl_system_users 
	// 	(firstname,lastname,gender,userLevel,mobile,city,country,unit,email,pin) 
	// 	VALUES ('$firstname','$lastname','$gender','3','$mobile','$city','$country','$unit','$email','$pin2')";
	$add = mysql_query($record) or die(mysql_error());
	echo 'user created';
} else echo 'user found';
$_SESSION['user'] = $appUser['userID'];
if ($_SESSION['redirect'] != '') {
	header("Location:" . $_SESSION['redirect']);
} else {
	header("Location: index.php#top");
}
?>