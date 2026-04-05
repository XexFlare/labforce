<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">EDIT USER</div>
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
    $query3  = "SELECT * FROM tbl_system_users WHERE userID ='$id'";
    $results3 = mysql_query($query3) or die(mysql_error());
    while ($row3 = mysql_fetch_array($results3)) {
      extract($row3);
    }
    ?>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            Edit: <font color="#cccccc"><?php echo " $firstname $lastname"; ?></font>
          </header>
          <div class="panel-body">
            <div class="card-body">
              <form method="POST" action="user_edit2.php" class="form-horizontal">
                <div class="form-body">
                  <div class="form-group row">
                    <label class="control-label col-md-3">First Name
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-5">
                      <input type="text" name="firstname" value="<?php echo "$firstname"; ?>" required placeholder="enter first name" class="form-control input-height" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Last Name
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-5">
                      <input type="text" name="lastname" value="<?php echo "$lastname"; ?>" required placeholder="enter last name" class="form-control input-height" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Access Level
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-5">
                      <?php
                      $query2 = "SELECT * FROM tbl_user_levels WHERE level='$userLevel'";
                      $results2 = mysql_query($query2);
                      while ($row2 = mysql_fetch_array($results2)) {
                        $details1 = $row2["details"];
                      }
                      $query  = "SELECT * FROM tbl_user_levels ORDER BY level ASC ";
                      $results = mysql_query($query);
                      $nrows = mysql_num_rows($results);
                      $row = mysql_num_rows($results);
                      for ($i = 0; $i < $nrows; $i++) {
                        $n = $i + 1;
                        $row = mysql_fetch_array($results);
                        extract($row);
                        if ($userLevel == $level) {
                          echo "
											<div class=''><label><input type='radio' required  checked name='level[]' value='$userLevel'> $details1</label></div>
											\n";
                        } else {
                          echo "
											<div class=''><label><input type='radio' required name='level[]' value='$level'> $details</label></div>
											\n";
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Gender
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <select class="form-control input-height" required name="gender">
                        <option value="<?php echo "$gender"; ?>"><?php echo "$gender"; ?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label col-md-3">Mobile No.
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <input name="mobile" type="text" value="<?php echo "$mobile"; ?>" required placeholder="mobile number" class="form-control input-height" />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3">City
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <input name="city" type="text" value="<?php echo "$city"; ?>" required placeholder="user city" class="form-control input-height" />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Country:</label>
                    <span class="required"></span>
                    <div class="col-sm-4">
                      <div class="search-box">
                        <?php
                        $query = "select * from tbl_countries ORDER BY country ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='country' class='form-control input-height' required>\n";
                        $sql1 = "SELECT * FROM tbl_countries WHERE countryID='$country'";
                        $result1 = mysql_query($sql1);
                        $nrows1 = mysql_num_rows($result1);
                        while ($row1 = mysql_fetch_array($result1)) {
                          $country1 = $row1["country"];
                        }
                        echo "<option selected='false' value='$country'>$country1</font></option> ";
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
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Business Unit:</label>
                    <span class="required"></span>
                    <div class="col-sm-4">
                      <div class="search-box">
                        <?php
                        $query = "select * from tbl_business_units ORDER BY unit_name ASC";
                        $result = mysql_query($query) or die("Couldn't execute query.");
                        echo "<select name='unit' class='form-control input-height' required>\n";
                        $sql1 = "SELECT * FROM tbl_business_units WHERE unitID='$unit'";
                        $result1 = mysql_query($sql1);
                        $nrows1 = mysql_num_rows($result1);
                        while ($row1 = mysql_fetch_array($result1)) {
                          $unit1 = $row1["unit_name"];
                        }
                        echo "<option selected='false' value='$unit'>$unit1</font></option> ";
                        while ($row = mysql_fetch_array($result)) {
                          extract($row);
                          echo "<option value='$unitID'>$unit_name\n";
                        }
                        echo "</select>\n";
                        ?>
                        <div class="result"></div>
                      </div>
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
                  <input type="hidden" name="id" value="<?php echo "$userID"; ?>">
                  <div class="form-actions">
                    <div class="row">
                      <div class="offset-md-3 col-md-9">
                        <button type="submit" class="btn btn-info">Update User</button>
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