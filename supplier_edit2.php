<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">EDIT SUPPLIER</div>
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
              <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
              <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
              <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
            </div>
          </div>
          <div class="card-body ">
            <div class="table-wrap">
              <div class="table-responsive">
                <?php
                $supplierID = $_POST['supplierID'];
                $details = isset($_POST['details']) ? trim(urldecode($_POST['details'])) : '';
                $address = isset($_POST['address']) ? trim(urldecode($_POST['address'])) : '';
                $country = isset($_POST['country']) ? trim(urldecode($_POST['country'])) : '';
                $phone = $_POST['phone'];
                $email = isset($_POST['email']) ? trim(urldecode($_POST['email'])) : '';
                $notes = isset($_POST['notes']) ? trim(urldecode($_POST['notes'])) : '';
                $update  = "UPDATE tbl_suppliers SET details = '" . addslashes($details) . "',address = '" . addslashes($address) . "',country = '$country',phone = '" . addslashes($phone) . "',email = '" . addslashes($email) . "',notes = '" . addslashes($notes) . "' WHERE supplierID ='$supplierID'";
                $query = mysql_query($update) or die(mysql_error());
                //echo $query;

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