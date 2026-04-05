<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">EDIT SUPPLIER</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </div>
    <?php
    $id = $_GET['id'];
    $query3  = "SELECT * FROM tbl_suppliers WHERE supplierID ='$id'";
    $results3 = mysql_query($query3) or die(mysql_error());
    while ($row3 = mysql_fetch_array($results3)) {
      extract($row3);
    }
    ?>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            Edit: <font color="#cccccc"><?php echo " $details"; ?></font>
          </header>
          <div class="panel-body">
            <div class="card-body">
              <form method="POST" action="supplier_edit2.php" class="form-horizontal">
                <div class="form-body">
                  <div class="form-group row">
                    <label class="control-label col-md-3">Name
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-5">
                      <input type="text" name="details" value="<?php echo "$details"; ?>" required placeholder="Instituition Name" class="form-control input-height" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Address
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-5">
                      <textarea name="address" required placeholder="Address" class="form-control-textarea" rows="5"><?php echo "$address"; ?></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">District</label>
                    <span class="required"> * </span>
                    <div class="col-sm-3">
                      <div class="search-box">
                        <?php


                        $query2 = "SELECT * FROM tbl_countries WHERE countryID='$country'";
                        $results2 = mysql_query($query2);
                        while ($row2 = mysql_fetch_array($results2)) {
                          $details1 = $row2["country"];
                        }

                        $query = "select * from tbl_countries ORDER BY country ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='country' class='form-control input-height' required>\n";
                        echo "<option selected='false' value='$country'>$details1</font></option> ";
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
                    <label class="control-label col-md-3">Phone No.
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <input name="phone" type="text" value="<?php echo "$phone"; ?>" required placeholder="mobile number" class="form-control input-height" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Email
                    </label>
                    <div class="col-md-5">
                      <div class="input-group">

                        <input type="email" value="<?php echo "$email"; ?>" class="form-control input-height" name="email" placeholder="Email Address">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Remarks
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-5">
                      <textarea name="notes" placeholder="Address" class="form-control-textarea" rows="5"><?php echo "$notes"; ?></textarea>
                    </div>
                  </div>
                  <input type="hidden" name="supplierID" value="<?php echo "$supplierID"; ?>">
                  <div class="form-actions">
                    <div class="row">
                      <div class="offset-md-3 col-md-9">
                        <button type="submit" class="btn btn-primary">Update Supplier</button>
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
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>