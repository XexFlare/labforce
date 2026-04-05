<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">ADD USER</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel">
          <header class="panel-heading panel-heading-purple">
            NEW USER REGISTRATION</header>
          <div class="panel-body">
          </div>
          <div class="card-body ">
            <div class="table-wrap">
              <div class="table-responsive">
                <?php
                $fertilizerID = $_POST['fertilizerID'];
                $item = $_POST['item'];
                $moisture = $_POST['moisture'];
                $n = $_POST['n'];
                $p2o5 = $_POST['p2o5'];
                $k2o = $_POST['k2o'];
                $s = $_POST['s'];
                $b = $_POST['b'];
                $zn = $_POST['zn'];
                $ph = $_POST['ph'];
                $total = $_POST['total'];
                $record = "INSERT INTO tbl_fertilizer_limits (fertilizerID,item,moisture,n,p2o5,k2o,s,b,zn,pH,total) VALUES ('" . $fertilizerID . "','" . $item . "','" . addslashes($moisture) . "','" . addslashes($n) . "','" . addslashes($p2o5) . "','" . addslashes($k2o) . "','" . addslashes($s) . "','" . addslashes($b) . "','" . addslashes($zn) . "',$ph ,'" . addslashes($total) . "')";
                $add = mysql_query($record) or die(mysql_error());
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
                ?>
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>