<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">ADD SUPPLIER</div>
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
            NEW SUPPLIER REGISTRATION</header>
          <div class="panel-body">
          </div>
          <div class="card-body ">
            <div class="table-wrap">
              <div class="table-responsive">
                <?php
                $details = isset($_POST['details']) ? trim(urldecode($_POST['details'])) : '';
                $address = isset($_POST['address']) ? trim(urldecode($_POST['address'])) : '';
                $country = isset($_POST['country']) ? trim(urldecode($_POST['country'])) : '';
                $phone = $_POST['phone'];
                $email = isset($_POST['email']) ? trim(urldecode($_POST['email'])) : '';
                $notes = isset($_POST['notes']) ? trim(urldecode($_POST['notes'])) : '';
                $record = "INSERT INTO tbl_suppliers (details,address,country,phone,email,notes) VALUES ('" . addslashes($details) . "','" . addslashes($address) . "','" . $country . "','" . $phone . "','" . $email . "','" . addslashes($notes) . "')";
                $add = mysql_query($record) or die(mysql_error());
                if ($add) {
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
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>