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
      <?php
      if (isset($_POST['submit'])) {
        $target_dir = "uploads/reports/";
        $target_file = $target_dir . basename($_FILES["report"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;
        if (move_uploaded_file($_FILES["report"]["tmp_name"], $target_file)) {
          $query = "INSERT INTO tbl_uploads
          (name,location)
           VALUES ('Directors Report','$target_file')";
          $done = mysql_query($query) or die(mysql_error());
        } else {
          $uploadOk = 0;
          $target_file = '';
        }

        if ($uploadOk) {
          echo "The report has been uploaded";
        } else echo "Üpload Failed";
      }
      ?>
      <div class="row">
        <div class="col-sm-6">
          <form action="directors_report.php" id="form_sample_1" class="form-horizontal" method="POST" enctype="multipart/form-data">
            <div class="card-box">
              <div class="card-head">
                <header>Directors Report</header>
              </div>
              <div class="card-body row">
                <div class="col-lg-6 p-t-20">
                  <div class="">
                    <label class="" for="report">Directors Report</label>
                    <input class="" type="file" name="report" required>
                  </div>
                </div>
                <div class="col-lg-12 p-t-20">
                  <button type="submit" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Upload
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
    </div>
    <?php include("includes/javascript_includes.php"); ?>
  </body>
  </html>