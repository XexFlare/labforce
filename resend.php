<?php include("includes/header.php");
include('includes/helpers.php');
$server = getenv('APP_URL');
?>
 
   
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">RESEND</div>
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
              RESEND
            </header>
            <div class="panel-body">
            </div>
            <div class="card-body ">
              <div class="table-wrap">
                <div class="table-responsive">
                  <?php if (!$_GET['confirm']) { ?>

                    Are you sure you want to resend this test?

                    <div style='margin: 10px 0;'><a href='<?php echo "$server/resend.php?id={$_GET['id']}&confirm=1"; ?>' style='padding: 10px; background-color: #067b3a; color: #fff;'>Send Email</a></div>
                  <?php } else {
                    $analysisID =  $_GET['id'];
                    $query = "SELECT a.*, fert.fertilizer, fert.fertilizerID, co.meridian_contract, co.is_blend
                    FROM tbl_analysis AS a
                    LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
                    LEFT JOIN tbl_contracts AS co ON b.contractID = co.contractID
                    LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = co.fertilizer_name
                    WHERE analysisID=$analysisID";
                    $results = mysql_query($query);
                    $current = mysql_fetch_array($results);
                    $lowerLimit = getFertilizerLimits($current['fertilizerID'], FertLimit::LOWER);
                    $upperLimit = getFertilizerLimits($current['fertilizerID'], FertLimit::UPPER);
                    $specs = compareLimits($current, $lowerLimit, $upperLimit, $current['is_blend']);
                    if ($current['exec_comments'] != null) {
                      $res = mysql_query("select file from tbl_photos
                        WHERE parent_id=$analysisID AND parent_type='test'
                        OR parent_id={$current['batchID']} AND parent_type='batch'");
                      while ($row = mysql_fetch_array($res)) {
                        $images[] = "./images/analysis/{$row['file']}";
                      }
                      sendWarningEmail($current['analysisID'], $current['fertilizer'], $current['meridian_contract'], $current['exec_comments'], $current, $upperLimit, $lowerLimit, $images);
                    }
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
    </body>

    </html>