<?php include("includes/header.php"); ?>
<div id="top"></div>
<div class="page-content-wrapper">
  <div class="page-content">
    <?php include("batch_list_home.php"); ?>
    <?php include("includes/footer.php"); ?>
  </div>
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
          return `<a href='analysis_report.php?id=${row[13]}' target="__blank" class="d-flex flex-column flex-grow px-2 py-4">${data}</a>`;
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