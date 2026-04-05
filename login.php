<?php session_start();
ob_start();
if (isset($_SESSION['user'])) {
	header("Location: index.php");
}
include_once("connect/dbconnect.php");
if (isset($_POST['email'])) {
	$email = trim($_POST['email']);
	$pin = trim($_POST['pass']);
	$pass1 = hash('sha256', $pin); // password hashing using SHA256
	$res = mysql_query("SELECT userID,pin FROM tbl_system_users WHERE email ='$email' && pin ='$pass1' ");
	$row = mysql_fetch_array($res);
	$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
	if ($count == 1 && $row['pin'] == $pass1) {
		$_SESSION['user'] = $row['userID'];
		if ($_GET['redirect'] != '') {
			header("Location:" . $_GET['redirect']);
		} else {
			header("Location: index.php#top");
		}
	} else {
		$failed = true;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="Clinic Management System" />
	<meta name="author" content="DEEGITS TECHNOLOGY LIMITED" />
	<title>Lab Force : MFC Lab Analysis System</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="assets/iconic/css/material-design-iconic-font.min.css">
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/extra_pages.css?v=0.0.5">
	<link rel="shortcut icon" href="images/favicon.ico" />
</head>
<body>
	<div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . htmlspecialchars($_GET['redirect']) : ''; ?>">
					<span class="login100-form-logo">
						<img alt="" src="images/lab.jpg">
					</span>
					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					<div class="wrap-input100 validate-input" data-validate="Enter Email">
						<input class="input100" autocomplete="new-password" type="email" name="email" placeholder="User Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password" autocomplete="new-password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<?php echo isset($failed) ? '<div class="text-white bg-danger p-2 mb-2 rounded">Login failed: Please check your credentials</div>' : ''; ?>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
						<a class="login100-form-btn-sec" href='login-forcehub.php<?php echo isset($_GET['redirect']) && $_GET['redirect'] != '' ? '?redirect=' . htmlspecialchars($_GET['redirect']) : '';?>'>
							Login With ForceHub
						</a>
					</div>
					<div class="text-center p-t-30">
						<a class="txt1" href="forgot_password.html">
							Forgot Password?
						</a>

					</div>
					<div class="text-center p-t-30">
						<table border="0" width="100%" id="table1">
							<tr>
								<td>&nbsp;</td>
								<td>
									<img border="0" src="images/logo.png" width="302" height="81">
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</div>

				</form>
			</div>
		</div>
	</div>
	<script src="assets/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/login.js"></script>
</body>

</html>