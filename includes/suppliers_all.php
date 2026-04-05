<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card card-box">
      <div class="card-head">
        <header>All Registered Suppliers:</header>
        <div class="tools">
          <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
          <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
          <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
        </div>
      </div>
      <div class="card-body ">
        <div class="table-wrap">
          <div class="table-scrollable">
            <table class="table table-hover table-checkable order-column full-width" id="example1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Supplier</th>
                  <th>Address</th>
                  <th>Country</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query  = "SELECT * FROM tbl_suppliers ORDER BY details";
                $results = mysql_query($query);
                $nrows = mysql_num_rows($results);
                $row = mysql_num_rows($results);
                for ($i = 0; $i < $nrows; $i++) {
                  $n = $i + 1;
                  $row = mysql_fetch_array($results);
                  extract($row);
                  $query2 = "SELECT * FROM tbl_countries WHERE countryID='$country'";
                  $results2 = mysql_query($query2);
                  while ($row = mysql_fetch_array($results2)) {
                    $country1 = $row["country"];
                  }
                  echo "<tr>
                    <td>$n</td>
                    <td title='$address'>$details</td>
                    <td>$address</td>
                    <td title='$address'>$country1</td>
                    <td>$phone</td>
                    <td>$email</td>
                    <td>
                    <a href='supplier_edit.php?id=$supplierID'; class='btn btn-primary btn-xs'>
                    <i class='fa fa-pencil'></i>
                    </a>
                    <a href='supplier_delete.php?id=$supplierID' class='btn btn-danger btn-xs'>
                    <i class='fa fa-trash-o '></i>
                    </a>
                    </td>
                  </tr>  ";
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