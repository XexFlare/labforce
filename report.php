<?php
include("includes/redirects.php");
if (redirect()) return;
include("includes/header.php");
include('includes/helpers.php');

$id = $_GET['analysisID'] ?? $_GET['id'];
$type = $_GET['type'] ?? 'contract';
if ($type == 'contract') {
  $query = mysql_query("SELECT c.*, s.details, co.country, b.name as blend, f.fertilizer from tbl_contracts AS c
  LEFT JOIN tbl_suppliers AS s ON s.supplierID = c.supplier_id
  LEFT JOIN tbl_blend_types AS b ON b.id = c.blend_type_id 
  LEFT JOIN tbl_countries AS co ON co.countryID = s.country
  LEFT JOIN tbl_fertilizer_types AS f ON f.fertilizerID = c.fertilizer_name
  WHERE contractID=$id");
  $condition = "WHERE c.contractID = $id
  AND a.item = 'LAB RESULTS'";
} else {
  $query = mysql_query("SELECT * from tbl_fertilizer_types
  WHERE fertilizerID=$id");
  $fertilizer_name = $id;
  $condition = "WHERE c.fertilizer_name = $id
  AND a.item = 'LAB RESULTS'";
  $resCondition = "WHERE c.contractID=$id";
}
$current = mysql_fetch_array($query);
extract($current);
$resultsQuery = mysql_fetch_array(mysql_query("SELECT ROUND(damaged / total * 100, 1) AS damaged_rate, 
ROUND(spec / total * 100, 1) AS spec_rate, 
ROUND(good / total * 100, 1) AS good_rate, 
damaged, total, spec, good
FROM (
	SELECT 
	COUNT(*) as total,
	COUNT(IF(exec_comments IS NOT NULL AND exec_comments <> '', 1, null)) AS damaged,
	COUNT(IF(
       cast(a.n as float) < cast(lowr.n as float) OR cast(a.n as float) > cast(upr.n as float)
    OR cast(a.p2o5 as float) < cast(lowr.p2o5 as float) OR cast(a.p2o5 as float) > cast(upr.p2o5 as float)
    OR cast(a.k2o as float) < cast(lowr.k2o as float) OR cast(a.k2o as float) > cast(upr.k2o as float)
    OR cast(a.s as float) < cast(lowr.s as float) OR cast(a.s as float) > cast(upr.s as float)
    OR cast(a.b as float) < cast(lowr.b as float) OR cast(a.b as float) > cast(upr.b as float)
    OR cast(a.zn as float) < cast(lowr.zn as float) OR cast(a.zn as float) > cast(upr.zn as float), 
    1, null)) AS spec,
	COUNT(IF(
    (lowr.n is null OR cast(a.n as float) >= cast(lowr.n as float) AND cast(a.n as float) <= cast(upr.n as float))
	    AND (lowr.p2o5 is null OR cast(a.p2o5 as float) >= cast(lowr.p2o5 as float) AND cast(a.p2o5 as float) <= cast(upr.p2o5 as float))
	    AND (lowr.k2o is null OR cast(a.k2o as float) >= cast(lowr.k2o as float) AND cast(a.k2o as float) <= cast(upr.k2o as float))
	    AND (lowr.s is null OR cast(a.s as float) >= cast(lowr.s as float) AND cast(a.s as float) <= cast(upr.s as float))
	    AND (lowr.b is null OR cast(a.b as float) >= cast(lowr.b as float) AND cast(a.b as float) <= cast(upr.b as float))
	    AND (lowr.zn is null OR cast(a.zn as float) >= cast(lowr.zn as float) AND cast(a.zn as float) <= cast(upr.zn as float))
    AND (exec_comments IS NULL OR exec_comments = ''), 
    1, null)) AS good
	FROM tbl_analysis AS a
	LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
	LEFT JOIN tbl_contracts AS c ON c.contractID = b.contractID
	LEFT JOIN tbl_fertilizer_limits as lowr ON (lowr.item = 'LOWER LIMIT' and lowr.fertilizerID = c.fertilizer_name)
	LEFT JOIN tbl_fertilizer_limits as upr ON (upr.item = 'UPPER LIMIT' and upr.fertilizerID = c.fertilizer_name)
   $condition) AS dmg
"));
extract($resultsQuery);
$results = mysql_query("SELECT a.*, b.batchNum, co.color, c.meridian_contract FROM tbl_analysis AS a
LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
LEFT JOIN tbl_contracts AS c ON c.contractID = b.contractID
LEFT JOIN tbl_colors as co ON b.color = co.colorID $condition");
?>
<div class="page-content-wrapper">
  <div id="content" class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title"><?php echo $type == 'contract' ? "Contract" : "Fertilizer"; ?> Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i> <a class="parent-item" href="index.php">Home</a> <i class="fa fa-angle-right"></i>
          <li><a class="parent-item" href=""><?php echo $type == 'contract' ? "Contract" : "Fertilizer"; ?> Report</a> <i class="fa fa-angle-right"></i></li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="white-box">
          <div class="row">
            <?php if ($type == 'contract') { ?>
              <div class="col-md-6">
                <h5>CONTRACT: <b class="text-primary">
                    <?php echo "$meridian_contract"; ?>
                  </b></h5>
                <h5>VESSEL NAME: <b class="text-primary">
                    <?php echo "$vessel"; ?>
                  </b></h5>
                <h5>SUPPLIER: <b class="text-primary">
                    <?php echo "$details"; ?>
                  </b></h5>
                <h5>COUNTRY OF ORIGIN: <b class="text-primary">
                    <?php echo "$country"; ?>
                  </b></h5>
                <h5>BLEND TYPE: <b class="text-primary">
                    <?php echo "$blend"; ?>
                  </b></h5>
                <?php if ($is_blend && isset($acc_reference)) { ?>
                  <h5>ACCPAC REFERENCE: <b class="text-primary">
                      <?php echo $acc_reference; ?>
                    </b></h5>
                <?php } ?>
              </div>
            <?php } else { ?>
              <div class="col-md-6">
                <h5>Fertilizer: <b class="text-primary">
                    <?php echo "$fertilizer"; ?>
                  </b></h5>
              </div>
            <?php } ?>
          </div>
          <?php
          function renderStat($title, $num, $total, $class = 'info')
          {
            $percentage = $num > 0 && $total > 0 ? round($num / $total * 100) : 0;
          ?>
            <div class="states">
              <div class="info">
                <div class="desc pull-left"><?php echo $title; ?> (<?php echo $num; ?>)</div>
                <div class="percent pull-right"><?php echo $percentage; ?>%</div>
              </div>
              <div class="progress progress-xs">
                <div class="progress-bar progress-bar-<?php echo $class; ?> progress-bar-striped active" role="progressbar" style="width: <?php echo $percentage; ?>%">
                  <span class="sr-only"><?php echo $percentage; ?>% </span>
                </div>
              </div>
            </div>
          <?php } ?>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-head card-topline-aqua">
                <header><?php echo $type == 'contract' ? "Contract" : "Fertilizer"; ?> Report</b> <i class="fa fa-book"></i class="text-primary"></header>
              </div>
              <div class="card-body no-padding height-9">
                <div class="work-monitor work-progress">
                  <?php
                  renderStat("Tests Done", $total, $total);
                  renderStat("Good Results", $good, $total, 'success');
                  renderStat("Out of Spec Results", $spec, $total, 'warning');
                  renderStat("Damaged Results", $damaged, $total, 'danger');
                  ?>
                </div>
              </div>
            </div>
          </div>
          <a class="btn btn-primary" href="report_download.php?<?php echo "type=$type&id=$id"; ?>"><i class="fa fa-download"></i> Download</a>
          <div class="row">
            <div class="col-md-12">
              <h3><?php echo $type == 'contract' ? "Contract" : "Fertilizer"; ?> Results</h3>
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
                            <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo date("d/m/Y", strtotime($time)); ?></font>
                          </td>
                          <td title='$blend'>
                            <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $fertilizer;
                                                                                              echo $isVisual ? '<span class="pill blend">Visual</span>' : ''; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $batchNum; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $meridian_contract; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $color; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $n; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $p2o5; ?> </font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $k2o; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $s; ?></font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $b; ?> </font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $zn; ?> </font>
                          </td>
                          <td>
                            <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $total; ?> </font>
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

  .list-visual {
    background-color: #edf5f7;
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.0/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
<script type="module">
  var jsPDF = window.jspdf.default;
  var doc = jsPDF({
    format: 'a3',
    orientation: 'l',
    compress: true
  });
  var specialElementHandlers = {
    '#editor': function(element, renderer) {
      return true;
    }
  };

  $('#download').click(function() {

    doc.setDisplayMode('fullheight')
    let content = document.getElementById('content')
    let srcwidth = content.scrollWidth;
    doc.html(content, {
      html2canvas: {
        scale: 0.3, //595.26 / srcwidth, //595.26 is the width of A4 page
        width: 595,
        scrollY: 0
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
</body>

</html>