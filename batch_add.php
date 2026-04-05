<?php include("includes/header.php"); ?>
 
   
  <?php
  $query = "select tbl_contracts.*, tbl_fertilizer_types.fertilizer from tbl_contracts, tbl_fertilizer_types WHERE tbl_contracts.fertilizer_name = tbl_fertilizer_types.fertilizerID AND tbl_contracts.hidden = 0 ORDER BY tbl_fertilizer_types.fertilizer, tbl_contracts.meridian_contract ASC";
  $result = mysql_query($query) or die("Couldn't execute query.");
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
                  <div id="myBar" style="width: 50%;">50%</div>
                </div>
                </header>
                <form action="batch_add2.php" id="form_sample_1" class="form-horizontal" method="POST">
                  <br>
                  <div class="form-group row">
                    <label for="contract" class="col-sm-3 control-label">Contract:</label>
                    <span class="required"></span>
                    <div class="col-sm-4">
                      <div class="search-box">
                        <select name='contract' class='form-control input-height' required>
                          <option selected='false' value=''>Contract</font>
                          </option>
                          <?php
                          while ($row = mysql_fetch_array($result)) {
                            extract($row);
                            $date = date("d M Y", strtotime($contractDate));
                            echo "<option value='$contractID'>$fertilizer - $meridian_contract - $date</option>";
                          }
                          ?>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-actions">
                    <div class="row">
                      <div class="offset-md-3 col-md-9">
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
    </div>
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>