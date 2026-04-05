<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">DELETE SUPPLIER</div>
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
          <header class="panel-heading panel-heading-red">
            SUPPLIER DELETED</header>
          <div class="panel-body">
            <div class="card-body ">
              <div class="table-wrap">
                <div class="table-responsive">
                  <?php
                  $id = $_GET['id'];
                  $query = "DELETE FROM tbl_suppliers WHERE  supplierID= '$id' ";
                  $delete = mysql_query($query);
                  if ($delete) {
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
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>