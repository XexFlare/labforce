<?php include("includes/header.php");
if (isset($_POST['submit'])) {
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
        if(startsWith($key, 'vehicle_number_') && $_POST[$key] != '') {
          $vehicles[] = $_POST[$key];
        }
      }
      foreach ($vehicles as $vehicle) {
        mysql_query("INSERT INTO vehicles (`sample_id`,`reg_number`) VALUES ($id, '$vehicle')");
      }
      header("Location: sample.php?id=$id");
    }
  } catch (Throwable $th) {
    $add = 'error';
    $message = $th;
  }
}
?>
  <div id="top"></div>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">Samples</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Dashboard</li>
          </ol>
        </div>
      </div>
      <?php if (isset($add) && $add === true) {
        $hideBack = true;
        include("includes/success.php");
      } else if (isset($add) && $add == 'error') {
        $hideBack = true;
        include("includes/error.php");
      }
      ?>
      <style>
        .mdl-menu__outline {
          max-height: 350px;
          overflow-y: scroll;
        }
        .mdl-menu{
          max-height: 350px;
          overflow-y: scroll;  
        }
      </style>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel">
                <div class="panel-body">
                  <div class="panel tab-border card-topline-aqua">
                    <div class="card-body ">
                      <form action="samples_add.php" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <div class="card-box">
                          <div class="card-head">
                            <header>Sample Details</header>
                          </div>
                          <div class="card-body row">
                            <div class="col-lg-12">
                              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:650px; max-height: 350px ">
                                <input type="text" value="" class="mdl-textfield__input readonly" id="contract" autocomplete="off" required>
                                <input type="hidden" value="" name="contract">
                                <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                <label for="contract" class="mdl-textfield__label">Contract</label>
                                <ul for="contract" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                  <?php
                                  $query = "select tbl_contracts.*, tbl_fertilizer_types.fertilizer from tbl_contracts, tbl_fertilizer_types WHERE tbl_contracts.fertilizer_name = tbl_fertilizer_types.fertilizerID AND tbl_contracts.hidden = 0 ORDER BY tbl_fertilizer_types.fertilizer, tbl_contracts.meridian_contract ASC";
                                  $result = mysql_query($query) or die("Couldn't execute query.");
                                  while ($row = mysql_fetch_array($result)) {
                                    extract($row);
                                    $date = date("d M Y", strtotime($contractDate));
                                    echo "<li class='mdl-menu__item' data-val='$contractID'>$fertilizer - $meridian_contract - $date</li>";
                                  }
                                  ?>
                                </ul>
                              </div>
                            </div>
                            <div class="col-lg-8">
                              <div class="mdl-textfield mdl-js-textfield">
                                <label class="mdl-textfield__label" for="sampleID">Sample ID</label>
                                <input type="text" id="sampleID" class="mdl-textfield__input" placeholder="Sample ID" name="sample_id" style="width:450px;">
                              </div>
                            </div>
                            <div class="col-lg-8">
                              <label class="control-label text-muted">ARF Document</label>
                              <div class="form-group row">
                                <div class="compose-editor">
                                  <input type="file" name="arf_doc" class="default">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-8 row">
                              <div class="col">
                                <div class="mdl-textfield mdl-js-textfield">
                                  <label class="mdl-textfield__label" for="vehicleNumber">Vehicle Number</label>
                                  <input type="text" id="vehicleNumber" class="mdl-textfield__input" placeholder="Vehicle Number" name="vehicle_number_1" style="width:450px;">
                                </div>
                              </div>
                              <div class="col">
                                <div class="btn btn-secondary" id="addvehicle" onclick="addVehicle()">Add</div>
                              </div>
                            </div>
                            <div id="vehicles" class="col-lg-8 row"></div>
                              <div class="col-lg-8">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:450px;">
                                  <input type="text" value="" class="mdl-textfield__input readonly" id="color" autocomplete="off" required>
                                  <input type="hidden" value="" name="color">
                                  <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                  <label for="color" class="mdl-textfield__label">Color</label>
                                  <ul for="color" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <?php
                                    $query = "SELECT * FROM tbl_colors ORDER BY color ASC";
                                    $result = mysql_query($query) or die("Couldn't execute query.");
                                    while ($row = mysql_fetch_array($result)) {
                                      extract($row);
                                      echo "<li class='mdl-menu__item' data-val='$colorID'>$color</li>";
                                    }
                                    ?>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:450px;">
                                  <input type="text" value="" class="mdl-textfield__input readonly" id="size" autocomplete="off" required>
                                  <input type="hidden" value="" name="size">
                                  <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                  <label for="size" class="mdl-textfield__label">Size</label>
                                  <ul for="size" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <li class='mdl-menu__item' data-val='Granular'>Granular</li>
                                    <li class='mdl-menu__item' data-val='Prilled'>Prilled</li>
                                    <li class='mdl-menu__item' data-val='Crystaline'>Crystaline</li>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <div class="mdl-textfield mdl-js-textfield getmdl-select" style="width:450px;">
                                  <input type="text" value="" class="mdl-textfield__input" id="taken_by" autocomplete="off" required>
                                  <input type="hidden" value="" name="taken_by">
                                  <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                  <label for="taken_by" class="mdl-textfield__label">Taken By</label>
                                  <ul for="taken_by" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <?php
                                    $query = "SELECT * FROM tbl_sample_techs ORDER BY name ASC";
                                    $result = mysql_query($query) or die("Couldn't execute query.");
                                    while ($row = mysql_fetch_array($result)) {
                                      extract($row);
                                      echo "<li class='mdl-menu__item' data-val='$id'>$name</li>";
                                    }
                                    ?>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <div class="mdl-textfield mdl-js-textfield getmdl-select" style="width:450px;">
                                  <input type="text" value="" class="mdl-textfield__input" id="delivered_to" autocomplete="off" required>
                                  <input type="hidden" value="" name="delivered_to">
                                  <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                                  <label for="delivered_to" class="mdl-textfield__label">Delivered To</label>
                                  <ul for="delivered_to" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <li class='mdl-menu__item' data-val='Lab Tech'>Lab Tech</li>;
                                    <li class='mdl-menu__item' data-val='Chemist I'>Chemist I</li>;
                                    <li class='mdl-menu__item' data-val='Chemist II'>Chemist II</li>;
                                  </ul>
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <div class="mdl-textfield mdl-js-textfield">
                                  <label class="mdl-textfield__label" for="date">Time Of Collection</label>
                                  <input type="text" id="date" class="mdl-textfield__input" placeholder="Time Of Collection" name="collection_time" style="width:450px;" required>
                                </div>
                              </div>
                            </div>
                          <div class="col-lg-12 p-x-20">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name="submit">
                              Add Sample
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>
<script src="assets/jquery.min.js"></script>
<script src="assets/material/material.min.js"></script>
<script src="assets/getmdl-select.js?v=1.0.1"></script>
<script src="assets/material-datetimepicker/moment-with-locales.min.js"></script>
<script src="assets/material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
<script>
  var vehicles = 1;
  function addVehicle(){
    $("#vehicles").append('<div class="col-lg-8"><div class="mdl-textfield mdl-js-textfield"><input type="text" id="vehicleNumber" class="mdl-textfield__input" placeholder="Vehicle Number" name="vehicle_number_' + ++vehicles + '" style="width:450px;"></div></div>')
  }
  $(".readonly").on('keydown paste focus mousedown', function(e) {
    if (e.keyCode != 9)
      e.preventDefault();
  });
  $(function() {
    $('#date').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm'
        });
  });
</script>
</body>

</html>