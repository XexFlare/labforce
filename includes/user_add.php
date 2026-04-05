<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="card card-box">

      <div class="card-body">
        <form method="POST" action="user_add2.php" class="form-horizontal">
          <div class="form-body">
            <div class="form-group row">
              <label class="control-label col-md-3">First Name
                <span class="required"> * </span>
              </label>
              <div class="col-md-5">
                <input type="text" name="firstname" required placeholder="enter first name" class="form-control input-height" />
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3">Last Name
                <span class="required"> * </span>
              </label>
              <div class="col-md-5">
                <input type="text" name="lastname" required placeholder="enter last name" class="form-control input-height" />
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3">Access Level
                <span class="required"> * </span>
              </label>
              <div class="col-md-5">
                <?php
                $query  = "SELECT * FROM tbl_user_levels ORDER BY level ASC ";
                $results = mysql_query($query);
                $nrows = mysql_num_rows($results);
                $row = mysql_num_rows($results);
                for ($i = 0; $i < $nrows; $i++) {
                  $n = $i + 1;
                  $row = mysql_fetch_array($results);
                  extract($row);
                  echo "
      <div class=''><label><input type='radio' required checked name='level[]' value='$level'> $details</label></div>
      \n";
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
                  <option value="">Select...</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3">Mobile No.
                <span class="required"> * </span>
              </label>
              <div class="col-md-5">
                <input name="mobile" type="text" placeholder="mobile number" class="form-control input-height" />
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">City
                <span class="required"> * </span>
              </label>
              <div class="col-md-4">
                <input name="city" type="text" placeholder="User City" class="form-control input-height" />
              </div>
            </div>
            <div class="form-group row">
              <label for="horizontalFormEmail" class="col-sm-3 control-label">Country</label>
              <span class="required"></span>
              <div class="col-sm-4">
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
              <label for="horizontalFormEmail" class="col-sm-3 control-label">Business Unit:</label>
              <span class="required"></span>
              <div class="col-sm-4">
                <div class="search-box">
                  <?php
                  $query = "select * from tbl_business_units ORDER BY unit_name ASC";
                  $result = mysql_query($query) or die("Couldn't execute query.");
                  echo "<select name='unit' class='form-control input-height' required>\n";
                  echo "<option selected='false' value=''>Select Business Unit</font></option> ";
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
              <div class="col-md-6">
                <div class="input-group">

                  <input type="email" class="form-control input-height" name="email" placeholder="Email Address">
                </div>
              </div>
            </div>
            <div class="form-actions">
              <div class="row">
                <div class="offset-md-3 col-md-9">
                  <button type="submit" class="btn btn-info">Add User</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>