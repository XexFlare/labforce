<?php include("includes/header.php"); ?>
  <div id="top"></div>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <?php
            $results = mysql_query("SELECT details FROM tbl_suppliers where supplierID={$_GET['id']}");
            $row = mysql_fetch_array($results);
            extract($row);
            ?>
            <div class="page-title">Supplier Results: <?php echo $details; ?></font>
            </div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Supplier Results</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card card-box">
            <div class="card-body ">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a href="/supplier_results.php?type=<?php echo isset($_GET['type']) && $_GET['type'] == 'damaged' ? 'all' : 'damaged'; echo "&id={$_GET['id']}";?>" class="nav-link <?php echo !isset($_GET['type']) || $_GET['type'] == 'damaged' ? 'active bg-success' : 'text-success'; ?>">Damaged</a>
                </li>
              </ul>
              <div class="table-wrap">
                <div class="table-scrollable">
                  <table class="table table-hover table-checkable order-column full-width" id="example3">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Fertilizer</th>
                        <th>Batch #</th>
                        <th>Contract #</th>
                        <th>Color</th>
                        <th>N</th>
                        <th>P205</th>
                        <th>K20</th>
                        <th>S</th>
                        <th>B</th>
                        <th>ZnS04</th>
                        <th>=</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $damaged = isset($_GET['type']) && $_GET['type'] == 'damaged';
                      $supplier = isset($_GET['id']) ? $_GET['id'] : 0;
                      $query  = "SELECT tbl_analysis.*, 
                  tbl_fertilizer_types.fertilizer,
                  tbl_batches.batchNum, tbl_batches.contractID, tbl_batches.size, tbl_batches.color,
                  tbl_system_users.firstname, tbl_system_users.lastname,
                  tbl_contracts.meridian_contract, tbl_colors.color
                  FROM tbl_analysis 
                  LEFT JOIN tbl_batches ON tbl_batches.batchID = tbl_analysis.batchID 
                  LEFT JOIN tbl_system_users ON tbl_system_users.userID = tbl_analysis.doneBy
                  LEFT JOIN tbl_contracts ON tbl_batches.contractID = tbl_contracts.contractID 
                  LEFT JOIN tbl_colors ON tbl_batches.color = tbl_colors.colorID
                  LEFT JOIN tbl_fertilizer_types ON tbl_fertilizer_types.fertilizerID = tbl_contracts.fertilizer_name";
                      if ($myLevel == 1)
                        $condition = "WHERE tbl_analysis.approval_response = true";
                      else
                        $condition  = "WHERE tbl_system_users.country = $myCountry
                          AND tbl_analysis.approval_response = true";
                      if($damaged) 
                        $condition .= " AND tbl_analysis.exec_comments != ''";
                      $condition .= " AND tbl_contracts.supplier_id=$supplier";
                      $order = 'ORDER BY time DESC';
                      $results = mysql_query($query . " " . $condition . " " . $order);
                      $i = 1;
                      while ($row = mysql_fetch_array($results)) {
                        extract($row);
                        $isDamaged = isset($exec_comments) && $exec_comments != '';
                        $isVisual = isset($item) && $item == 'Visual Inspection';
                      ?>
                        <tr class="<?php echo $isDamaged ? 'list-damaged' : ($isVisual ? 'list-visual' : ''); ?>">
                          <td>
                            <font color='#CC6600'><?php echo $i++; ?></font>
                          </td>
                          <td>
                            <font color="#149347"><?php echo date("d/m/Y", strtotime($time)); ?></font>
                          </td>
                          <td>
                            <font color="#ff9933"><?php echo $fertilizer; echo $isVisual ? '<span class="pill blend">Visual</span>' : ''; ?></font>
                          </td>
                          <td>
                            <font color="#149347"><?php echo $batchNum; ?></font>
                          </td>
                          <td>
                            <font color="#ff9933"><?php echo $meridian_contract; ?></font>
                          </td>
                          <td>
                            <font color="#ff9933"><?php echo $color; ?></font>
                          </td>
                          <td>
                            <font color="#149347"><?php echo $n; ?></font>
                          </td>
                          <td>
                            <font color="#ff9933"><?php echo $p2o5; ?> </font>
                          </td>
                          <td>
                            <font color="#149347"><?php echo $k2o; ?></font>
                          </td>
                          <td>
                            <font color="#ff9933"><?php echo $s; ?></font>
                          </td>
                          <td>
                            <font color="#149347"><?php echo $b; ?> </font>
                          </td>
                          <td>
                            <font color="#ff9933"><?php echo $zn; ?> </font>
                          </td>
                          <td>
                            <font color="#149347"><?php echo $total; ?> </font>
                          </td>
                          <td>
                            <a target='_blank' title='Analysis Samples' href='<?php echo "analysis_report.php?id=$analysisID"; ?>' class='btn btn-success btn-xs'>
                              <i class='fa fa-list '></i>
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
      <style>
        .pill {
          font-size: 15px;
          font-weight: bold;
          padding: 5px;
          color: white;
          border-radius: 5px;
          margin-left: 10px;
          background: #077b3a;
        }
        .list-visual {
          background-color: #edf5f7;
        }
      </style>
      <?php include("includes/footer.php"); ?>
    </div>
  </div>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>