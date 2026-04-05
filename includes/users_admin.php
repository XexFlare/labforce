<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card card-box">
      <div class="card-head">
        <header>IT Administrators:</header>
        <div class="tools">
          <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
          <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
          <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
        </div>
      </div>
      <div class="card-body ">
        <div class="table-wrap">
          <div class="table-scrollable">
            <table class="table table-hover table-checkable order-column full-width" id="example3">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Level</th>
                  <th>Mobile</th>
                  <th>City</th>
                  <th>Country</th>
                  <th>Unit</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query  = "SELECT * FROM tbl_system_users WHERE userLevel='1' ORDER BY lastname, firstname";
                $results = mysql_query($query);
                $nrows = mysql_num_rows($results);
                $row = mysql_num_rows($results);
                for ($i = 0; $i < $nrows; $i++) {
                  $n = $i + 1;
                  $row = mysql_fetch_array($results);
                  extract($row);
                  $query2 = "SELECT * FROM tbl_user_levels WHERE level='$userLevel'";
                  $results2 = mysql_query($query2);
                  while ($row = mysql_fetch_array($results2)) {
                    $details = $row["details"];
                  }
                  $query3 = "SELECT * FROM tbl_countries WHERE countryID='$country'";
                  $results3 = mysql_query($query3);
                  while ($row = mysql_fetch_array($results3)) {
                    $country = $row["country"];
                  }
                  $query4 = "SELECT * FROM tbl_business_units WHERE unitID='$unit'";
                  $results4 = mysql_query($query4);
                  while ($row = mysql_fetch_array($results4)) {
                    $unit = $row["unit_name"];
                  }
                  echo "<tr>
                    <td>$n</td>
                    <td>$firstname $lastname</td>
                    <td>$details</td>
                    <td>$mobile</td>
                    <td>$city</td>
                    <td>$country</td>
                    <td>$unit</td>
                    <td>$email</td>
                    <td>
                    <a href='user_edit.php?id=$userID'; class='btn btn-success btn-xs'>
                    <i class='fa fa-pencil'></i>
                    </a>
                    <a href='change_user_password.php?id=$userID'; class='btn btn-primary btn-xs'>
                    <i class='fa fa-lock'></i>
                    </a>
                    <a href='user_delete.php?id=$userID' class='btn btn-danger btn-xs'>
                    <i class='fa fa-trash-o '></i>
                    </a>
                    </td>
                  </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>