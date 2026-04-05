<div class="row">
  <div class="col-md-6">
    <h5>FERTILIZER TYPE: <b class="text-primary">
        <?php echo "$fertilizer"; ?>
      </b></h5>
    <h5>FORMULA: <b class="text-primary">
        <?php echo "$formula"; ?>
      </b></h5>
    <h5>CONTRACT: <b class="text-primary">
        <?php echo "$meridian_contract"; ?>
      </b></h5>
    <h5>VESSEL NAME: <b class="text-primary">
        <?php echo "$vessel"; ?>
      </b></h5>
    <h5>SUPPLIER: <b class="text-primary">
        <?php echo "$supplier"; ?>
      </b></h5>
    <h5>COUNTRY OF ORIGIN: <b class="text-primary">
        <?php echo "$country"; ?>
      </b></h5>
    <h5>COMPANY: <b class="text-primary">
        <?php echo $unit_name; ?>
      </b></h5>
    <?php if($is_blend && isset($acc_reference)) { ?>
      <h5>ACCPAC REFERENCE: <b class="text-primary">
        <?php echo $acc_reference; ?>
      </b></h5>
      <?php } ?>
    <?php if(isset($truck_number)) { ?>
      <h5>TRUCK NUMBER: <b class="text-primary">
        <?php echo $truck_number; ?>
      </b></h5>
      <?php } ?>
    <?php if(isset($vehicle_number) && $vehicle_number != '') { ?>
      <h5>VEHICLE NUMBER: <b class="text-primary">
        <?php echo $vehicle_number; ?>
      </b></h5>
      <?php }
        
        $vehicles = [];
        if($sample_id != null){
          $query = mysql_query("SELECT * FROM vehicles WHERE sample_id = $sample_id");
          while($vehicle = mysql_fetch_assoc($query)) {
            $vehicles[] = $vehicle['reg_number'];
          }
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
    <h5>BLEND TYPE: <b class="text-primary">
        <?php echo "$blend"; ?>
      </b></h5>
    <h5>LAB BATCH No: <b class="text-primary">
        <?php echo "$batchNum"; ?>
      </b></h5>
    <?php 
    // if(isset($blendBatchNum)) { ?>
    <h5>BLEND BATCH No: <b class="text-primary">
        <?php echo "$blendBatchNum"; ?>
      </b></h5>
    <?php
  //  } ?>
    <h5>SIZE: <b class="text-primary">
        <?php echo $size ?? $sample_size; ?>
      </b></h5>
    <h5>COLOR: <b class="text-primary">
        <?php echo $batch_color ?? $sample_color; ?>
      </b></h5>
    <h5>DONE BY: <b class="text-primary">
        <?php echo "$firstname $lastname"; ?>
      </b></h5>
    <?php if (isset($approved_by)) { ?>
      <h5><?php echo $approval_response ? "APPROVED BY" : "REJECTED BY"; ?>:
        <b class="text-primary"><?php echo "$ap_fname $ap_lname"; ?></b>
      </h5>
    <?php } 
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