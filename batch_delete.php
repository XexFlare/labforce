<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Captured Batches</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li><a class="parent-item" href="">UI Elements</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Panels</li>
        </ol>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-sm-8">
            <div class="card card-topline-red">
              <div class="card-head">
                <header>ALL BATCHES</header>
                <div class="tools">
                  <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                  <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                  <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                </div>
              </div>
              <div class="card-body ">
                <?php $id = $_GET['id'];
                $query = "SELECT * FROM tbl_batches WHERE batchID='$id'";
                $results = mysql_query($query);
                $nrows = mysql_num_rows($results);
                while ($row = mysql_fetch_array($results)) {
                  $batchNum = $row["batchNum"];
                }
                $query1 = "SELECT * FROM tbl_analysis WHERE batchID='$id'";
                $results1 = mysql_query($query1);
                $nrows1 = mysql_num_rows($results1);
                ?>
                <table border="0" width="100%" id="table1">
                  <tr>
                    <td colspan="2" align="center"><strong>
                        <font color="#ff0000">WARNING! <i class="fa fa-times"></i></font>
                      </strong></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">This process will delete both, the batch (<b><?php echo "$batchNum"; ?></b>)
                      and all (<b>
                        <font color="#ff0000"><?php echo "$nrows1"; ?>
                      </b></font>) its related samples from the database permanently!</td>
                  </tr>
                  <tr>
                    <td></td>
                  </tr>
                  <tr>
                    <td align="center"><a href="batch_delete2.php?id=<?php echo "$id"; ?>">
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-danger">YES DELETE</button>
                      </a>
                      <font color="#FF0000"></font>
                    </td>
                    <td align="center"><a href="javascript:history.go(-1)">
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-success">NO, GO BACK</button>
                      </a>
                      <font color="#008000"></font>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card card-topline-yellow">
              <div class="card-head">
                <header>Panel Title</header>
                <div class="tools">
                  <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                  <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                  <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                </div>
              </div>
              <div class="card-body ">Content goes here.</div>
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