<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card card-box">
      <div class="card-body ">
        <div class="table-wrap">
          <div class="table-scrollable">
            <table class="table table-hover table-checkable order-column full-width" id="example3">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fertilizer</th>
                  <th>Batch #</th>
                  <th>Sample #</th>
                  <th>Done By</th>
                  <th>Meridian #</th>
                  <th>Ship</th>
                  <th>Truck Number</th>
                  <th>Size</th>
                  <th>Color</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query  = "SELECT tbl_batches.*,
                  tbl_fertilizer_types.fertilizer,tbl_fertilizer_types.blend,
                  tbl_batches.batchNum, tbl_batches.contractID, tbl_batches.size,
                  tbl_system_users.firstname, tbl_system_users.lastname,
                  tbl_contracts.meridian_contract,tbl_contracts.ship_name, tbl_colors.color,
                  tbl_samples.sample_number
                  FROM tbl_batches
                  LEFT JOIN tbl_system_users ON tbl_system_users.userID = tbl_batches.doneBy
                  LEFT JOIN tbl_contracts ON tbl_batches.contractID = tbl_contracts.contractID 
                  LEFT JOIN tbl_colors ON tbl_batches.color = tbl_colors.colorID
                  LEFT JOIN tbl_samples ON tbl_samples.id = tbl_batches.sample_id
                  LEFT JOIN tbl_fertilizer_types ON tbl_fertilizer_types.fertilizerID = tbl_contracts.fertilizer_name";
                if ($myLevel == 1) $query .= " ORDER BY batchID DESC";
                else $query .= " WHERE tbl_system_users.country = $myCountry ORDER BY batchID DESC";
                $results = mysql_query($query);
                $nrows = mysql_num_rows($results);
                $row = mysql_num_rows($results);
                for ($i = 0; $i < $nrows; $i++) {
                  $n = $i + 1;
                  $row = mysql_fetch_array($results);
                  extract($row);
                  ?>
                  <tr>
                    <td><?php echo $n; ?></td>
                    <td><?php echo "$blend $fertilizer"; ?></td> <td><?php echo $batchNum; ?></td>
                    <td><?php echo $sampleNum ?? $sample_number; ?></td>
                    <td><?php echo "$firstname $lastname"; ?></td>
                    <td><?php echo $meridian_contract; ?></td>
                    <td><?php echo $ship_name; ?></td>
                    <td><?php echo $truck_number; ?></td>
                    <td><?php echo $size; ?></td>
                    <td><?php echo $color; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($sampleDate)); ?></td>
                    <td>
                      <a title='Edit Batch Details' href='<?php echo "batch_edit.php?id=$batchID"; ?>' class='btn btn-primary btn-xs'>
                        <i class='fa fa-pencil '></i>
                      </a>
                      <a title='Analysis Samples' href='<?php echo "analysis_add.php?id=$batchID"; ?>' class='btn btn-success btn-xs'>
                        <i class='fa fa-list '></i>
                      </a>
                      <a title='Delete Batch' href='<?php echo "batch_delete.php?id=$batchID"; ?>' class='btn btn-danger btn-xs'>
                        <i class='fa fa-trash-o '></i>
                      </a>
                    </td>
                  </tr>
                <?php
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