<?php include("includes/header.php");
$userID = $_GET['id'];
$query  = "SELECT * FROM tbl_system_users WHERE userID = '$userID'";
$results = mysql_query($query);
while ($row = mysql_fetch_array($results)) {
  extract($row);
}
?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">USER PASSWORD</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card  card-box">
          <div class="card-head">
            <header>
              <font color="#66CCFF">Change User PIN: </font>
              <font color="orange"><?php echo "$firstname $lastname"; ?></font>
            </header>
            <div class="tools">
              <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
              <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
              <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div>
          </div>
          <div class="card-body ">

            <form id="myForm" class="form-horizontal" action="change_user_password2.php" method="POST">

              <div class="form-group row">
                <label for="horizontalFormPassword" class="col-sm-3 control-label">New PIN</label>
                <div class="col-sm-3">
                  <input type="number" maxlength="4" minlength="4" class="form-control" placeholder="PIN" name="pass1" id="horizontalFormPassword" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="horizontalFormPassword" class="col-sm-3 control-label">Confirm PIN</label>
                <div class="col-sm-3">
                  <input type="number" maxlength="4" minlength="4" class="form-control" placeholder="Confirm PIN" name="pass2" id="horizontalFormPassword" required>
                </div>
              </div>

              <input type="hidden" name="id" value="<?php echo "$userID"; ?>">

              <div class="form-group row">
                <label for="horizontalFormPassword" class="col-sm-3 control-label"></label>
                <div class="col-sm-3">
                  <button type="submit" class="btn btn-info" align="left">Change Password</button>
                </div>
              </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>