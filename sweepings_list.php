<?php include("includes/header.php"); ?>
 
   
  <div id="top"></div>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Sweepings</li>
          </ol>
        </div>
      </div>
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
                        <th>Date</th>
                        <th>Grade</th>
                        <th>Sweeping #</th>
                        <th>Contract #</th>
                        <th>Color</th>
                        <th>Moisture</th>
                        <th>Appearance</th>
                        <th>Age</th>
                        <th>Origin</th>
                        <th>Tonnes</th>
                        <th>Done By</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $results  = mysql_query("SELECT sweepings.*, tbl_contracts.meridian_contract, tbl_system_users.firstname, tbl_system_users.lastname
                      FROM sweepings 
                      LEFT JOIN tbl_system_users ON tbl_system_users.userID = sweepings.done_by
                      LEFT JOIN tbl_contracts ON tbl_contracts.contractID = 14");
                    $i=0;
                    while ($row = mysql_fetch_array($results)) {
                      extract($row);
                    ?>
                        <tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo date("d/m/Y", strtotime($date)); ?></td>
                          <td><?php echo $grade; ?></td>
                          <td><?php echo $sweeping_num; ?></td>
                          <td><?php echo $meridian_contract; ?></td>
                          <td><?php echo $color; ?></td>
                          <td><?php echo $moisture; ?></td>
                          <td><?php echo $appearance; ?></td>
                          <td><?php echo $approx_age; ?></td>
                          <td><?php echo $origin; ?></td>
                          <td><?php echo $approx_tonnage; ?></td>
                          <td><?php echo "$firstname $lastname"; ?></td>
                          <td>
                            <a title='Edit Batch Details' href='<?php echo "batch_edit.php?id=$id"; ?>' class='btn btn-primary btn-xs'>
                              <i class='fa fa-pencil '></i>
                            </a>
                            <a title='Analysis Samples' href='<?php echo "analysis_add.php?id=$id"; ?>' class='btn btn-success btn-xs'>
                              <i class='fa fa-list '></i>
                            </a>
                            <a title='Delete Batch' href='<?php echo "batch_delete.php?id=$id"; ?>' class='btn btn-danger btn-xs'>
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
      <?php include("includes/footer.php"); ?>
    </div>
    <?php include("includes/javascript_includes.php"); ?>
    </body>

    </html>