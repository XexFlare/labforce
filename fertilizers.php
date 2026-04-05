<?php include("includes/header.php"); ?>
<div id="top"></div>
<div class="page-content-wrapper">
  <div class="page-content">
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
                      <th>Fertilizer</th>
                      <th>Blend</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query  = "SELECT * FROM tbl_fertilizer_types ORDER BY fertilizerID DESC";
                    $results = mysql_query($query);
                    $nrows = mysql_num_rows($results);
                    $row = mysql_num_rows($results);
                    for ($i = 0; $i < $nrows; $i++) {
                      $n = $i + 1;
                      $row = mysql_fetch_array($results);
                      extract($row);
                      echo "
                        <tr>
                              <td>$n</td>
                              <td>$fertilizer</td>
                              <td>$blend</td>
                              <td>
                                <a href='fertilizer_limits.php?id=$fertilizerID' class='btn btn-success btn-xs'>
                                <i class='fa fa-bar-chart-o '></i>
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
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>