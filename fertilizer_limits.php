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
                      <?php
                      $query = "SELECT * FROM tbl_fertilizer_limits WHERE fertilizerID='$id' && item ='UPPER LIMIT'";
                      $results = mysql_query($query);
                      while ($row = mysql_fetch_array($results)) {
                        $limitID1 = $row["limitID"];
                        $moisture1 = $row["moisture"];
                        $n1 = $row["n"];
                        $p2o51 = $row["p2o5"];
                        $k2o1 = $row["k2o"];
                        $s1 = $row["s"];
                        $b1 = $row["b"];
                        $zn1 = $row["zn"];
                        $total1 = $row["total"];
                      }
                      $query2 = "SELECT * FROM tbl_fertilizer_limits WHERE fertilizerID='$id' && item ='LOWER LIMIT'";
                      $results2 = mysql_query($query2);
                      while ($row = mysql_fetch_array($results2)) {
                        $limitID2 = $row["limitID"];
                        $moisture2 = $row["moisture"];
                        $n2 = $row["n"];
                        $p2o52 = $row["p2o5"];
                        $k2o2 = $row["k2o"];
                        $s2 = $row["s"];
                        $b2 = $row["b"];
                        $zn2 = $row["zn"];
                        $total2 = $row["total"];
                      }
                      $query3 = "SELECT * FROM tbl_fertilizer_limits WHERE fertilizerID='$id' && item ='TARGET'";
                      $results3 = mysql_query($query3);
                      while ($row = mysql_fetch_array($results3)) {
                        $limitID3 = $row["limitID"];
                        $moisture3 = $row["moisture"];
                        $n3 = $row["n"];
                        $p2o53 = $row["p2o5"];
                        $k2o3 = $row["k2o"];
                        $s3 = $row["s"];
                        $b3 = $row["b"];
                        $zn3 = $row["zn"];
                        $total3 = $row["total"];
                      }
                      ?>
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
                            <font color="#006666">TOTAL</font>
                          </td>
                        </tr>
                        <tr>
                          <td align="center">UPPER LIMIT</td>
                          <td align="center"><?php echo "$moisture1"; ?></td>
                          <td align="center"><?php echo "$n1"; ?></td>
                          <td align="center"><?php echo "$p2o51"; ?></td>
                          <td align="center"><?php echo "$k2o1"; ?></td>
                          <td align="center"><?php echo "$s1"; ?></td>
                          <td align="center"><?php echo "$b1"; ?></td>
                          <td align="center"><?php echo "$zn1"; ?></td>
                          <td align="center"><?php echo "$total1"; ?></td>
                        </tr>
                        <tr>
                          <td align="center">LOWER LIMIT</td>
                          <td align="center"><?php echo "$moisture2"; ?></td>
                          <td align="center"><?php echo "$n2"; ?></td>
                          <td align="center"><?php echo "$p2o52"; ?></td>
                          <td align="center"><?php echo "$k2o2"; ?></td>
                          <td align="center"><?php echo "$s2"; ?></td>
                          <td align="center"><?php echo "$b2"; ?></td>
                          <td align="center"><?php echo "$zn2"; ?></td>
                          <td align="center"><?php echo "$total2"; ?></td>
                        </tr>
                        <tr>
                          <td align="center">TARGET</td>
                          <td align="center"><?php echo "$moisture3"; ?></td>
                          <td align="center"><?php echo "$n3"; ?></td>
                          <td align="center"><?php echo "$p2o53"; ?></td>
                          <td align="center"><?php echo "$k2o3"; ?></td>
                          <td align="center"><?php echo "$s3"; ?></td>
                          <td align="center"><?php echo "$b3"; ?></td>
                          <td align="center"><?php echo "$zn3"; ?></td>
                          <td align="center"><?php echo "$total3"; ?></td>
                        </tr>
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
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>