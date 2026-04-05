<?php include("includes/header.php");
$batch = $_GET['batch'];
$id = isset($_GET['id']) ? $_GET['id'] : null;
$ref = $_GET['ref'];
$query = "SELECT tbl_batches.*, fert.fertilizer, fert.blend FROM tbl_batches
LEFT JOIN tbl_contracts AS co ON tbl_batches.contractID = co.contractID
LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = co.fertilizer_name
WHERE batchID='$batch'";
$results = mysql_query($query);
$nrows = mysql_num_rows($results);
while ($row = mysql_fetch_assoc($results)) {
  extract($row);
}
?>

  <div class="page-content-wrapper">
    <div class="page-content">
      <?php if (!empty($_FILES['uploaded_file'])) {
        $path = "images/analysis/";
        $path = $path . basename($_FILES['uploaded_file']['name']);
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
          $file = basename($_FILES['uploaded_file']['name']);
          $description = $_POST['description'] == '' ? 'null' : $_POST['description'];
          $location = $_POST['location'] == '' ? 'null' : $_POST['location'];
          $type = $_POST['type'];
          $comments = $_POST['comments'];
          $insert  = $id != null ? "INSERT INTO tbl_photos (`file`, `parent_id`, `parent_type`, `ref`, `comments`,`location_id`,`description_id`,`type_id`) VALUES ('$file', $id, 'test', '$ref', '$comments', $location, $description, $type)"
          : "INSERT INTO tbl_photos (`file`, `parent_id`, `parent_type`, `ref`, `comments`,`location_id`,`description_id`,`type_id`) VALUES ('$file', $batch, 'batch', '$ref', '$comments', $location, $description, $type)";;
          $query = mysql_query($insert) or die(mysql_error());
          include("includes/success_photos.php");
        } else {
          include("includes/error.php");
        }
      } else { ?>
        <div class="page-bar">
          <div class="page-title-breadcrumb">
            <div class=" pull-left">
              <div class="page-title">
                <h5>Fertilizer: <font color="#FF0000"><?php echo "$fertilizer"; ?> </font>Blend: <font color="#FF0000"><?php echo "$blend"; ?></font> Batch #: <font color="#FF0000"><?php echo "$batchNum"; ?></font> Sample#: <font color="#FF0000"><?php echo "$sampleNum"; ?></font> Batch #: <font color="#FF0000"><?php echo "$batchNum"; ?></font> Date: <font color="#FF0000"><?php echo "$sampleDate"; ?></font>
                </h5>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-8 col-sm-8">
                <div class="card card-topline-lightblue">
                  <div class="card-head">
                    <header>Add <font color="#0066CC">Lab Photo</font> to test Number: <font color="orange"><?php echo "$id"; ?></font>
                    </header>
                  </div>
                  <div class="card-body" id="line-parent">
                    <div class="panel-group accordion" id="accordion3">
                      <form action='<?php echo $id != null ? "photo_lab_add.php?id=$id&batch=$batch&ref=$ref" : "photo_lab_add.php?batch=$batch&ref=$ref"; ?>' method="POST" id="form_sample_1" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-body">
                          <div class="form-group row">
                            <label class="control-label col-md-3">Upload Picture
                            </label>
                            <div class="compose-editor">
                              <input type="file" name="uploaded_file" class="default" multiple>
                            </div>
                          </div>
                          <div class="col-lg-8">
                            <div class="mdl-textfield mdl-js-textfield">
                              <label class="mdl-textfield__label" for="comments">Comments</label>
                              <input type="text" class="mdl-textfield__input" placeholder="Comments" name="comments" style="width:450px;">
                            </div>
                          </div>
                          <div id="typeList" class="col-lg-8">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:450px;">
                              <input type="text" value="" class="mdl-textfield__input readonly" id="type" autocomplete="off" required>
                              <input type="hidden" value="" name="type">
                              <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                              <label for="type" class="mdl-textfield__label">Type</label>
                              <ul for="type" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                <?php
                                $query = "SELECT * FROM doc_types ORDER BY name ASC";
                                $result = mysql_query($query) or die("Couldn't execute query.");
                                while ($row = mysql_fetch_array($result)) {
                                  extract($row);
                                  $location = $show_location ? 'show' : 'hide';
                                  $description = $show_description ? 'show' : 'hide';
                                  echo "<li class='mdl-menu__item' data-val='$id' data-description='$description' data-location='$location'>$name</li>";
                                  
                                }
                                ?>
                              </ul>
                            </div>
                          </div>
                          <div id="descriptionList" class="col-lg-8 display-none">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:450px;">
                              <input type="text" value="" class="mdl-textfield__input readonly" id="description" autocomplete="off">
                              <input type="hidden" value="" name="description">
                              <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                              <label for="description" class="mdl-textfield__label">Description</label>
                              <ul for="description" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                <?php
                                $query = "SELECT * FROM photo_descriptions ORDER BY name ASC";
                                $result = mysql_query($query) or die("Couldn't execute query.");
                                while ($row = mysql_fetch_array($result)) {
                                  extract($row);
                                  echo "<li class='mdl-menu__item' data-val='$id'>$name</li>";
                                }
                                ?>
                              </ul>
                            </div>
                          </div>
                          <div id="locationList" class="col-lg-8 display-none">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width:450px;">
                              <input type="text" value="" class="mdl-textfield__input readonly" id="location" autocomplete="off">
                              <input type="hidden" value="" name="location">
                              <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
                              <label for="location" class="mdl-textfield__label">Location</label>
                              <ul for="location" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                <?php
                                $query = "SELECT * FROM locations where unit=$myUnit ORDER BY name ASC";
                                $result = mysql_query($query) or die("Couldn't execute query.");
                                while ($row = mysql_fetch_array($result)) {
                                  extract($row);
                                  echo "<li class='mdl-menu__item' data-val='$id'>$name</li>";
                                }
                                ?>
                              </ul>
                            </div>
                          </div>
                          <div class="form-actions">
                            <div class="row">
                              <div class="offset-md-3 col-md-9">
                                <button type="submit" class="btn btn-info">Update Picture</button>
                              </div>
                            </div>
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
      <?php } ?>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>
<script src="assets/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/getmdl-select.js"></script>
<script src="assets/material/material.min.js"></script>
<script>
  jQuery(document).ready(function() {
    $('#typeList > div > div > ul > li').on('click', function() {
      if($(this).data("location") == "hide") {
        $('#locationList').addClass('display-none');
      } else {
        $('#locationList').removeClass('display-none');
      }
      if($(this).data("description") == "hide") {
        $('#descriptionList').addClass('display-none');
      } else {
        $('#descriptionList').removeClass('display-none');
      }
    });
  });
</script>
</body>

</html>