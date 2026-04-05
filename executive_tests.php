<?php include("includes/header.php"); ?>
  <div id="top"></div>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">Welcome: <font color="#36A2EB"><?php echo "$myFirst $myLast"; ?></font>
            </div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Executive Tests</li>
          </ol>
        </div>
      </div>
      <?php $nav = false; ?>
      <?php $executive = true; ?>
      <?php include("includes/notifications.php"); ?>
      <?php include("batch_list_home.php"); ?>
      <?php include("includes/footer.php"); ?>
    </div>
    <?php include("includes/javascript_includes.php"); ?>
    <script>
      $(document).ready(function () {
        $('#batches').dataTable({
          "scrollX": true,
          "columnDefs": [
            {
            "targets": "_all",
            "render": function ( data, type, row, meta ) {
              return `<a href='analysis_report.php?id=${row[13]}' target="_blank" class="d-flex flex-column flex-grow px-2 py-4">${data}</a>`;
            }
          }]
        });
    });
    </script>
    <style>
    td {
      padding: 0 !important;
    }
    </style>
    </body>
    </html>