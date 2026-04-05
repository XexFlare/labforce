<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">EDIT USER</div>
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
            <header>System Users</header>
            <div class="tools">
              <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
              <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
              <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div>
          </div>
          <div class="card-body ">
            <div class="table-wrap">
              <div class="table-responsive">
                <?php
                $firstname = isset($_POST['firstname']) ? trim(urldecode($_POST['firstname'])) : '';
                $lastname = isset($_POST['lastname']) ? trim(urldecode($_POST['lastname'])) : '';
                $gender = isset($_POST['gender']) ? trim(urldecode($_POST['gender'])) : '';
                $level = implode(", ", $_POST["level"]);
                $mobile = $_POST['mobile'];
                $city = $_POST['city'];
                $country = $_POST['country'];
                $unit = $_POST['unit'];
                $email = isset($_POST['email']) ? trim(urldecode($_POST['email'])) : '';
                $userID = isset($_POST['id']) ? trim(urldecode($_POST['id'])) : '';
                $update  = "UPDATE tbl_system_users SET firstname = '" . addslashes($firstname) . "',lastname = '" . addslashes($lastname) . "',gender = '$gender',userLevel = '$level',mobile = '$mobile',city = '" . addslashes($city) . "',country = '$country',unit = '$unit',email = '$email' WHERE userID ='$userID'";
                $query = mysql_query($update) or die(mysql_error());
                if ($query) {
                  include("includes/success.php");
                } else {
                  include("includes/error.php");
                }
                ?>
                <hr>
              </div>
            </div>
          </div>
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