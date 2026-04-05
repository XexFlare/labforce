<?php include("includes/header.php"); ?>
  <div id="top"></div>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">SWEEPINGS</font>
            </div>
          </div>
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
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $results  = mysql_query("SELECT sweepings.*, tbl_contracts.meridian_contract
                        FROM sweepings 
                        LEFT JOIN tbl_contracts ON tbl_contracts.contractID = sweepings.contract_id");
                      $i=0;
                      while ($row = mysql_fetch_array($results)) {
                        extract($row);
                      ?>
                        <tr>
                          <td>
                            <font color='#CC6600'><?php echo $i++; ?></font>
                          </td>
                          <td>
                            <font color='#afa308'><?php echo date("d/m/Y", strtotime($date)); ?></font>
                          </td>
                          <td title='blend'>
                            <font color='#ff9933'><?php echo $grade; ?></font>
                          </td>
                          <td>
                            <font color='#afa308'><?php echo $sweeping_num; ?></font>
                          </td>
                          <td>
                            <font color='#ff9933'><?php echo $meridian_contract; ?></font>
                          </td>
                          <td>
                            <font color='#ff9933'><?php echo $color; ?></font>
                          </td>
                          <td>
                            <font color='#afa308'><?php echo $moisture; ?></font>
                          </td>
                          <td>
                            <font color='#ff9933'><?php echo $appearance; ?> </font>
                          </td>
                          <td>
                            <font color='#afa308'><?php echo $approx_age; ?></font>
                          </td>
                          <td>
                            <font color='#ff9933'><?php echo $origin; ?></font>
                          </td>
                          <td>
                            <font color='#afa308'><?php echo $approx_tonnage; ?> </font>
                          </td>
                          <td>
                            <a target='_blank' title='Sweeping Details' href='<?php echo "sweeping.php?id=$id"; ?>' class='btn btn-success btn-xs'>
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
    <?php include("includes/javascript_includes.php"); ?>
    </body>

    </html>