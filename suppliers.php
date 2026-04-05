<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">FERTILIZER SUPPLIERS</div>
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
              <header class="panel-heading panel-heading-yellow">
                SUPPLIERS </header>
              <div class="panel-body">
                <div class="panel tab-border card-topline-aqua">
                  <header class="panel-heading panel-heading-gray custom-tab">
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a href="#all" data-toggle="tab" class="active">
                          <?php 
                            $allSuppliers = mysql_numrows(mysql_query("select * from tbl_suppliers"));
                          ?>
                          <i class="fa fa-truck"></i> All Suppliers (<font color="#ff0000"><?php echo "$allSuppliers"; ?></font>)
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="#add" data-toggle="tab"> <i class="fa fa-plus"></i>Add Supplier
                        </a>
                      </li>
                    </ul>
                  </header>
                  <div class="panel-body">
                    <div class="tab-content">

                      <div class="tab-pane " id="add"><?php include("includes/supplier_add.php"); ?>
                      </div>

                      <div class="tab-pane active" id="all">
                        <?php include("includes/suppliers_all.php"); ?>
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
  <?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>