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
    <div class="row">
      <div class="col-sm-6">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            CONTRACT DETAILS </header>
          <form method="POST" action="contract_add2.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
              <div class="form-group row">
                <label class="control-label col-md-4">Meridian Contract
                </label>
                <div class="col-md-7">
                  <input type="text" name="contract" required placeholder="Contract details" class="form-control input-height" />
                </div>
              </div>
              <div class="form-group row">
                <label for="horizontalFormEmail" class="control-label col-md-4 ">Fertilizer</label>
                <div class="col-md-5">
                  <div class="search-box">
                    <?php
                    $query = "select * from tbl_fertilizer_types ORDER BY fertilizer ASC";
                    $result = mysql_query($query) or die("Couldn't execute query.");
                    echo "<select name='fertilizer' class='form-control input-height' required>\n";
                    echo "<option selected='false' value=''>Related Fertilizer</font></option> ";
                    while ($row = mysql_fetch_array($result)) {
                      extract($row);
                      echo "<option value='$fertilizerID'>$fertilizer\n";
                    }
                    echo "</select>\n";
                    ?>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="horizontalFormEmail" class="control-label col-md-4 ">Blend Type
                </label>
                <div class="col-md-5">
                  <div class="search-box">
                    <?php
                    $query = "select * from tbl_blend_types ORDER BY name ASC";
                    $result = mysql_query($query) or die("Couldn't execute query.");
                    echo "<select name='blend' class='form-control input-height' required>\n";
                    echo "<option selected='false' value=''>Blend Type</font></option> ";
                    while ($row = mysql_fetch_array($result)) {
                      extract($row);
                      echo "<option value='$id'>$name\n";
                    }
                    echo "</select>\n";
                    ?>
                    <div class="result"></div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="horizontalFormEmail" class="control-label col-md-4 ">Supplier
                </label>
                <div class="col-md-5">
                  <div class="search-box">
                    <?php
                    $query = "select * from tbl_suppliers ORDER BY details ASC";
                    $result = mysql_query($query) or die("Couldn't execute query.");
                    echo "<select name='supplier' class='form-control input-height' required>\n";
                    echo "<option selected='false' value=''>Supplier</font></option> ";
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
                <label class="control-label col-md-4">Contract Date
                </label>
                <div class="col-md-5">
                  <div class="input-group">
                    <input type="date" class="form-control input-height" name="contractDate" placeholder="Contract Date">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="horizontalFormEmail" class="control-label col-md-4">Country</label>
                <div class="col-md-5">
                  <div class="search-box">
                    <?php
                    $query = "select * from tbl_countries ORDER BY country ASC";
                    $result = mysql_query($query) or die("Couldn't execute query.");
                    echo "<select name='country' class='form-control input-height' required>\n";
                    echo "<option selected='false' value=''>Select Country</font></option> ";
                    while ($row = mysql_fetch_array($result)) {
                      extract($row);
                      echo "<option value='$countryID'>$country\n";
                    }
                    echo "</select>\n";
                    ?>
                    <div class="result"></div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label col-md-4">Vessel Name
                </label>
                <div class="col-md-5">
                  <div class="input-group">
                    <input type="text" class="form-control input-height" name="vessel" placeholder="Vessel name">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label col-md-4">Accpac Reference
                </label>
                <div class="col-md-5">
                  <div class="input-group">
                    <input type="text" class="form-control input-height" name="reference" placeholder="Accpac Reference">
                  </div>
                </div>
              </div>

              <div class="px-4">
                <h3>Manufacturer Results</h3>
              </div>
              <div class="row px-3">
                <div class="col-md-3 py-1">
                  <input type="text" name="moisture" placeholder="MOISTURE" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="n" placeholder="N" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="p2o5" placeholder="P2O5" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="k2o" placeholder="K2O" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="s" placeholder="S" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="b" placeholder="B" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="zn" placeholder="Zn" class="form-control input-height" />
                </div>

                <div class="col-md-3 py-1">
                  <input type="text" name="total" placeholder="Total" class="form-control input-height" />
                </div>
              </div>

              <div class="form-group row py-4">
                <label class="control-label col-md-4">Upload Results Image
                </label>
                <div class="col-md-5">
                  <div class="input-group">
                    <input type="file" class="form-control input-height" name="results">
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="offset-md-4 col-md-8">
                    <button type="submit" class="btn btn-info">Add Contract</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            CURRENT LIST </header>
          <div class="panel-body"><?php include("includes/contract_list.php"); ?></div>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>