<?php include("includes/header.php");
include('includes/helpers.php');
$server = getenv('APP_URL');
?>
 
   
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">RESEND</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Dashboard</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel">
            <header class="panel-heading panel-heading-purple">
              RESEND
            </header>
            <div class="panel-body">
            </div>
            <div class="card-body ">
              <?php
              $comments = "Contaminated";
              $fertilizer = "Urea (46-0-0)";
              $meridian_contract = "MG3509";
              sendWarningEmail(781, $fertilizer, $meridian_contract, $comments);
              ?>
              <hr>
            </div>
          </div>
        </div>
      </div>
      <?php include("includes/footer.php"); ?>
    </div>
    </body>

    </html>