<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">ADD TEST</div>
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
            NEW TEST REGISTRATION</header>
          <div class="panel-body">
          </div>
          <div class="card-body ">
            <div class="table-wrap">
              <div class="table-responsive">
                <?php
                  $today = date('Y-m-d');
                  $unit = $userRow['unit'];
                  $query = mysql_query("SELECT COUNT(*) as count FROM tbl_samples as s 
                      LEFT JOIN tbl_sample_techs as u ON s.taken_by = u.id 
                      WHERE s.delivery_time > '$today' AND u.business_unit = $unit");
                  $lastSample = mysql_fetch_array($query);
                  $num = $lastSample['count'] < 9 ? '0' . $lastSample['count'] + 1 : $lastSample['count'] + 1;
                  $unitQ = mysql_query("select * from tbl_business_units where unitID = $unit");
                  $unitRow = mysql_fetch_array($unitQ);
                  $lastSample = mysql_fetch_array($query);
                  $sampleNumber = date('Ymd') . '-' . $unitRow['shortname'] . '-' . $num;
                  $contract = $_POST['contract'];
                  $color = $_POST['color'];
                  $size = $_POST['size'];
                  $taken_by = $_POST['taken_by'];
                  $delivered_to = $_POST['delivered_to'];
                  $collection_time = $_POST['collection_time'];
                  $sample_id = $_POST['sample_id'];
                  $arf_doc = '';
                  if (!empty($_FILES['arf_doc'])) {
                    $path = "images/analysis/";
                    $path = $path . basename($_FILES['arf_doc']['name']);
                    if (move_uploaded_file($_FILES['arf_doc']['tmp_name'], $path)) {
                      $arf_doc = basename($_FILES['arf_doc']['name']);
                    }
                  }
                  $arf_doc = $arf_doc != '' ? "'$arf_doc'" : 'NULL';
                  $record = "INSERT INTO tbl_samples (`sample_number`,`contract_id`,`color`,`size`,`taken_by`,`delivered`,`collection_time`, `sample_id`,`arf_doc`) "
                    . "VALUES ('$sampleNumber',$contract,$color,'$size',$taken_by,'$delivered_to','$collection_time', '$sample_id',$arf_doc)";
                  try {
                    $add = mysql_query($record);
                    if (mysql_error()) {
                      $message = $record . " " . mysql_error() .  " " . mysql_errno();
                      $add = 'error';
                    } else {
                      $id = mysql_insert_id();
                      $vehicles = [];
                      $keys = array_keys($_POST);
                      foreach ($keys as $key) {
                        if (startsWith($key, 'vehicle_number_') && $_POST[$key] != '') {
                          $vehicles[] = $_POST[$key];
                        }
                      }
                      foreach ($vehicles as $vehicle) {
                        mysql_query("INSERT INTO vehicles (`sample_id`,`reg_number`) VALUES ($id, '$vehicle')");
                      }

                      $table_sample_id = $id;
                      $blend_batch_num = $_POST['blend_batch_num'] ?? '';
                      $res = mysql_query("SELECT tbl_system_users.country, tbl_system_users.unit, tbl_business_units.shortname  FROM tbl_system_users LEFT JOIN tbl_business_units on tbl_business_units.unitID = tbl_system_users.unit WHERE userID=" . $_SESSION['user']);
                      $userRow = mysql_fetch_array($res);
                      $today = date('Y-m-d');
                      $unit = $userRow['unit'];
                      $query = mysql_query("SELECT COUNT(*) as count FROM tbl_batches as b 
                      LEFT JOIN tbl_system_users as u ON b.doneBy = u.userID 
                      WHERE b.sampleDate > '$today' AND u.unit = $unit");
                      $lastBatch = mysql_fetch_array($query);
                      $num = $lastBatch['count'] < 9 ? '0' . $lastBatch['count'] + 1 : $lastBatch['count'] + 1;
                      $batch = date('Ymd') . '-' . $userRow['shortname'] . '-' . $num;
                      $record = "INSERT INTO tbl_batches (size,batchNum, blendBatchNum ,sample_id,contractID,doneBy) VALUES ('" . $size . "','$batch', '$blend_batch_num',$table_sample_id,'" . addslashes($contract) . "','" . $myID . "')";
                      global $insert_id;
                      $insert_id = null;
                      $add = mysql_query($record) or die(mysql_error());
                      $batch_id = mysql_insert_id();
                      echo "Batch added Successfully";
                      header("Location: analysis_add.php?id=$batch_id");
                    }
                  } catch (Throwable $th) {
                    $add = 'error';
                    $message = $th;
                    echo $message;
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