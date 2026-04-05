<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Dashboard</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-box">
          <div class="card-head">
            <header>System Settings</header>
            <div class="tools">
              <a class="fa fa-repeat btn-color box-refresh" href="javascript:history.back();"></a>
              <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
              <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div>
          </div>
          <div class="card-body ">
            <div class="table-wrap">
              <div class="table-responsive">
                <?php
                $id = $_POST['id'];
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];
                if ($pass1 == $pass2) {
                  $pin2 = hash('sha256', $pass1);
                  $update  = "UPDATE tbl_system_users SET pin = '$pin2' WHERE userID ='$id'";
                  $query = mysql_query($update) or die(mysql_error());
                  //echo $query;
                  if ($query) {
                    include("includes/success.php");
                  } else {
                    include("includes/error.php");
                  }
                } else {
                  echo "<p>Passwords do not match!</p>
		<p><a href='javascript:history.back();'><i class='fa fa-angle-double-left'> BACK</i></a></p>
		";
                }
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
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>