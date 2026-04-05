<?php
include_once("connect/dbconnect.php");
include("connect/login_script.php");
$pagetitle = $pagetitle ?? 'Lab Force: MFC Lab Analysis System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta name="description" content="Lab Force: MFC Lab Analysis System" />
  <meta name="author" content="Skrypt Technologies" />
  <title><?php echo $pagetitle; ?></title>
  <link rel="stylesheet" href="css/webfonts.css" type="text/css" />
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="webfonts/webicons.css">
  <link href="assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="assets/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/material-datetimepicker/bootstrap-material-datetimepicker.css" rel="stylesheet" type="text/css" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="assets/material/material.min.css">
  <link rel="stylesheet" href="assets/getmdl.css">
  <link rel="stylesheet" href="css/material_style.css">
  <link href="css/theme_style.css?v=1.0.2" rel="stylesheet" id="rt_style_components" type="text/css" />
  <link href="css/plugins.min.css" rel="stylesheet" type="text/css" />
  <?php if(isset($beta)) { ?> 
    <link href="css/style_beta.css?v=1.0.0" rel="stylesheet" type="text/css" />
  <?php } else { ?>
      <link href="css/style.css?v=1.0.20" rel="stylesheet" type="text/css" />
  <?php } ?>
  <link href="css/responsive.css" rel="stylesheet" type="text/css" />
  <link href="css/theme-color.css?v=1.0.1" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="images/favicon.ico" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>

<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
  <div class="page-wrapper">
    <div class="page-header navbar navbar-fixed-top">
      <div class="page-header-inner ">
        <div class="page-logo">
          <a href="index.php">
            <img alt="" src="images/lab.jpg" height="40" width="40" style="border-radius: 50%;">
            <span class="logo-default">LABFORCE</span> </a>
        </div>
        <ul class="nav navbar-nav navbar-left in">
          <li><a href="#" class="menu-toggler sidebar-toggler"><i class="fa fa-bars"></i></a></li>
        </ul>
        <form class="search-form-opened" action="#" method="GET">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search..." name="query">
            <span class="input-group-btn">
              <a href="javascript:;" class="btn submit">
                <i class="fa fa-search"></i>
              </a>
            </span>
          </div>
        </form>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
          <span></span>
        </a>
        <?php include('includes/top_menu.php'); ?>
      </div>
    </div>
    <div class="page-container">
      <?php include("includes/user_menu.php"); ?>