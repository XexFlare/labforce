<?php include("includes/header.php");
$query  = "SELECT * FROM tbl_system_users ORDER BY lastname, firstname";
$users = mysql_query($query);
$allUsers = mysql_num_rows($users);
?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">USER MANAGEMENT</div>
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
              <header class="panel-heading panel-heading-purple">
                SYSTEM USERS </header>
              <div class="panel-body">
                <div class="panel tab-border card-topline-aqua">
                  <header class="panel-heading panel-heading-gray custom-tab">
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a href="#add" data-toggle="tab"> <i class="fa fa-plus"></i>Add User
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#all" data-toggle="tab" class="active">
                          <i class="fa fa-group"></i> All Users (<font color="#ff0000"><?php echo "$allUsers"; ?></font>)
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#admin" data-toggle="tab">
                          <i class="fa fa-wrench"></i> IT Administrators
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#managers" data-toggle="tab">
                          <i class="fa fa-file-text-o"></i> Managers
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#lab" data-toggle="tab">
                          <i class="fa fa-bar-chart"></i> Lab Technicians
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="sample_techs.php"><i class="fa fa-bar-chart"></i> Sample Techs</a>
                    </ul>
                  </header>
                  <div class="panel-body">
                    <div class="tab-content">
                      <div class="tab-pane " id="add"><?php include("includes/user_add.php"); ?>
                      </div>

                      <div class="tab-pane active" id="all">
                        <?php include("includes/users_all.php"); ?>
                      </div>

                      <div class="tab-pane " id="admin">
                        <?php include("includes/users_admin.php"); ?> </div>

                      <div class="tab-pane " id="managers">
                        <?php include("includes/users_manager.php"); ?> </div>

                      <div class="tab-pane " id="lab">
                        <?php include("includes/users_lab.php"); ?> </div>
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
<script src="assets/jquery.min.js"></script>
<script src="assets/popper/popper.js"></script>
<script src="assets/jquery.blockui.min.js"></script>
<script src="assets/jquery.slimscroll.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js"></script>
<script src="assets/table_data.js"></script>
<script src="assets/app.js"></script>
<script src="assets/layout.js"></script>
<script src="assets/theme-color.js"></script>
<script src="assets/material/material.min.js"></script>
</body>

</html>