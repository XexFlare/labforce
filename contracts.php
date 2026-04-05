<?php
include("includes/redirects.php");
if (redirect()) return;
include("includes/header.php");
include('includes/helpers.php');
?>
  <div class="page-content-wrapper">
    <div id="content" class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">Contract Reports</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i> <a class="parent-item" href="index.php">Home</a> <i class="fa fa-angle-right"></i>
            <li><a class="parent-item" href="">Contract Reports</a> <i class="fa fa-angle-right"></i></li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="white-box">
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
                              <th>Contract</th>
                              <th>Fertilizer</th>
                              <th>Vessel</th>
                              <th>Blend Type</th>
                              <th>Supplier</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query  = "SELECT c.*,b.name, s.details FROM tbl_contracts as c 
                            left join tbl_blend_types as b on c.blend_type_id = b.id
                            left join tbl_suppliers as s on c.supplier_id = s.supplierID ORDER BY meridian_contract";
                            $results = mysql_query($query);
                            $nrows = mysql_num_rows($results);
                            for ($i = 0; $i < $nrows; $i++) {
                              $n = $i + 1;
                              $row = mysql_fetch_array($results);
                              extract($row);
                              $sql = "SELECT * FROM tbl_fertilizer_types 
                              WHERE fertilizerID='$fertilizer_name'";
                              $result = mysql_query($sql);
                              $nrow = mysql_num_rows($result);
                              while ($row = mysql_fetch_array($result)) {
                                $fertilizer = $row["fertilizer"];
                                $blend = $row["blend"];
                              }
                              $visible = $hidden ? 'warning' : 'success';
                              $blend = $is_blend ? 'success' : 'warning';
                              $sweep = $is_sweeping ? 'success' : 'warning';
                              $hidden_text = $hidden ? 'Show' : 'Hide';
                              echo "
                                <tr>
                                  <td>$n</td>
                                  <td>$meridian_contract</td>
                                  <td>$fertilizer</td>
                                  <td>$vessel</td>
                                  <td>$name</td>
                                  <td>$details</td>
                                  <td>$contractDate</td>
                                  <td>
                                    <a target='_blank' href='report.php?type=contract&id=$contractID' class='btn btn-success btn-xs'>
                                      <i class='fa fa-eye '></i>
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