<?php
include("includes/header.php");
include('includes/helpers.php');

$trail = mysql_query("SELECT t.*, CONCAT_WS(' ', u.firstname, u.lastname) AS user 
FROM trail as t
LEFT JOIN tbl_system_users as u on t.user = u.userID
ORDER BY date DESC
");
?>
<style>
  .pill {
    font-size: 15px;
    font-weight: bold;
    padding: 5px;
    color: white;
    border-radius: 5px;
    margin-left: 10px;
  }
</style>
<div class="page-content-wrapper">
  <div id="content" class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Audit Trail</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i> <a class="parent-item" href="index.php">Home</a> <i class="fa fa-angle-right"></i>
          <li><a class="parent-item" href="">Audit Trail</a> <i class="fa fa-angle-right"></i></li>
        </ol>
      </div>
    </div>
    <div class="col-md-12">
      <div class="white-box">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="form-inline">
            <input type="text" id="name" placeholder="Name" class="form-control form-control-sm">
            <input type="date" id="date" class="form-control form-control-sm ml-4">
          </div>
          <div class="table-wrap">
            <div class="table-scrollable">
              <table class="table table-hover table-checkable order-column full-width" id="example1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Table</th>
                    <th>Operation</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>View</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $trailJson = []; $n=1; while ($row = mysql_fetch_assoc($trail)) {
                    $trailJson[] = $row;
                    extract($row);
                    $class = $operation == "INSERT" 
                      ? "bg-success" 
                      : ($operation == "DELETE" ? "bg-danger" : "bg-info");
                    $date = date('d M, Y H:i', strtotime($date));
                    echo "<tr>";
                    echo "<td>".$n++."</td>";
                    echo "<td>$table</td>";
                    echo "<td><span class='pill $class'>$operation</span></td>";
                    echo "<td>$user</td>";
                    echo "<td>$date</td>";
                    echo "<td>
                        <a class='btn btn-success btn-xs' data-toggle='modal' data- data-target='#rejectModal' onclick=show($id)>
                          <i class='fa fa-eye '></i>
                        </a>
                      </td>";
                    echo "</tr>";
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
<?php include("includes/footer.php"); ?>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Audit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/javascript_includes.php"); ?>
<script>
  <?php $trailJson = json_encode($trailJson);
    echo "var trail = $trailJson";
  ?>;
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var dateStr = $('#date').val()
    var dateMatch = true;
    if(dateStr.length > 0){
      var date = new Date(Date.parse(dateStr))
      var rowDate = new Date(Date.parse(data[4]))
      if(date.toDateString() == rowDate.toDateString()) dateMatch = true;
      else dateMatch = false;
    }
    var nameCol = data[3]
    var name = $('#name').val();
    if (dateMatch &&
      (name.length == 0 || nameCol.toLowerCase().includes(name.toLowerCase()))
    ) {
        return true;
    }
    return false;
  });
  
  $(document).ready(function () {
    var table = $('#example1').DataTable();
    $('#date, #name').keyup(function () {
        table.draw();
    });
    $('#date').bootstrapMaterialDatePicker().on('change', function(e, date){
        table.draw();
      })
  });
  function show(id) {
    const details = trail.find((item) => item.id == id)
    const json = JSON.parse(details.values)
    const values = Object.keys(json).map(function (key) {
      return `<span>${key}: ${json[key]}</span>`;
    });
    const opclass = details.operation == "INSERT" 
      ? "bg-success" 
      : (details.operation == "DELETE" ? "bg-danger" : "bg-info");
    const body = `<div class='modal-body'>
      <h5>Table: ${details.table}</h5>
      <h5>Resource ID: ${details.resource_id}</h5>
      <h5>Operation: <span class="pill ${opclass}">${details.operation}</span></h5>
      <h5>User: ${details.user}</h5>
      <h4>Values</h4>
      <div class="card p-4 font-italic">
        ${values.join('')}
      </div>
    </div>`;
    $(".modal-body").replaceWith(body);

  }
</script>
</body>
</html>
