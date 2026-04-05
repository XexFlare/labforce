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
                  $fertilizer = $_POST['fertilizer'];
                  $color = $_POST['color'];
                  $size = $_POST['size'];
                  $supplier = $_POST['supplier'];
                  $sample = $_POST['sample'];
                  $batch = $_POST['batch'];
                  $contract = $_POST['contract'];
                  $batchID = $_POST['batchID'];
                  //$record = "INSERT INTO tbl_batches (fertilizerType,color,size,shipID,supplierID,batchNum,sampleNum,contractID,meridianID,doneBy) VALUES ('".$fertilizer."','".addslashes($color)."','".$size."','".$ship."','".$supplier."','".addslashes($batch)."','".addslashes($sample)."','".addslashes($contract)."','".addslashes($meridian)."','".$myID."')";
                  //$add=mysql_query($record) or die(mysql_error());
                  //echo $add;
                  $update  = "UPDATE tbl_batches SET fertilizerType = '$fertilizer', color = '$color',size = '$size',supplierID = '$supplier',batchNum = '$batch',sampleNum = '$sample',contractID = '$contract' WHERE batchID ='$batchID'";
                  $query = mysql_query($update) or die(mysql_error());
                  echo $update;
                  if ($query) {
                    echo "Success";
                  } else {
                    echo "Failed";
                  }
                  header("Location: batches.php#top");
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