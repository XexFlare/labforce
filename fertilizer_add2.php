<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">System Settings</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Form</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <?php
        $fertilizer = $_POST['fertilizer'];
        $blend = $_POST['blend'];
        $formula = $_POST['formula'];
        $upload = "INSERT INTO tbl_fertilizer_types(fertilizer,blend,formula,staff) VALUES ('" . addslashes($fertilizer) . "','" . addslashes($blend) . "','" . addslashes($formula) . "','" . $myID . "')";
        $done = mysql_query($upload);
        if ($done) {
          include("includes/success.php");
        } else {
          include("includes/error.php");
        }
        ?>
      </div>
      <div class="col-sm-6">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            CURRENT LIST </header>
          <div class="panel-body"><?php include("includes/fertilizer_list.php"); ?></div>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>