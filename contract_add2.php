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
        $contract = $_POST['contract'];
        $fertilizer = $_POST['fertilizer'];
        $supplier = $_POST['supplier'];
        $vessel = $_POST['vessel'];
        $blend = $_POST['blend'];
        $country = $_POST['country'];
        $reference = $_POST['reference'];
        $contractDate = $_POST['contractDate'];
        $query = "INSERT INTO tbl_contracts 
          (meridian_contract,fertilizer_name,staff, contractDate, vessel, blend_type_id, supplier_id, country_id, acc_reference)
           VALUES ('" . addslashes($contract) . "','" . $fertilizer . "',
           '" . $myID . "','" . $contractDate . "', '$vessel', '" . addslashes($blend) . "', '" . addslashes($supplier) . "',$country, '$reference')";
        $done = mysql_query($query) or die(mysql_error());
        $query = "SELECT contractID FROM tbl_contracts ORDER BY contractID DESC LIMIT 1";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $id = $row[0];
        $moisture = $_POST['moisture'];
        $n = $_POST['n'];
        $p2o5 = $_POST['p2o5'];
        $k2o = $_POST['k2o'];
        $s = $_POST['s'];
        $b = $_POST['b'];
        $zn = $_POST['zn'];
        $total = $_POST['total'];
        $target_dir = "uploads/manufacturer/";
        $target_file = $target_dir . uniqid('MAN', true) . basename($_FILES["results"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_FILES["results"]["tmp_name"]) && $_FILES["results"]["tmp_name"] != null) {
          $check = getimagesize($_FILES["results"]["tmp_name"]);
          if ($check !== false) {
            $uploadOk = 1;
            if (!move_uploaded_file($_FILES["results"]["tmp_name"], $target_file)) {
              $target_file = '';
            }
          } else {
            $uploadOk = 0;
            $target_file = '';
          }
        } else {
          $uploadOk = 0;
          $target_file = '';
        }
        $query = "INSERT INTO tbl_manufacturer_results 
          (contract_id,moisture,n,p2o5,k2o,s,b,zn,total,filename)
           VALUES ($id,'$moisture','$n','$p2o5','$k2o','$s','$b','$zn','$total','$target_file')";
        $done = mysql_query($query) or die(mysql_error());
        // echo $upload;
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
          <div class="panel-body"><?php include("includes/contract_list.php"); ?></div>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>