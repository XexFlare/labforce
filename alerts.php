<?php
$requiredLevel = 1;
include("includes/header.php");
$add;
$message;
if (isset($_GET['del'])) {
  $query = "DELETE FROM alert_recipients WHERE  email= '{$_GET['del']}' ";
  $delete = mysql_query($query);
}
if (isset($_GET['main'])) {
  $query = "UPDATE alert_recipients SET main = 1 WHERE email= '{$_GET['main']}'";
  mysql_query($query);
  $query = "UPDATE alert_recipients SET main = 0 WHERE email != '{$_GET['main']}'";
  mysql_query($query);
}
if (isset($_POST['submit'])) {
  $name = isset($_POST['name']) ? trim(urldecode($_POST['name'])) : '';
  $condition = isset($_POST['condition']) ? join(', ', array_keys($_POST['condition'])) : '';
  $unit = isset($_POST['unit']) ? $_POST['unit'] : NULL;
  $email = isset($_POST['email']) ? trim(urldecode($_POST['email'])) : '';
  $record = "INSERT INTO alert_recipients (`name`, `email`, `condition`,`main`, `unit`) VALUES ('" . addslashes($name) . "','" . addslashes($email) . "','" . addslashes($condition) . "',0 ,$unit)";
  try {
    $add = mysql_query($record);
    if (mysql_error()) {
      switch (mysql_errno()) {
        case 1062:
          $message = "This email address is already registered";
          break;
          default:
          $message = mysql_error() .  " $condition " . mysql_errno();
          break;
      }
      $add = 'error';
    }
  } catch (Throwable $th) {
    $add = 'error';
    $message = $th;
  }
}

$query = "SELECT * FROM alert_recipients";
$results = mysql_query($query);
$allAlerts = mysql_num_rows($results);
?>
 
   
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">Alert Recipients</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Dashboard</li>
          </ol>
        </div>
      </div>
      <?php if (isset($add) && $add === true) {
        $hideBack = true;
        include("includes/success.php");
      } else if (isset($add) && $add == 'error') {
        $hideBack = true;
        include("includes/error.php");
      }
      ?>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel">
                <header class="panel-heading panel-heading-yellow">
                  Alerts </header>
                <div class="panel-body">
                  <div class="panel tab-border card-topline-aqua">
                    <header class="panel-heading panel-heading-gray custom-tab">
                      <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a href="#all" data-toggle="tab" class="active">
                            <i class="fa fa-truck"></i> All Recipients (<font color="#ff0000"><?php echo "$allAlerts"; ?></font>)
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="#add" data-toggle="tab"> <i class="fa fa-plus"></i>Add Recipient</a>
                        </li>
                      </ul>
                    </header>
                    <div class="panel-body">
                      <div class="tab-content">
                        <div class="tab-pane " id="add">
                          <div class="row">
                            <div class="col-md-12 col-sm-12">
                              <header><b>ADD RECIPIENT:</b></header>
                              <div class="card card-box">
                                <div class="card-body">
                                  <form method="POST" action="alerts.php" class="form-horizontal">
                                    <div class="form-body">
                                      <div class="form-group row">
                                        <label class="control-label col-md-3">Name
                                          <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-5">
                                          <input type="text" name="name" required placeholder="Name" class="form-control input-height" />
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label class="control-label col-md-3">Email
                                          <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-5">
                                          <div class="input-group">
                                            <input type="email" name="email" required class="form-control input-height" placeholder="Email">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label class="control-label col-md-3">Condition
                                        </label>
                                        <div class="col-md-5">
                                          <div class="input-group">
                                            <label class="control-label pr-4"><input type='checkbox' class="mr-2" name="condition[APPROVALS]">APPROVALS</label>
                                            <label class="control-label pr-4"><input type='checkbox' class="mr-2" name="condition[REPORTS]">REPORTS</label>
                                            <label class="control-label pr-4"><input type='checkbox' class="mr-2" name="condition[EXEC_ACTION]">EXECUTIVE ACTION</label>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <label for="horizontalFormEmail" class="col-sm-3 control-label">Business Unit:</label>
                                        <span class="required"></span>
                                        <div class="col-md-5">
                                          <div class="search-box">
                                            <select name='unit' class='form-control input-height'>
                                              <option selected='false' value=''>Select Business Unit
                                              </option>
                                              <?php
                                              $result = mysql_query("select * from tbl_business_units ORDER BY unit_name ASC") or die("Couldn't execute query.");
                                              while ($row = mysql_fetch_array($result)) {
                                                extract($row);
                                                echo "<option value='$unitID'>$unit_name\n";
                                              }
                                              ?>
                                            </select>
                                            <div class="result"></div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                        <div class="row">
                                          <div class="offset-md-3 col-md-9">
                                            <button type="submit" name="submit" class="btn btn-info">Add Recipient</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane active" id="all">
                          <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                              <div class="card card-box">
                                <div class="card-head">
                                  <header>All Registered recipients:</header>
                                  <div class="tools">
                                    <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                    <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                  </div>
                                </div>
                                <div class="card-body ">
                                  <div class="table-wrap">
                                    <div class="table-scrollable">
                                      <table class="table table-hover table-checkable order-column full-width" id="example4">
                                        <thead>
                                          <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Condition</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          $query  = "SELECT * FROM alert_recipients";
                                          $results = mysql_query($query);
                                          $nrows = mysql_num_rows($results);
                                          $row = mysql_num_rows($results);
                                          for ($i = 0; $i < $nrows; $i++) {
                                            $row = mysql_fetch_array($results);
                                            extract($row);
                                            echo "
                                                                                            <tr ";
                                            if ($main) echo 'class="font-bold"';
                                            echo "> 
                                                                                                <td>$name</td>
                                                                                                <td>$email</td>
                                                                                                <td>$condition</td>
                                                                                                <td>
                                                                                                    <a href='alerts.php?del=$email' class='btn btn-danger btn-xs'>
                                                                                                    <i class='fa fa-trash-o '></i>
                                                                                                    </a>";
                                            if (!$main) {
                                              echo "
                                                                                                        <a href='alerts.php?main=$email' class='btn btn-success btn-xs'>
                                                                                                        <i class='fa fa-check '></i>
                                                                                                        </a>";
                                            }
                                            echo "</td>
                                                                                            </tr>  ";
                                          }
                                          ?>
                                          <!-- <a href='alerts.php?edit=$id'; class='btn btn-primary btn-xs'>
                                                                                    <i class='fa fa-pencil'></i>
                                                                                    </a> -->
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