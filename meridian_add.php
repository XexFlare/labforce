<?php include("includes/header.php"); ?>
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">System Settings</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Form</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-7">
        <form action="meridian_add2.php" id="form_sample_1" class="form-horizontal" method="POST">
          <div class="card-box">
            <div class="card-head">
              <header>Meridian Details</header>
            </div>
            <div class="card-body row">

              <div class="col-lg-6 p-t-20">
                <div class="mdl-textfield mdl-js-textfield">
                  <input class="mdl-textfield__input" type="text" name="meridian" id="text1" required>
                  <label class="mdl-textfield__label" for="text1">Meridian</label>
                </div>
              </div>
              <div class="col-lg-12 p-t-20">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                  Add Item
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-5">
        <div class="panel">
          <header class="panel-heading panel-heading-blue">
            CURRENT LIST </header>
          <div class="panel-body"><?php include("includes/meridian_list.php"); ?></div>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>