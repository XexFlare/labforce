<?php
include("includes/redirects.php");
if (redirect()) return;
$beta = true;
include("includes/header.php");
include('includes/helpers.php');

$id = $_GET['analysisID'] ?? $_GET['id'];
$full = isset($_GET['full']);
$query  = "SELECT a.*, 
sup.details AS supplier,
u.firstname, u.lastname, u.email,
ap.firstname AS ap_fname, ap.lastname AS ap_lname,
qa.firstname AS qa_fname, qa.lastname AS qa_lname,
lb.firstname AS lb_fname, lb.lastname AS lb_lname,
bu.unit_name, bu.shortname, c.country, clr.color as batch_color,
fert.fertilizer, fert.blend, fert.formula, s.sample_number, s.sample_id as sampleId,
s.vehicle_number, sc.color as sample_color, s.size as sample_size,
co.meridian_contract,co.acc_reference, co.contractID, co.ship_name, co.vessel,co.is_sweeping,
b.batchID, b.size, b.batchNum, b.sampleNum, b.blendBatchNum, b.sample_id, b.sampleDate, co.is_blend, co.fertilizer_name, b.truck_number, 
act.name as action, ex.firstname as ex_fname, ex.lastname as ex_lname
FROM tbl_analysis AS a
LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
LEFT JOIN tbl_samples AS s ON s.id = b.sample_id
LEFT JOIN tbl_colors AS clr ON clr.colorID = b.color
LEFT JOIN tbl_colors AS sc ON sc.colorID = s.color
LEFT JOIN tbl_system_users AS u ON b.doneBy = u.userID
LEFT JOIN tbl_system_users AS ap ON a.approved_by = ap.userID
LEFT JOIN tbl_system_users AS qa ON a.qa_comments_by = qa.userID
LEFT JOIN tbl_system_users AS lb ON a.lab_comments_by = lb.userID
LEFT JOIN tbl_system_users AS ex ON a.exec_action_by = ex.userID
LEFT JOIN exec_action AS act ON a.exec_action = act.id
LEFT JOIN tbl_business_units AS bu ON u.unit = bu.unitID
LEFT JOIN tbl_contracts AS co ON b.contractID = co.contractID
LEFT JOIN tbl_suppliers AS sup ON sup.supplierID = co.supplier_id
LEFT JOIN tbl_countries AS c ON c.countryID = co.country_id
LEFT JOIN tbl_manufacturer_results AS m ON m.contract_id = b.contractID
LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = co.fertilizer_name
WHERE analysisID=$id";
$results = mysql_query($query);
$current = mysql_fetch_array($results);
extract($current);
$isVisual = $current['item'] == 'Visual Inspection';
$is_blend = $current['is_blend'] ? 1 : 0;
if (isset($_GET['exec_action']) && $exec_action == null) {
  $results = mysql_query("SELECT * FROM exec_action WHERE id={$_GET['exec_action']}");
  $exec_action = mysql_num_rows($results);
  if ($exec_action != 0) {
    $query = "UPDATE tbl_analysis SET 
    exec_action = {$_GET['exec_action']}, exec_action_by = $myID, exec_action_on = NOW()
    WHERE analysisID = $id";
    $res = mysql_query($query) or die(mysql_error());
    $action_result = 'success';
    $action_q = mysql_fetch_array($results);
    $action = $action_q['name'];
    $ex_fname = $myFirst;
    $ex_lname = $myLast;
    $exec_action_on = date("F j, Y, g:i a");
    // who gets the email
    $to = ['name' => $current['firstname'] . ' ' . $current['lastname'], 'email' => $current['email']];
    sendExecActionEmail($id, $to, $ex_fname . ' ' . $ex_lname, $action, $fertilizer, $meridian_contract);
  } else {
    $action_result = 'failed';
  }
}
?>
<div class="page-content-wrapper m-2">
  <div id="content" class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Analysis Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i> <a class="parent-item" href="index.php">Home</a> <i class="fa fa-angle-right"></i>
          <li><a class="parent-item" href="">Report</a> <i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Sample Analysis</li>
        </ol>
      </div>
    </div>

    <div class="row" id="fmPrint">
      <div class="col-md-12">
        <div class="white-box p-5">
          <div class="report-background d-none d-print-block"><img src="images/name.png" alt="" width="auto" height="25px"> </div>
          <div class="report-background1 d-print-none"><img src="images/top.png" alt="" width="150px" height="auto"> </div>
          <div class="report-background01 d-none d-print-block"><img src="images/top.png" alt="" width="150px" height="auto"> </div>
          <div class="report-background2"><img src="images/bottom.png" alt="" width="150px" height="auto"> </div>

          <div class="p-3">

            <?php
            if (!isset($exec_action) && isset($action_result)) {
              $alertColor = $action_result == 'success' ? "#00ff00" : "#ff0000";
              $title = $action_result == 'success' ? "Action Set Successfully" : "Action could not be set";
              $message = $action_result == 'success' ? "Action Set Successfully" : "Action could not be set";
            ?>
              <div class="col-md-12">
                <div class="card  card-topline-<?php echo $action_result == 'success' ? 'green' : 'red'; ?>">
                  <div class="card-body no-padding height-12">
                    <div class="noti-information notification-menu">
                      <div class="notification-list">
                        <h4>
                          <center>
                            <font color="<?php echo $alertColor; ?>"><?php echo $title; ?></font>
                          </center>
                        </h4>
                        <center>
                          <?php if ($action_result == 'success') { ?>
                            <font color="green"><i class="fa fa-check"></font></i>
                          <?php } else { ?>
                            <font color="red"><i class="fa fa-times"></font></i>
                          <?php } ?>
                          <strong><?php echo $message; ?></strong>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php }
            if (!isset($exec_action) && !isset($action)) { ?>
              <div class="text-right" id="executive-button">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle d-print-none" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Executive Action <i class="fa fa-angle-down"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php
                    $result = mysql_query("SELECT * FROM exec_action ORDER BY name");
                    while ($row = mysql_fetch_array($result)) {
                      echo "<a class='dropdown-item' href='analysis_report.php?id=$id&exec_action={$row['id']}'>{$row['name']}</a>";
                    } ?>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Reject Results</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="<?php echo "/analysis_approval.php?id=$id&approve=false"; ?>" method="POST">
                      <div class="modal-body">
                        <div>
                          <input type="text" name="comments" placeholder="Comments" class="form-control" />
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!---- Report Header ----->
              <p class="title-background mt-3 pl-3 d-print-none">MALAWI FERTILIZER COMPANY</p>

              <div class="text-center report-header">
                <p id="report-header" class="mt-2">CERTIFICATE OF ANALYSIS</p>
                <div class="d-inline-flex align-items-center">
                  <div class="horizontal-line-sample"></div>
                  <h4 class="ml-5 mr-5"><b>SAMPLE NUMBER<b></h4>
                  <div class="horizontal-line-sample"></div>
                </div>
                <p class="text-success" id="sample-id">
                  <?php
                  $snum = $sampleId ?? $sample_number ?? $sampleNum;
                  echo $sample_id != null
                    ? "<a href='sample.php?id=$sample_id' target='__blank'>$snum</a>"
                    : $snum;
                  ?>
                </p>

              </div>
              <!---- End Of Report Header ----->

              <div class="horizontal-line"></div>

            <?php } ?>
            <?php echo ($is_sweeping ? "<span class='pill blend'>Sweepings Batch</span>" : ""); ?>
            <?php echo ($isVisual ? "<span class='pill blend'>Visual Inspection</span>" : ""); ?>
            <?php include('includes/analysis_beta.php'); ?>

            <div class="horizontal-line"></div>

            <?php if (isset($action)) { ?>
              <div class="container bg-light p-4 text-center rounded">
                <h5>EXECUTIVE ACTION: <b class="text-primary">
                    <?php echo $action; ?>
                  </b>
                  <span class="px-4"> | </span> BY: <b class="text-primary">
                    <?php echo "$ex_fname $ex_lname"; ?>
                  </b>
                  <span class="px-4"> | </span> ON: <b class="text-primary">
                    <?php echo date("F j, Y, g:i a", strtotime($exec_action_on)); ?>
                  </b>
                </h5>
              </div>
            <?php } ?>
            <h3><b>CERTIFICATE OF RESULTS: <?php echo ($is_blend ? "<span class='pill blend'>Blended Material" : "<span class='pill raw'>Raw Material"); ?></span></h3>
            <?php
            $lowerLimit = getFertilizerLimits($fertilizer_name, FertLimit::LOWER);
            $upperLimit = getFertilizerLimits($fertilizer_name, FertLimit::UPPER);
            $specs = compareLimits($current, $lowerLimit, $upperLimit, $is_blend);
            if (isset($exec_comments) && strstr($exec_comments, 'Dusty')) {
              echo "<div class='text-white center p-2 mt-2 dusty'>Warning: Dusty</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Wet')) {
              echo "<div class='text-white center p-2 mt-2 wet'>Warning: Wet</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Damaged')) {
              echo "<div class='text-white center p-2 mt-2 damaged'>Warning: Damaged</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Reactant')) {
              echo "<div class='text-white center p-2 mt-2 reactant'>Warning: Reactant</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Lumpy')) {
              echo "<div class='text-white center p-2 mt-2 wet'>Warning: Lumpy</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Powder')) {
              echo "<div class='text-white center p-2 mt-2 dusty'>Warning: Powder</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Caked')) {
              echo "<div class='text-white center p-2 mt-2 damaged'>Warning: Caked</div>";
            }
            if (isset($exec_comments) && strstr($exec_comments, 'Contaminated')) {
              echo "<div class='text-white center p-2 mt-2 wet'>Warning: Contaminated</div>";
            }
            ?>

            <div class="horizontal-line" id="analysis-date"></div>

            <div class="row">
              <div class="col-md-12">

                <div class="pull-left text-right">
                  <address>

                    <p class="m-t-30">
                      <b>Chemical Analysis Date :</b> <i class="fa fa-calendar"></i class="text-primary">
                      <?php echo "$sampleDate"; ?>
                    </p>
                  </address>
                </div>
              </div>
              <div class="col-md-12">
                <div class="table-responsive m-t-40">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-12"></div>
                      <div class="col-sm-12">
                        <br>
                        <?php include("includes/anaylsis_details.php"); ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <hr>
                        <?php if (isset($remarks) && $remarks != '') { ?>
                          <p><b>QA COMMENTS:</b> <?php echo $remarks; ?></p>
                        <?php }
                        if (isset($exec_remarks) && $exec_remarks != '') { ?>
                          <p><b>QA REMARKS:</b> <?php echo $exec_remarks; ?></p>
                        <?php }
                        if (isset($qa_fname) && $qa_fname != '') { ?>
                          <p><b>QA:</b> <?php echo "$qa_fname $qa_lname"; ?></p>
                        <?php } ?>
                        <hr>
                        <?php if (isset($lab_comments) && $lab_comments != '') { ?>
                          <p><b>LAB COMMENTS:</b> <?php echo $lab_comments; ?></p>
                        <?php }
                        if (isset($lb_fname) && $lb_fname != '') { ?>
                          <p><b>LAB:</b> <?php echo "$lb_fname $lb_lname"; ?></p>
                        <?php } ?>
                      </div>
                      <div class="col-sm-1" style="background-color:lavender;"></div>
                    </div>
                    <div class="row">
                      <div class="col-sm-10"><?php include("includes/test_images_print.php"); ?></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <?php
                if (isset($shortname) && $shortname != NULL)
                  $logo = "images/logos/" . strtolower($shortname) . ".png";
                else $logo = "images/logo.png";
                ?>
                <img src="<?php echo $logo; ?>" height="80">
              </div>
              <div class="col-md-12">
                <div class="clearfix"></div>
                <hr>

                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-12">
        <div class="text-right">
            <?php if (!$full) { ?>
              <a href="analysis_report.php?id=<?php echo $id; ?>&full=true" class="btn btn-default btn-outline">View Full Report</a>
            <?php }
            if (isset($filename) && $filename != '') { ?>
              <a id="manufacturer" class="btn btn-default btn-outline" target="_blank" href="<?php echo $filename; ?>"> <span><i class="fa fa-download"></i> Manufacturer Certificate</span> </a>
            <?php } ?>
            <button id="download1" class="btn btn-default btn-outline d-print-none" type="button"> <span><i class="fa fa-download"></i> Download</span> </button>
            <!---<button onclick="javascript:window.print();" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>--->
            <button onclick="printReport()" class="btn btn-default btn-outline d-print-none" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
        </div>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
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

</div>
<?php include("includes/javascript_includes.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.0/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
<script type="module">
  var jsPDF = window.jspdf.default;
  var doc = jsPDF({
    format: 'a3',
    orientation: 'p',
    compress: true
  });
  var specialElementHandlers = {
    '#editor': function(element, renderer) {
      return true;
    }
  };

  $('#download').click(function() {

    doc.setDisplayMode('fullheight')
    let content = document.getElementById('fmPrint')
    let srcwidth = content.scrollWidth;
    doc.html(content, {
      html2canvas: {
        scale: 0.3, //595.26 / srcwidth, //595.26 is the width of A4 page
        width: 595,
        scrollY: 0,
        scrollX: 0
      },
      callback: function(doc) {
        // doc.autoPrint();
        doc.save();
      },
      x: 10,
      y: 10
    });
  });
</script>
<script>
  function printReport() {
    var restorePage = document.body.innerHTML;
    var printContent = document.getElementById('fmPrint').innerHTML;

    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = restorePage;
  }

  window.onload = function() {
    document.getElementById("download1").addEventListener("click", () => {
      const report = this.document.getElementById('fmPrint');
      var executiveButton = this.document.getElementById('executive-button');
      executiveButton.style.display = 'none';
      var opt = {
        margin: 0.2,
        filename: 'Analysis Report.pdf',
        image: {
          type: 'jpeg',
          quality: 0.98
        },
        html2canvas: {
          scale: 2
        },
        jsPDF: {
          unit: 'in',
          format: 'a3',
          orientation: 'portrait'
        }
      };

      html2pdf().from(report).set(opt).save();
    });
  }
</script>
</body>

</html>