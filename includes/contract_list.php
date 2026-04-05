<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card card-box">
      <div class="card-body ">
        <div class="table-wrap">
          <div class="table-scrollable">
            <table class="table table-hover table-checkable order-column full-width" id="example1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Contract</th>
                  <th>Fertilizer</th>
                  <th>Vessel</th>
                  <th>Blend Type</th>
                  <th>Supplier</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query  = "SELECT c.*,b.name, s.details FROM tbl_contracts as c 
                  left join tbl_blend_types as b on c.blend_type_id = b.id
                  left join tbl_suppliers as s on c.supplier_id = s.supplierID ORDER BY meridian_contract";
                $results = mysql_query($query);
                $nrows = mysql_num_rows($results);
                for ($i = 0; $i < $nrows; $i++) {
                  $n = $i + 1;
                  $row = mysql_fetch_array($results);
                  extract($row);
                  $sql = "SELECT * FROM tbl_fertilizer_types 
                  
                  WHERE fertilizerID='$fertilizer_name'";
                  $result = mysql_query($sql);
                  $nrow = mysql_num_rows($result);
                  while ($row = mysql_fetch_array($result)) {
                    $fertilizer = $row["fertilizer"];
                    $blend = $row["blend"];
                  }
                  $visible = $hidden ? 'warning' : 'success';
                  $blend = $is_blend ? 'success' : 'warning';
                  $sweep = $is_sweeping ? 'success' : 'warning';
                  $hidden_text = $hidden ? 'Show' : 'Hide';
                  echo "
                    <tr>
                      <td>$n</td>
                      <td>$meridian_contract</td>
                      <td>$fertilizer</td>
                      <td>$vessel</td>
                      <td>$name</td>
                      <td>$details</td>
                      <td>$contractDate</td>
                      <td>
                        <a href='contract_hide.php?id=$contractID' class='btn btn-$visible btn-xs'>
                          $hidden_text
                        </a>
                        <a href='contract_blend.php?id=$contractID' class='btn btn-$blend btn-xs'>
                          Blend
                        </a>
                        <a href='contract_sweep.php?id=$contractID' class='btn btn-$sweep btn-xs'>
                          Sweep
                        </a>
                        <a href='contract_delete.php?id=$contractID' class='btn btn-danger btn-xs'>
                        <i class='fa fa-trash-o '></i>
                        </a>
                      </td>
                    </tr>  
                ";
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