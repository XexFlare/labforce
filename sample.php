<?php
include("includes/header.php");
include('includes/helpers.php');

$id = $_GET['id'];
$query  = "SELECT s.*, 
u.firstname, u.lastname, 
de.name as de_name, clr.color, c.meridian_contract,
fert.fertilizer, fert.blend, fert.formula
FROM tbl_samples AS s
LEFT JOIN tbl_colors AS clr ON clr.colorID = s.color
LEFT JOIN tbl_system_users AS u ON u.userID = s.delivered_to
LEFT JOIN tbl_sample_techs AS de ON s.taken_by = de.id
LEFT JOIN tbl_contracts AS c ON c.contractID = s.contract_id
LEFT JOIN tbl_fertilizer_types AS fert ON fert.fertilizerID = c.fertilizer_name
WHERE s.id=$id";
$results = mysql_query($query);
$current = mysql_fetch_array($results);
extract($current);
?>
<div class="page-content-wrapper">
  <div id="content" class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Sample Details</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i> <a class="parent-item" href="index.php">Home</a> <i class="fa fa-angle-right"></i>
          <li><a class="parent-item" href="">Report</a> <i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Sample Analysis</li>
        </ol>
      </div>
      <div class="container-fluid">
        <?php 
					if(isset($shortname) && $shortname != NULL)
					  $logo = "images/logos/" . strtolower($shortname) . ".png";
					else $logo = "images/logo.png";
				?>
  				<img src="<?php echo $logo; ?>" height="80">
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="white-box">
            <div class="row">
              <div class="col-md-6">
              <?php if($sample_id) { ?><h5>SAMPLE ID: <b class="text-primary">
                    <?php echo "$sample_id"; ?>
                  </b></h5><?php } ?>
                  <?php if(isset($meridian_contract)) { ?><h5>CONTRACT: <b class="text-primary">
                    <?php echo "$meridian_contract"; ?>
                  </b></h5><?php } ?>
                <h5>FERTILIZER TYPE: <b class="text-primary">
                    <?php echo "$fertilizer"; ?>
                  </b></h5>
                <h5>FORMULA: <b class="text-primary">
                    <?php echo "$formula"; ?>
                  </b></h5>
                <h5>BLEND TYPE: <b class="text-primary">
                    <?php echo "$blend"; ?>
                  </b></h5>
                <h5>DELIVERED TO: <b class="text-primary">
                  <?php echo $delivered ?? "$firstname $lastname"; ?>
                </b></h5>
              <h5>DELIVERY TIME: <b class="text-primary">
                  <?php echo date("d/m/Y", strtotime($delivery_time)); ?>
                  </b></h5>
                <?php if($vehicle_number) { ?><h5>VEHICLE NUMBER: <b class="text-primary">
                  <?php echo $vehicle_number; ?>
                  </b></h5><?php } ?>
                <?php 
                $query = mysql_query("SELECT * FROM vehicles WHERE sample_id = $id");
                $vehicles = [];
                while($vehicle = mysql_fetch_assoc($query)) {
                  $vehicles[] = $vehicle['reg_number'];
                }
                $count = count($vehicles);
                $limit = 4;
                if($vehicles != []){
                  $x = 0;
                  do{
                    if($x < $count) echo '<h5>VEHICLE NUMBER: ';
                    for ($i = $x; $i < $count && $i < $x + $limit; $i++) { 
                      echo "<b class='text-primary'>" . $vehicles[$i] . "</b>";
                      echo $i == $count - 1 || $i == $x + $limit - 1 ? "" : " | ";
                    }
                    echo '</h5>';
                    $x += $limit * 2;
                  } while($x < $count);
                }
              ?>    
              </div>
              <div class="col-md-6">
                <h5>SAMPLE No: <b class="text-primary">
                    <?php echo "$sample_number"; ?>
                  </b></h5>
                <h5>SIZE: <b class="text-primary">
                    <?php echo "$size"; ?>
                  </b></h5>
                <h5>COLOR: <b class="text-primary">
                    <?php echo "$color"; ?>
                  </b></h5>
                <h5>TAKEN BY: <b class="text-primary">
                  <?php echo "$de_name"; ?>
                  </b></h5>
                <h5>COLLECTION TIME: <b class="text-primary">
                  <?php echo date("d/m/Y H:m", strtotime($collection_time)); ?>
                  </b></h5>
                <?php if($arf_doc) { ?><h5>ARF DOCUMENT: <b class="text-primary">
                  <a href="/images/analysis/<?php echo $arf_doc; ?>" target="__blank">VIEW</a>
                  </b></h5><?php } 
                if($vehicles != []){
                  $x = $limit;
                  do{
                    if($x < $count) echo '<h5>VEHICLE NUMBER: ';
                    for ($i = $x; $i < $count && $i < $x + $limit ; $i++) { 
                      echo "<b class='text-primary'>" . $vehicles[$i] . "</b>";
                      echo $i == $count - 1 || $i == $x + $limit - 1 ? "" : " | ";
                    }
                    echo '</h5>';
                    $x += $limit * 2;
                  } while($x < $count);
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="editor"></div>

</div>
<style>
  .pill {
    font-size: 15px;
    font-weight: bold;
    padding: 5px;
    color: white;
    border-radius: 5px;
    margin-left: 10px;

  }

  .raw {
    background: #077b3a;
  }

  .blend {
    background: #007bff;
  }
</style>
<?php include("includes/footer.php"); ?>
</div>
<?php include("includes/javascript_includes.php"); ?>
</body>

</html>