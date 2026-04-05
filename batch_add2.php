<?php 
include("includes/header.php");
$contract = isset($_POST['contract']) ? trim(urldecode($_POST['contract'])) : '';
$query = "select * from tbl_contracts, tbl_fertilizer_types WHERE tbl_contracts.contractID = $contract AND tbl_contracts.fertilizer_name = tbl_fertilizer_types.fertilizerID";
$result = mysql_query($query) or die("Couldn't execute query.");
$row = mysql_fetch_assoc($result);
extract($row);
$date = date("d M Y", strtotime($contractDate));


?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">SAMPLE ANALYSIS BATCH</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-sm-12">
            <div class="panel tab-border card-topline-aqua">
              <header class="panel-heading panel-heading-gray custom-tab">
                <div id="myProgress">
                  <div id="myBar" style="width: 100%;">100%</div>
                </div>
                <h3>Details</h3>
                <div class="row">
                  <div class="col-md-6">
                    <p><b>Contract:</b> <?php echo $meridian_contract; ?></p>
                    <p><b>Fertilizer:</b> <?php echo $fertilizer; ?></p>
                    <p><b>Blend:</b> <?php echo $blend; ?></p>
                  </div>
                  <div class="col-md-6">
                    <p><b>Date:</b> <?php echo $date; ?></p>
                    <p><b>Formula:</b> <?php echo $formula; ?></p>
                    <p><b>Vessel Name:</b> <?php echo $ship_name; ?></p>
                  </div>
                </div>
                <!--PROGRESS -->
                
              </header>
              <form action='test_add2b.php' id="form_sample_1" class="form-horizontal" method="POST">
                <br>
                <div class="m-3">
                  <div class="row">
                    <div class="col-lg-6">
                      <?php if($is_blend) { ?>
                        <div class="form-group">
                          <label for="blend_batch_num" class="text-muted">Blend Batch No:</label>
                          <input type="text" class="form-control" id="blend_batch_num" name="blend_batch_num" required>
                        </div>
                      <?php } ?>
                      <div class="form-group">
                        <label for="sampleID" class="text-muted">Sample ID</label>
                        <input type="text" class="form-control" id="sampleID" name="sample_id" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label text-muted">ARF Document</label>
                        <div class="form-group row">
                          <div class="compose-editor">
                            <input type="file" name="arf_doc" class="default">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label text-muted" for="vehicleNumber">Vehicle</label>
                        <div class="input-group">
                          <input type="text" class="form-control" name="vehicle_number_1" placeholder="License Number" aria-label="Recipient's username" aria-describedby="basic-addon2">
                          <div class="input-group-append ml-3">
                            <button class="btn btn-secondary" onclick="addVehicle()">ADD</button>
                          </div>
                        </div>
                      </div>
                      <div id="vehicles" class="form-group"></div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1" class="text-muted">Sample Color</label>
                        <select class="form-control" name="color" id="exampleFormControlSelect1" required>
                          <option value="">Select here...</option>
                          <?php
                            $query = "SELECT * FROM tbl_colors ORDER BY color ASC";
                            $result = mysql_query($query) or die("Couldn't execute query.");
                            while ($row = mysql_fetch_array($result)) {
                              extract($row);
                              echo "<option value='$colorID'>$color</option>";
                            }
                            ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1" class="text-muted">Sample Size</label>
                        <select class="form-control" name="size" id="exampleFormControlSelect1" required>
                          <option>Select here...</option>
                          <option value="Granular">Granular</option>
                          <option value="Prilled">Prilled</option>
                          <option value="Crystaline">Crystaline</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1" class="text-muted">Taken By</label>
                        <select class="form-control" name="taken_by" id="exampleFormControlSelect1" required>
                          <option>Select here...</option>
                          <?php
                            $query = "SELECT * FROM tbl_sample_techs ORDER BY name ASC";
                            $result = mysql_query($query) or die("Couldn't execute query.");
                            while ($row = mysql_fetch_array($result)) {
                              extract($row);
                              echo "<option  value='$id'>$name</option>";
                            }
                            ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1" class="text-muted">Delivered To</label>
                        <select class="form-control" name="delivered_to" id="exampleFormControlSelect1" required>
                          <option>Select Personnel</option>
                          <option value="Lab Tech">Lab Tech</option>
                          <option value="Chemist I">Chemist I</option>
                          <option value="Chemist II">Chemist II</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="text-muted" for="collection_time">Time Of Collection</label>
                        <input type="text" class="form-control" id="datetime" placeholder="Time Of Collection" name="collection_time" required>
                      </div>
                    </div>
                  </div>
                  <input name="contract" type="hidden" value="<?php echo "$contract"; ?>">
                  <div class="form-actions">
                    <div class="d-flex">
                    <button type="submit" class="btn btn-info">Proceed >></button>
                    <a href="batch_add.php"><button type="button" class="btn btn-default">Cancel</button></a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
  </div>
</div>

<?php include("includes/javascript_includes.php"); ?>
<script>
  var vehicles = 1;

  function addVehicle() {
    $("#vehicles").append('<div class="input-group"><input type="text" class="form-control" placeholder="License Number" aria-label="Recipient\'s username" aria-describedby="basic-addon2" name="vehicle_number_' + ++vehicles + '"></div>')
  }
  $(".readonly").on('keydown paste focus mousedown', function(e) {
    if (e.keyCode != 9)
      e.preventDefault();
  });
  $(function() {
    $('#datetime').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD HH:mm',
      time: true
    });
  });
</script>
</body>

</html>