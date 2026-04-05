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
                  $color = $_POST['color'];
                  $moisture = $_POST['moisture'];
                  $grade = $_POST['grade'];
                  $particle_size = $_POST['particle_size'];
                  $foreign_matter = $_POST['foreign_matter'];
                  $appearance = $_POST['appearance'];
                  $approx_age = $_POST['approx_age'];
                  $origin = $_POST['origin'];
                  $approx_tonnage = $_POST['approx_tonnage'];
                  $contract = $_POST['contract'];
                  
                  $res = mysql_query("SELECT tbl_system_users.country, tbl_system_users.unit, tbl_business_units.shortname  FROM tbl_system_users LEFT JOIN tbl_business_units on tbl_business_units.unitID = tbl_system_users.unit WHERE userID=" . $_SESSION['user']);
                  $userRow = mysql_fetch_array($res);
                  $today = date('Y-m-d');
                  $unit = $userRow['unit'];
                  $query = mysql_query("SELECT COUNT(*) as count FROM sweepings as b 
                    LEFT JOIN tbl_system_users as u ON b.done_by = u.userID 
                    WHERE b.date > '$today' AND u.unit = $unit");
                  $lastBatch = mysql_fetch_array($query);
                  $num = $lastBatch['count'] < 9 ? '0' . $lastBatch['count'] + 1 : $lastBatch['count'] + 1;
                  $batch = date('Ymd') . '-' . $userRow['shortname'] . '-' . $num;
                  $record = "INSERT INTO sweepings (color,grade,moisture,particle_size,foreign_matter,appearance,approx_age,origin,approx_tonnage,done_by,sweeping_num, contract_id, date) VALUES ('$color','$grade','$moisture' ,'$particle_size','$foreign_matter','$appearance' ,'$approx_age' ,'$origin','$approx_tonnage','$myID','$batch',$contract, now())";
                  $add = mysql_query($record) or die(mysql_error());
                  $id = mysql_insert_id();
                  echo "Batch added Successfully";
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