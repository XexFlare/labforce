<?php
if ($myLevel == 1) $query = "SELECT COUNT(*) as count FROM tbl_tests";
else if ($myLevel == 2) $query = "SELECT COUNT(*) as count FROM tbl_tests WHERE countryID = $myCountry";
else $query = "SELECT COUNT(*) as count FROM tbl_tests WHERE countryID = $myCountry";
if (isset($executive) && $executive == true && $myLevel == 1)
  $query  = "SELECT COUNT(*) as count FROM tbl_tests 
  LEFT JOIN tbl_batches ON tbl_batches.batchID = tbl_tests.batchID
  LEFT JOIN tbl_contracts ON tbl_contracts.contractID = tbl_batches.contractID
  WHERE tbl_contracts.fertilizer_name = '49'";
if (isset($executive) && $executive == true && $myLevel == 2)
  $query  = "SELECT COUNT(*) as count FROM tbl_tests, tbl_batches WHERE tbl_tests.batchID = tbl_batches.batchID AND tbl_batches.fertilizerType = '49' AND tbl_tests.countryID = $myCountry";
$count = mysql_query($query);
$tests = mysql_fetch_row($count);
$query = "SELECT COUNT(*) as count FROM tbl_contracts
RIGHT JOIN tbl_batches on tbl_batches.contractID = tbl_contracts.contractID
RIGHT JOIN tbl_analysis on tbl_analysis.batchID = tbl_batches.batchID
WHERE tbl_contracts.is_blend = 1
;";
$count = mysql_query($query);
$blends = mysql_fetch_row($count);
if (isset($executive) && $executive == true) {
  $query  = "SELECT * FROM tbl_uploads WHERE name = 'Directors Report'";
  $result = mysql_query($query);
  $report = mysql_fetch_row($result);
} else {
  $query  = "SELECT COUNT(*) as count FROM tbl_fertilizer_types";
  $count = mysql_query($query);
  $products = mysql_fetch_row($count);
}
$query  = "SELECT COUNT(*) as count FROM tbl_suppliers";
$count = mysql_query($query);
$suppliers = mysql_fetch_row($count);
?>
<div class="state-overview">
  <div class="row">
    <div class="col-xl-3 col-md-6 col-12">
      <div class="info-box bg-gr1">
        <span class="info-box-icon push-bottom"><i class="material-icons">reorder</i></span>
        <div class="info-box-content">
          <span class="info-box-text">LAB TESTS</span>
          <span class="info-box-number" data-counter="counterup" data-value="<?php echo $tests[0]; ?>"></span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
      <div class="info-box bg-gr2">
        <span class="info-box-icon push-bottom"><i class="material-icons">group</i></span>
        <div class="info-box-content">
          <span class="info-box-text">BLEND RESULTS</span>
          <span class="info-box-number" data-counter="counterup" data-value="<?php echo $blends[0]; ?>"></span>
          <div class="progress">
            <div class="progress-bar" style="width: 40%"></div>
          </div>

        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
      <div class="info-box bg-gr3">
        <span class="info-box-icon push-bottom"><i class="material-icons">directions_bus</i></span>
        <div class="info-box-content">
          <span class="info-box-text">SUPPLIERS</span>
          <span class="info-box-number" data-counter="counterup" data-value="<?php echo $suppliers[0]; ?>"></span>

          <div class="progress">
            <div class="progress-bar" style="width: 85%"></div>
          </div>

        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
      <?php
      if (isset($executive) && $executive == true) {
        ?>
        <a href="<?php echo $report[2]; ?>">
          <div class="info-box bg-gr4">
            <span class="info-box-icon push-bottom"><i class="material-icons">description</i></span>
            <div class="info-box-content">

              <span class="info-box-text">DOWNLOAD</span>
              <span class="info-box-number">REPORT</span>
              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
            </div>
          </div>
        </a>
      <?php } else {
      ?>
        <div class="info-box bg-gr4">
          <span class="info-box-icon push-bottom"><i class="material-icons">description</i></span>
          <div class="info-box-content">
            <span class="info-box-text">FERTILIZER PRODUCTS</span>
            <span class="info-box-number" data-counter="counterup" data-value="<?php echo $products[0]; ?>"></span>
            <div class="progress">
              <div class="progress-bar" style="width: 50%"></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>