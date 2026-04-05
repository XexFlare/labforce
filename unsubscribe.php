<?php
include_once("connect/dbconnect.php");
$email = $_GET['email'];
if ($email) {
  $query = "DELETE FROM alert_recipients WHERE `email` = '$email'";
  mysql_query($query);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta name="description" content="Responsive Admin Template" />
  <meta name="author" content="Deegits Technology Limited" />
  <title>Lab Force : MFC Lab Analysis System</title>
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/theme_style.css" rel="stylesheet" id="rt_style_components" type="text/css" />
  <link href="css/style.css?v=1.0.8" rel="stylesheet" type="text/css" />
  <link href="css/responsive.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>
  <div class="page-container">
    <div class="page-content">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel">
            <header class="panel-heading panel-heading-purple">
              UNSUBSCRIBE</header>
            <div class="panel-body">
            </div>
            <div class="card-body ">
              <div class="table-wrap">
                <div class="table-responsive">
                  You have been unsubscribed from email alerts.
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>