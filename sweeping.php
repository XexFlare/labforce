<?php
include("includes/header.php");
include('includes/helpers.php');

$id = $_GET['id'];
$results  = mysql_query("SELECT sweepings.*, tbl_contracts.meridian_contract, tbl_system_users.firstname, tbl_system_users.lastname
  FROM sweepings 
  LEFT JOIN tbl_contracts ON tbl_contracts.contractID = sweepings.contract_id
  LEFT JOIN tbl_system_users ON tbl_system_users.userID = sweepings.done_by
  WHERE id = $id");
$current = mysql_fetch_array($results);
extract($current);
?>
<div class="page-content-wrapper">
  <div id="content" class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Sweeping Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i> <a class="parent-item" href="index.php">Home</a> <i class="fa fa-angle-right"></i>
          <li><a class="parent-item" href="">Sweeping Report</a> <i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Sweeping</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="white-box">
          <div class="row">
            <div class="col-md-6">
              <h5>DATE:
                <b class="text-primary">
                  <?php echo date("d/m/Y", strtotime($date)); ?>
                </b>
              </h5>
              <h5>GRADE:
                <b class="text-primary">
                  <?php echo "$grade"; ?>
                </b>
              </h5>
              <h5>SWEEPING:
                <b class="text-primary">
                  <?php echo "$sweeping_num"; ?>
                </b>
              </h5>
              <h5>CONTRACT:
                <b class="text-primary">
                  <?php echo "$meridian_contract"; ?>
                </b>
              </h5>
              <h5>COLOR:
                <b class="text-primary">
                  <?php echo "$color"; ?>
                </b>
              </h5>
              <h5>MOISTURE CONTENT:
                <b class="text-primary">
                  <?php echo "$moisture"; ?>
                </b>
              </h5>
            </div>
            <div class="col-md-6">
              <h5>PHYSICAL APPEARANCE:
                <b class="text-primary">
                  <?php echo "$appearance"; ?>
                </b>
              </h5>
              <h5>APPROXIMATE AGE:
                <b class="text-primary">
                  <?php echo "$approx_age"; ?>
                </b>
              </h5>
              <h5>ORIGIN:
                <b class="text-primary">
                  <?php echo "$origin"; ?>
                </b>
              </h5>
              <h5>APPROXIMATE TOTAL TONNES:
                <b class="text-primary">
                  <?php echo "$approx_tonnage"; ?>
                </b>
              </h5>
              <h5>DONE BY: <b class="text-primary">
                  <?php echo "$firstname $lastname"; ?>
                </b></h5>
            </div>
          </div>
          <hr>

          <h3><b>Sweepings Inspection</h3>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-left text-right">
                <address>
                  <p class="m-t-30">
                    <b>Chemical Analysis Date :</b> <i class="fa fa-calendar"></i class="text-primary">
                    <?php echo "$date"; ?>
                  </p>
                </address>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive m-t-40">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-1" style="background-color:lavender;"></div>
                    <div class="col-sm-10" style="background-color:lavenderblush;">
                      <br>
                      <?php // include("fertilizer_limits_guide_print.php"); 
                      ?>
                    </div>
                    <div class="col-sm-1" style="background-color:lavender;"></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-1" style="background-color:lavender;"></div>
                    <div class="col-sm-10" style="background-color:lavenderblush;">
                      <hr>
                    </div>
                    <div class="col-sm-1" style="background-color:lavender;"></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-1" style="background-color:lavender;"></div>
                    <div class="col-sm-10" style="background-color:lavenderblush;"><?php include("includes/test_images_print.php"); ?></div>
                    <div class="col-sm-1" style="background-color:lavender;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
              <div class="text-right">
                <?php if (isset($filename) && $filename != '') {
                ?>
                  <a id="manufacturer" class="btn btn-default btn-outline" target="_blank" href="<?php echo $filename; ?>"> <span><i class="fa fa-download"></i> Manufacturer Certificate</span> </a>
                <?php } ?>
                <button id="download" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-download"></i> Download</span> </button>
                <button onclick="javascript:window.print();" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="editor"></div>

</div>
<style>
  .pill {
    font-size: 15px;
    font-weight: bold;
    padding: 5px;
    color: white;
    border-radius: 5px;
    margin-left: 10px;

  }

  .raw {
    background: #077b3a;
  }

  .blend {
    background: #007bff;
  }
</style>
<?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>