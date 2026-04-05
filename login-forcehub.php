<?php session_start();
ob_start();
if (isset($_SESSION['user'])) {
	header("Location: index.php");
}
include_once("connect/dbconnect.php");
$state = bin2hex(random_bytes(40));
$_SESSION['state'] = $state;
if (isset($_GET['redirect']) && $_GET['redirect'] != '') {
	$_SESSION['redirect'] = $_GET['redirect'];
}
$query = http_build_query([
		'client_id' => getenv('FORCEHUB_CLIENT_ID'),
		'redirect_uri' => getenv('APP_URL')."/login-callback.php",
		'response_type' => 'code',
		'scope' => '',
		'state' => $state,
]);
header('Location: '.getenv('FORCEHUB_URL').'/oauth/authorize?'.$query)
?>