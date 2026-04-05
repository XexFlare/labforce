  <?php include("includes/header.php");
  $id = $_GET['id'];
  $sql = "SELECT * FROM tbl_fertilizer_types WHERE fertilizerID='$id'";
  $result = mysql_query($sql);
  $nrows = mysql_num_rows($result);
  while ($row = mysql_fetch_array($result)) {
    $fertilizer = $row["fertilizer"];
    $blend = $row["blend"];
  }
  ?>
    <div class="page-content-wrapper">
      <div class="page-content">
        <div class="page-bar">
          <div class="page-title-breadcrumb">
            <div class=" pull-left">
              <div class="page-title">
                <h3>Fertilizer: <font color="#FF0000"><?php echo "$fertilizer"; ?> </font>Blend: <font color="#FF0000"><?php echo "$blend"; ?></font>
                </h3>
              </div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right">
              <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
              </li>
              <li><a class="parent-item" href="">Fertilizer</a>&nbsp;<i class="fa fa-angle-right"></i>
              </li>
              <li class="active">Limits</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">

            <div class="row">

              <div class="col-md-8 col-sm-8">
                <div class="card card-topline-lightblue">
                  <div class="card-head">
                    <header>
                      <font color="#008080">DEFAULT FERTILIZER LAB LIMITS</font>
                    </header>
                  </div>
                  <div class="card-body" id="line-parent">
                    <div class="panel-group accordion" id="accordion3">
                      <table border="1" width="100%" id="table1">
                        <tr>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">ITEM</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">MOISTURE</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">N</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">P<font size="1">2</font>O<font size="1">5</font>
                            </font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">K<font size="1">2</font>O</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">S</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">B</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">Zn</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">pH</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666">TOTAL</font>
                          </td>
                          <td bgcolor="#C0C0C0" align="center">
                            <font color="#006666"><i class="fa fa-trash"></i></font>
                          </td>
                        </tr>
                        <?php
                        function hmm($name, $id){
                          $query = "SELECT * FROM tbl_fertilizer_limits WHERE fertilizerID='$id' && item ='$name'";
                          $results = mysql_query($query);
                          while($row = mysql_fetch_array($results))
                            extract($row);
                        ?>
                        <tr>
                          <td align="center"><?php echo $name ?? ''; ?></td>
                          <td align="center"><?php echo $moisture ?? ''; ?></td>
                          <td align="center"><?php echo $n ?? ''; ?></td>
                          <td align="center"><?php echo $p2o5 ?? ''; ?></td>
                          <td align="center"><?php echo $k2o ?? ''; ?></td>
                          <td align="center"><?php echo $s ?? ''; ?></td>
                          <td align="center"><?php echo $b ?? ''; ?></td>
                          <td align="center"><?php echo $zn ?? ''; ?></td>
                          <td align="center"><?php echo $pH ?? ''; ?></td>
                          <td align="center"><?php echo $total ?? ''; ?></td>
                          <?php if(isset($limitID)) { ?>
                            <td align="center"> <a target='_blank' title='Delete Limit' href='fertilizer_limit_delete.php?id=<?php echo "$limitID"; ?>' class='btn btn-danger btn-xs'>
                            <i class='fa fa-trash '></i>
                          </a></td><?php } ?>
                        </tr>
                        <?php } 
                        hmm('UPPER LIMIT', $id);
                        hmm('LOWER LIMIT', $id);
                        hmm('TARGET', $id);
                         ?>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="card card-topline-yellow">
                  <div class="card-head">
                    <header>Add Default Limit</header>
                    <div class="tools">
                      <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                      <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                      <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                    </div>
                  </div>
                  <div class="card-body "><?php include("form_fertilizer_limits.php"); ?></div>
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