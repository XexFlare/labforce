  <?php include("includes/header.php");
  include("includes/helpers.php");
  $batch = $_GET['id'];
  $test = null;
  if (isset($_GET['test']))
    $test = $_GET['test'];
  else {
    $query = mysql_query("SELECT testID from tbl_tests WHERE batchID=$batch ORDER BY testID DESC");
    if ($testResults = mysql_fetch_assoc($query))
      $test = $testResults['testID'];
  }
  $type = isset($_GET['type']) ? $_GET['type'] : "chemical";
  $query = "SELECT *, tbl_samples.size FROM tbl_batches 
  LEFT JOIN tbl_contracts on tbl_contracts.contractID = tbl_batches.contractID
  LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = tbl_contracts.fertilizer_name
  LEFT JOIN tbl_samples on tbl_samples.id = tbl_batches.sample_id
  WHERE batchID='$batch'";
  $results = mysql_query($query);
  $nrows = mysql_num_rows($results);
  while ($batches = mysql_fetch_array($results)) {
    extract($batches);
  }
  if (isset($_POST['submit'])) {
    switch ($type) {
      case 'physical':
        $field_names = ['batch_id', 'mean_particle_size', 'fine_particles', 'coarse_particles', 'mean_range', 'gsi', 'avg_shear_strength'];
        insert($field_names, array_merge($_POST, ['batch_id' => $batch]), 'physical_analysis');
        break;
      case 'damage':
        $field_names = ['test_id', 'color_diff', 'granular_size', 'idf_granules', 'foreign_matter', 'lump_percentage'];
        insert($field_names, array_merge($_POST, ['test_id' => $test]), 'damage_analysis');
        break;
      case 'visual':
        $field_names = [
          'test_id', 'uniform', 'damaged_by', 'damaged_by_other', 'included',
          ['uniform_color' => 'checkbox'], ['uniform_size_distribution' => 'checkbox'],
          ['clean_package' => 'checkbox'], ['uniform_seal' => 'checkbox'],
          ['damaged' => 'checkbox'], ['separated' => 'checkbox']
        ];
        insert($field_names, array_merge($_POST, ['test_id' => $test]), 'visual_inspections');
        $vis = ['batchID' => $batch, 'testID' => $test, 'item' => 'Visual Inspection'];
        insert(array_keys($vis), $vis, 'tbl_analysis');
        break;
      case 'comment':
        $execremarks = $_POST['execremarks'];
        $comments = isset($_POST['comments']) ? join(', ', array_keys($_POST['comments'])) : null;
        $record = "UPDATE tbl_analysis SET exec_remarks = '" . $execremarks . "', exec_comments = '$comments', qa_comments_by = $myID WHERE testID = " . $test;
        $add = mysql_query($record) or die(mysql_error());
        $query = "SELECT a.*, fert.fertilizer, fert.fertilizerID, co.meridian_contract, co.is_blend
          FROM tbl_analysis AS a
          LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
          LEFT JOIN tbl_contracts AS co ON b.contractID = co.contractID
          LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = co.fertilizer_name
          WHERE testID = " . $test;
        $results = mysql_query($query);
        $current = mysql_fetch_array($results);
        $lowerLimit = getFertilizerLimits($current['fertilizerID'], FertLimit::LOWER);
        $upperLimit = getFertilizerLimits($current['fertilizerID'], FertLimit::UPPER);
        $specs = compareLimits($current, $lowerLimit, $upperLimit, $current['is_blend']);
        if ($current['exec_comments'] != null) {
          $res = mysql_query("select file from tbl_photos
            WHERE parent_id={$current['analysisID']} AND parent_type='test'
            OR parent_id={$current['batchID']} AND parent_type='batch'");
          $images = [];
          while ($img = mysql_fetch_array($res)) {
            $images[] = "./images/analysis/{$img['file']}";
          }
          if ($comments) {
            $res = file_get_contents(getenv('FORCEHUB_URL') . '/api/paradigm-shift', false, stream_context_create([
              'http' => [
                'method' => 'POST',
                'content' => http_build_query([
                  "resource" => 'tests',
                  'type' => 'bad',
                  'value' => 1
                ])
              ]
            ]));
          }
          sendWarningEmail($current['analysisID'], $current['fertilizer'], $current['meridian_contract'], $current['exec_comments'], $current, $upperLimit, $lowerLimit, $images);
        }
        break;
      case 'lab_comment':
        $labcomments = $_POST['labcomments'];
        $record = "UPDATE tbl_analysis SET lab_comments = '" . $labcomments . "', lab_comments_by = $myID WHERE testID = " . $test;
        $add = mysql_query($record) or die(mysql_error());
        break;
      default:
        $comments;
        if ($myLevel == 1 || $myLevel == 3) {
          $prev = mysql_query("SELECT * FROM tbl_analysis where testID = $test");
          if ($analysis = mysql_fetch_assoc($prev)) {
            $field_names = ['moisture', 'n', 'p2o5', 'k2o', 's', 'b', 'zn', 'pH', 'total'];
            update($field_names, array_merge($_POST, ['batchID' => $batch, 'testID' => $test]), ['analysisID' => $analysis['analysisID']], 'tbl_analysis');
            $analysisID = $analysis['analysisID'];
          } else {
            $field_names = ['batchID', 'testID', 'item', 'moisture', 'n', 'p2o5', 'k2o', 's', 'b', 'zn', 'pH', 'total', 'exec_remarks'];
            insert($field_names, array_merge($_POST, ['batchID' => $batch, 'testID' => $test]), 'tbl_analysis');
            $analysisID =  mysql_insert_id();
          }
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
          if (count($specs) > 0) {
            $res = mysql_query("select file from tbl_photos
                        WHERE parent_id=$analysisID AND parent_type='test'
                        OR parent_id={$current['batchID']} AND parent_type='batch'");
            $images = [];
            while ($img = mysql_fetch_array($res)) {
              $images[] = "./images/analysis/{$img['file']}";
            }
            sendWarningEmail($current['analysisID'], $current['fertilizer'], $current['meridian_contract'], 'Out-Of-Spec', $current, $upperLimit, $lowerLimit, $images);
          }
        }
        $query = "SELECT a.*, fert.fertilizer, fert.fertilizerID, co.meridian_contract, co.is_blend
          FROM tbl_analysis AS a
          LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
          LEFT JOIN tbl_contracts AS co ON b.contractID = co.contractID
          LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = co.fertilizer_name
          WHERE analysisID=$analysisID";
        $results = mysql_query($query);
        $row = $current ?? mysql_fetch_array($results);
        break;
    }
  }
  ?>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">
              <h5>Fertilizer: <font color="#FF0000"><?php echo "$fertilizer"; ?> </font>Blend: <font color="#FF0000"><?php echo "$blend"; ?></font> Batch #: <font color="#FF0000"><?php echo "$batchNum"; ?></font> Sample#: <font color="#FF0000"><?php echo "$sampleNum"; ?></font> Date: <font color="#FF0000"><?php echo "$sampleDate"; ?></font>
              </h5>
            </div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li>Analysis</i>
            </li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-sm-8">
              <div class="card card-topline-lightblue">
                <div class="card-head">
                  <header>SAMPLE TESTS</header>
                  <div class="btn-group">
                    <a href="test_record.php?id=<?php echo "$batch"; ?>" id="addRow" class="btn btn-info">
                      Add sample Test <i class="fa fa-plus"></i>
                    </a>
                    <a href="analysis_add.php?id=<?php echo "$batch&test=$test&type=physical"; ?>" class="btn btn-info">
                      Physical Analysis <i class="fa fa-plus"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body" id="line-parent">
                  <div class="panel-group accordion" id="accordion3">
                    <?php
                    $data = mysql_fetch_assoc(mysql_query("select count(*) as count from tbl_photos 
                      left join tbl_tests on tbl_tests.batchID = $batch
                      where parent_type='test'
                      and parent_id in(tbl_tests.testID)"));
                    $hasTestPhotos = $data['count'] != 0;
                    if (!$hasTestPhotos)
                      include("includes/batch_images.php");
                    $query  = "SELECT * FROM tbl_tests WHERE batchID='$batch' ORDER BY testID ASC";
                    $results = mysql_query($query);
                    $i = mysql_numrows($results);
                    while ($row = mysql_fetch_array($results)) {
                      extract($row);
                      include("batch_tests.php");
                      if ($hasTestPhotos)
                        include("includes/test_images.php");
                      $i--;
                    }
                    ?>
                  </div>
                </div>
                <?php
                $query1 = "SELECT * FROM physical_analysis WHERE batch_id=$batchID";
                $results21 = mysql_query($query1);
                $physicals = mysql_fetch_array($results21);
                if (isset($physicals['mean_particle_size'])) { ?>
                  <div class="ml-4 mr-4 mb-4">
                    <h4>Physical Analysis</h4>
                  <?php physicalAnalysis($physicals, $size); echo "</div>"; }
                  ?>
                  </div>
              </div>
              <div class="col-sm-4">
                <div class="card card-topline-yellow">
                  <div class="card-head">
                    <header>Analysis Capturing Form</header>
                    <div class="tools">
                      <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                      <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                      <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                  </div>
                </div>
                <?php if($test != null) { ?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 col-sm-12">
                      <div class="card card-box">
                        <div class="card-body">
                          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'] . '&test=' . $test . '&type=' . $type; ?>" class="form-horizontal">
                            <div class="form-body">
                              <?php
                              switch ($type) {
                                case 'physical':
                                  include("includes/form_analysis_physical.php");
                                  break;
                                case 'visual':
                                  include("includes/form_analysis_visual.php");
                                  break;
                                case 'damage':
                                  include("includes/form_analysis_damage.php");
                                  break;
                                case 'comment':
                                  include("includes/form_analysis_comment.php");
                                  break;
                                case 'lab_comment':
                                  include("includes/form_analysis_lab_comment.php");
                                  break;
                                case 'chemical':
                                default:
                                  include("includes/form_analysis_chemical.php");
                                  break;
                              }
                              ?>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> <?php } ?>
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