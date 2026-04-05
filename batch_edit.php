<?php include("includes/header.php");
$batch = $_GET['id'];
$query  = "SELECT * FROM tbl_batches WHERE batchID = '$batch'";
$results = mysql_query($query);
while ($row = mysql_fetch_array($results)) {
  extract($row);
}
?>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">EDIT BATCH: <font color="#3399FF"><?php echo "$batchNum"; ?></font>
            </div>
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
                  <div id="myBar" style="width: 50%;">50%</div>
                </div>
                </header>
                <form action="batch_edit2.php" id="form_sample_1" class="form-horizontal" method="POST">
                  <br>
                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Fertilizer Type:</label>
                    <span class="required"></span>
                    <div class="col-sm-4">
                      <div class="search-box">
                        <?php
                        $query = "select * from tbl_fertilizer_types ORDER BY fertilizer ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='fertilizer' class='form-control input-height' required>\n";
                        $sql1 = "SELECT * FROM tbl_fertilizer_types WHERE fertilizerID='$fertilizerType'";
                        $result1 = mysql_query($sql1);
                        $nrows1 = mysql_num_rows($result1);
                        while ($row1 = mysql_fetch_array($result1)) {
                          $fertilizer = $row1["fertilizer"];
                        }
                        echo "<option selected='false' value='$fertilizerType'>$fertilizer</font></option> ";
                        while ($row = mysql_fetch_array($result)) {
                          extract($row);
                          echo "<option value='$fertilizerID'>$fertilizer ($blend)\n";
                        }
                        echo "</select>\n";
                        ?>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Color:</label>
                    <span class="required"></span>
                    <div class="col-sm-3">
                      <div class="search-box">
                        <?php
                        $query = "select * from tbl_colors ORDER BY color ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='color' class='form-control input-height' required>\n";
                        $sql2 = "SELECT * FROM tbl_colors WHERE colorID='$color'";
                        $result2 = mysql_query($sql2);
                        $nrows2 = mysql_num_rows($result2);
                        while ($row2 = mysql_fetch_array($result2)) {
                          $color2 = $row2["color"];
                        }
                        echo "<option selected='false' value='$color'>$color2</font></option> ";
                        while ($row = mysql_fetch_array($result)) {
                          extract($row);
                          echo "<option value='$colorID'>$color\n";
                        }
                        echo "</select>\n";

                        ?>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Size
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-2">
                      <select class="form-control input-height" required name="size">
                        <option value="<?php echo "$size"; ?>"><?php echo "$size"; ?></option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Supplier:</label>
                    <span class="required"></span>
                    <div class="col-sm-5">
                      <div class="search-box">
                        <?php
                        $query = "select * from tbl_suppliers ORDER BY details ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='supplier' class='form-control input-height' required>\n";

                        $sql3 = "SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'";
                        $result3 = mysql_query($sql3);
                        $nrows3 = mysql_num_rows($result3);
                        while ($row2 = mysql_fetch_array($result3)) {
                          $supplier3 = $row2["details"];
                        }
                        echo "<option selected='false' value='$supplierID'>$supplier3</font></option> ";
                        while ($row = mysql_fetch_array($result)) {
                          extract($row);
                          echo "<option value='$supplierID'>$details\n";
                        }
                        echo "</select>\n";

                        ?>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Batch Number:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                      <input type="text" name="batch" value="<?php echo "$batchNum"; ?>" data-required="1" placeholder="Batch number #" class="form-control input-height" /> </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Sample Number:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                      <input type="text" name="sample" value="<?php echo "$sampleNum"; ?>" data-required="1" placeholder="Sample number #" class="form-control input-height" /> </div>
                  </div>
                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Contract Number:</label>
                    <span class="required"></span>
                    <div class="col-sm-3">
                      <div class="search-box">
                        <?php
                        $query = "select * from tbl_contracts ORDER BY meridian_contract ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='contract' class='form-control input-height' required>\n";
                        $sql5 = "SELECT * FROM tbl_contracts WHERE contractID='$contractID'";
                        $result5 = mysql_query($sql5);
                        $nrows5 = mysql_num_rows($result5);
                        while ($row5 = mysql_fetch_array($result5)) {
                          $contract5 = $row5["meridian_contract"];
                        }
                        echo "<option selected='false' value='$contractID'>$contract5</font></option> ";
                        while ($row = mysql_fetch_array($result)) {
                          extract($row);
                          echo "<option value='$contractID'>$meridian_contract\n";
                        }
                        echo "</select>\n";
                        ?>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="batchID" value="<?php echo "$batch"; ?>">
                  <div class="form-actions">
                    <div class="row">
                      <div class="offset-md-3 col-md-9">
                        <button type="submit" class="btn btn-success">Confirm Changes >></button>
                        <a href="batch_edit.php"><button type="button" class="btn btn-default">Cancel</button></a>
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
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>
  </html>