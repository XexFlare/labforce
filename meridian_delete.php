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
      <div class="col-sm-7">
        <?php
        $id = $_GET['id'];
        $query = "DELETE FROM tbl_meridian WHERE  meridianID= '$id' ";
        $delete = mysql_query($query);
        if ($delete) {
          include("includes/success.php");
        } else {
          include("includes/error.php");
        }
        ?>
      </div>
      <div class="col-sm-5">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            CURRENT LIST </header>
          <div class="panel-body"><?php include("includes/meridian_list.php"); ?></div>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>