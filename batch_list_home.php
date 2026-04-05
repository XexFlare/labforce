<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card card-box">
      <div class="card-body ">
        <?php if(!isset($hideNav) || $hideNav == false) { ?>
        <div class="row justify-content-between align-items-center">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a href="/index.php?type=blend&sweep=<?php echo isset($_GET['sweep']) ? $_GET['sweep'] : 'false'; ?>" class="nav-link <?php echo !isset($_GET['type']) || $_GET['type'] == 'blend' ? 'active bg-success' : 'text-success'; ?>">Blended Material</a>
            </li>
            <li class="nav-item">
              <a href="/index.php?type=raw&sweep=<?php echo isset($_GET['sweep']) ? $_GET['sweep'] : 'false'; ?>" class="nav-link <?php echo isset($_GET['type']) && $_GET['type'] == 'raw' ? 'active bg-success' : 'text-success'; ?>">Raw Material</a>
            </li>
            <li class="nav-item pull-right">
              <a href="/index.php?type=<?php echo isset($_GET['type']) ? $_GET['type'] : 'blend'; ?>&sweep=<?php echo isset($_GET['sweep']) && $_GET['sweep'] == 'true' ? 'false' : 'true'; ?>" class="nav-link <?php echo isset($_GET['sweep']) && $_GET['sweep'] == 'true' ? 'active bg-info' : 'text-info'; ?>">Sweeping</a>
            </li>
          </ul>
          <form action="" class="form-group" id="select-form">
            <div class="input-group mt-2">
              <select name="countryID" class="custom-select" id="inputGroupSelect04">
                <?php if(!isset($_GET['countryID'])){ echo '<option>Choose a country...</option>';} ?>
                
                <?php 
                  $sql = "SELECT DISTINCT tbl_analysis.countryID, tbl_countries.country FROM tbl_analysis INNER JOIN tbl_countries ON tbl_analysis.countryID = tbl_countries.countryID"; 
                  $countries = mysql_query($sql);
                  while ($row = mysql_fetch_assoc($countries)):
                ?>
                <option value = "<?=$row['countryID']?>" ><?=$row['country']?></option>
                <?php endwhile; ?>
              </select>
              <div class="input-group-append">
                <button class="btn btn-outline-success" type="submit"><i class="fa fa-filter" style="font-size:1rem;"></i>Filter</button>
              </div>
            </div>
          </form>
          <div id="highlight">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" name="highlight" id="highlight-damaged" value="damaged" class="custom-control-input" checked>
              <label class="custom-control-label" for="highlight-damaged">Highlight Damaged</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" name="highlight" id="highlight-spec" value="spec" class="custom-control-input">
              <label class="custom-control-label" for="highlight-spec">Highlight Out of Spec</label>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="table-wrap">
          <div class="table-scrollable">
            <table class="table table-hover table-checkable order-column full-width highlight-damaged" id="batches">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Fertilizer</th>
                  <th>Batch #</th>
                  <th>Contract #</th>
                  <th>Color</th>
                  <th>N</th>
                  <th>P205</th>
                  <th>K20</th>
                  <th>S</th>
                  <th>B</th>
                  <th>ZnS04</th>
                  <th>=</th>
                  <th style="display: none;"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $is_blend = !isset($_GET['type']) || $_GET['type'] == 'blend' ? 1 : 0;
                $is_sweeping = isset($_GET['sweep']) && $_GET['sweep'] == 'true' ? 1 : 0;
                $spec_query = $is_blend ? "IF(cast(a.n as float) < cast(lowr.n as float) OR cast(a.n as float) > cast(upr.n as float)
                OR cast(a.p2o5 as float) < cast(lowr.p2o5 as float) OR cast(a.p2o5 as float) > cast(upr.p2o5 as float)
                OR cast(a.k2o as float) < cast(lowr.k2o as float) OR cast(a.k2o as float) > cast(upr.k2o as float)
                OR cast(a.s as float) < cast(lowr.s as float) OR cast(a.s as float) > cast(upr.s as float)
                OR cast(a.b as float) < cast(lowr.b as float) OR cast(a.b as float) > cast(upr.b as float)
                OR cast(a.zn as float) < cast(lowr.zn as float) OR cast(a.zn as float) > cast(upr.zn as float), 
                1, 0) AS spec," 
                : "IF(cast(a.n as float) < cast(lowr.n as float)
                OR cast(a.p2o5 as float) < cast(lowr.p2o5 as float)
                OR cast(a.k2o as float) < cast(lowr.k2o as float)
                OR cast(a.s as float) < cast(lowr.s as float)
                OR cast(a.b as float) < cast(lowr.b as float)
                OR cast(a.zn as float) < cast(lowr.zn as float),
                1, 0) AS spec,";
                $query  = "SELECT DISTINCT
                  IF(a.exec_comments IS NOT NULL AND a.exec_comments <> '', 1, 0) AS damaged,
                    $spec_query
                    a.*, tbl_fertilizer_types.fertilizer, tbl_batches.batchNum, tbl_batches.contractID, tbl_batches.size,
                    tbl_system_users.firstname, tbl_system_users.lastname,s.id,
                    c.meridian_contract, tbl_colors.color, sc.color as sample_color FROM tbl_analysis  as a
                    LEFT JOIN tbl_batches ON tbl_batches.batchID = a.batchID 
                    LEFT JOIN tbl_samples as s ON s.id = tbl_batches.sample_id
                    LEFT JOIN tbl_system_users ON tbl_system_users.userID = a.doneBy
                    LEFT JOIN tbl_contracts as c ON tbl_batches.contractID = c.contractID 
                    LEFT JOIN tbl_colors ON tbl_batches.color = tbl_colors.colorID
                    LEFT JOIN tbl_colors as sc ON s.color = sc.colorID
                    LEFT JOIN tbl_fertilizer_types ON tbl_fertilizer_types.fertilizerID = c.fertilizer_name
                    LEFT JOIN tbl_fertilizer_limits as lowr ON (lowr.item = 'LOWER LIMIT' and lowr.fertilizerID = c.fertilizer_name)
                    LEFT JOIN tbl_fertilizer_limits as upr ON (upr.item = 'UPPER LIMIT' and upr.fertilizerID = c.fertilizer_name)";
                if ($myLevel == 1)
                  $condition = "WHERE c.is_blend = $is_blend 
                  AND c.is_sweeping = $is_sweeping ";
                else if ($myLevel == 2)
                  $condition  = "WHERE c.is_blend = $is_blend  
                  AND c.is_sweeping = $is_sweeping
                  AND tbl_system_users.country = $myCountry";
                else
                  $condition  = "WHERE c.is_blend = $is_blend
                  AND c.is_sweeping = $is_sweeping
                  AND tbl_system_users.country = $myCountry ";
                if (isset($damage) && $damage == true)
                  $condition  = "WHERE a.exec_comments IS NOT NULL AND a.exec_comments <> '' AND a.exec_action IS NULL";
                if (isset($executive) && $executive == true && $myLevel == 1)
                  $condition  = "WHERE c.fertilizer_name = '49' ";
                if (isset($executive) && $executive == true && $myLevel == 2)
                  $condition  = "WHERE c.fertilizer_name = '49'
                  AND a.countryID = $myCountry ";
                if(isset($_GET['countryID']))
                  $condition .= " AND a.countryID ='".$_GET['countryID']."' ";
                $condition .= " OR a.item = 'Visual Inspection' ";
                $order = 'ORDER BY time DESC';
                $results = mysql_query($query . " " . $condition . " " . $order);
                $i = 1;

                while ($row = mysql_fetch_assoc($results)) {
                  extract($row);
                  $isVisual = isset($item) && $item == 'Visual Inspection';
                ?>
                  <tr class="<?php
                              echo $isVisual ? 'list-visual ' : '';
                              echo $spec ? 'list-spec ' : '';
                              echo $damaged ? 'list-damaged ' : '';
                              ?>">
                    <td>
                      <font color='#CC6600'><?php echo $i++; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo date("d/m/Y", strtotime($time)); ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $fertilizer . "<br/>";
                        echo $isVisual ? '<span class="pill blend">Visual</span>' : '';
                        echo $spec ? '<span class="pill bg-warning">Out of Spec</span>' : '';
                        echo $damaged ? '<span class="pill bg-danger">Damaged</span>' : '';
                      ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $batchNum; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $meridian_contract; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $color ?? $sample_color; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $n; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $p2o5; ?> </font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $k2o; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $s; ?></font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $b; ?> </font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#ff9933" : "#007bff"); ?>'><?php echo $zn; ?> </font>
                    </td>
                    <td>
                      <font color='<?php echo ($is_blend ? "#149347" : "#afa308"); ?>'><?php echo $total; ?> </font>
                    </td>
                    <td style="display:none;">
                      <?php echo $analysisID; ?>
                    </td>
                  </tr>
                <?php
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
<style>
  .pill {
    font-size: 15px;
    font-weight: bold;
    padding: 5px;
    color: white;
    border-radius: 5px;
    margin-left: 10px;
    background: #077b3a;

  }

  .list-visual {
    background-color: #edf5f7;
  }

  .highlight-spec .list-spec {
    background-color: #ffa50030;
  }
  .highlight-damaged .list-damaged {
    background-color: #ff00001f;
  }
</style>