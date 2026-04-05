<?php include("includes/header.php"); ?>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">FERTILIZER SUPPLIERS</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Dashboard</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel">
                <header class="panel-heading panel-heading-yellow">
                  SUPPLIERS </header>
                <div class="panel-body">
                  <div class="panel tab-border card-topline-aqua">
                    <header class="panel-heading panel-heading-gray custom-tab">
                    </header>
                    <div class="panel-body">
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
                                      $results = mysql_query("SELECT * FROM tbl_suppliers 
                                      LEFT JOIN tbl_countries ON tbl_countries.countryID = tbl_suppliers.country
                                      ORDER BY details");
                                      $i=0;
                                      while ($row = mysql_fetch_array($results)) {
                                        extract($row);
                                      ?>
                                        <tr>
                                          <td>
                                            <font color='#CC6600'><?php echo $i++; ?></font>
                                          </td>
                                          <td><?php echo $details; ?></td>
                                          <td><?php echo $address; ?></td>
                                          <td><?php echo $country; ?></td>
                                          <td><?php echo $phone; ?></td>
                                          <td><?php echo $email; ?></td>
                                          <td>
                                            <a target='_blank' title='Analysis Samples' href='<?php echo "supplier_results.php?id=$supplierID"; ?>' class='btn btn-success btn-xs'>
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
                    </div>
                  </div>
                </div>
              </div>
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