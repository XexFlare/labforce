<?php
if($full) {

  $query = "SELECT tbl_seive_analysis.*, tbl_colors.color FROM tbl_seive_analysis left JOIN tbl_colors ON tbl_colors.colorID = tbl_seive_analysis.color WHERE test_id=$testID";
  $results = mysql_query($query);
  $seive = mysql_fetch_array($results);
  $damage = mysql_fetch_array(mysql_query("SELECT * FROM damage_analysis WHERE test_id=$testID"));
  
  $query = "SELECT * FROM tbl_physical_analysis WHERE test_id=$testID";
  $results = mysql_query($query);
  while ($physical = mysql_fetch_array($results))
  extract($physical);
  $query1 = "SELECT * FROM physical_analysis WHERE test_id=$testID OR batch_id=$batchID";
  $results21 = mysql_query($query1);
  $physicals = mysql_fetch_array($results21);
}
$target = getFertilizerLimits($fertilizer_name, FertLimit::TARGET);

$query  = "SELECT * FROM tbl_manufacturer_results where contract_id=$contractID";
$results = mysql_query($query);
$manufacturer = mysql_fetch_array($results);
$props = ['moisture', 'n', 'p2o5', 'k2o', 's', 'b', 'zn', 'pH', 'total'];

$results5 = mysql_query("SELECT * FROM visual_inspections where test_id='$testID'");
$isVisual = false;
while ($row = mysql_fetch_array($results5)) {
  extract($row);
  $isVisual = true;
}

if ($isVisual) { ?>
  <h4>Visual Inspection</h4>
  <table border="1" width="100%" class="mb-4">
    <tr>
      <td colspan="2">
        <h4>External Inspection of Raw Material</h4>
      </td>
    </tr>
    <tr>
      <td>Sampled lot was uniform</td>
      <td><b><?php echo $uniform; ?></b></td>
    </tr>
    <tr>
      <td colspan="2">
        <h5>Based on the following reasons</h5>
      </td>
    </tr>
    <tr>
      <td>The color of the raw material was:</td>
      <td><b><?php echo $uniform_color ? "Uniform" : "Not Uniform"; ?></b></td>
    </tr>
    <tr>
      <td>The particle size distribution of the raw material was:</td>
      <td><b><?php echo $uniform_size_distribution ? "Uniform" : "Not Uniform"; ?></b></td>
    </tr>
    <tr>
      <td>The packaging/transport vehicle was:</td>
      <td><b><?php echo $clean_package ? "Clean" : "Not Clean"; ?></b></td>
    </tr>
    <tr>
      <td>The sealing of the packaging/transport vehicle was:</td>
      <td><b><?php echo $uniform_seal ? "Uniform" : "Not Uniform"; ?></b></td>
    </tr>
    <tr>
      <td colspan="2">
        <h4>Deterioration or Damage to the Raw Material</h4>
      </td>
    </tr>
    <tr>
      <td>The raw material appeared to be undamaged:</td>
      <td><b><?php echo $damaged ? "No" : "Yes"; ?></b></td>
    </tr>
    <tr>
      <td>The deteriorated part was:</td>
      <td><b><?php echo $separated ? "Sampled Separately" : "Not Sampled Separately"; ?></b></td>
    </tr>
    <tr>
      <td>The raw material appeared to be deteriorated/damaged by:</td>
      <td><b><?php echo $damaged_by == "Other (Specify)" ? "Other: ".$damaged_by_other : $damaged_by; ?></b></td>
    </tr>
    <tr>
      <td>The deteriorated part of the lot included: (percent of the total lot, mass, number of transport vehicles, etc.):</td>
      <td><b><?php echo $included; ?></b></td>
    </tr>
  </table>
  <?php } 
  $has = has(eod($props), eod($current), eod($lowerLimit), eod($upperLimit), eod($target), eod($manufacturer));
?>
<table border="1" width="100%" id="table1">
  <tr class="th">
    <td align="center">
      ITEM
    </td>
    <?php if ($has['moisture']) { ?><td align="center">MOISTURE</td><?php } ?>
    <?php if ($has['n']) { ?><td align="center">N</td><?php } ?>
    <?php if ($has['p2o5']) { ?><td align="center">P<font size="1">2</font>O<font size="1">5</font>
      </td><?php } ?>
    <?php if ($has['k2o']) { ?><td align="center">K<font size="1">2</font>O</td><?php } ?>
    <?php if ($has['s']) { ?><td align="center">S</td><?php } ?>
    <?php if ($has['b']) { ?><td align="center">B</td><?php } ?>
    <?php if ($has['zn']) { ?><td align="center">ZnS04</td><?php } ?>
    <?php if ($has['pH']) { ?><td align="center">pH</td><?php } ?>
    <?php if ($has['total']) { ?><td align="center">TOTAL</td><?php } ?>
  </tr>
  <?php if (is_array($target)) { ?>
    <tr>
      <td align="left">TARGET</td>
      <?php if ($has['moisture']) { ?><td align="center"><?php echo $target['moisture']; ?></td><?php } ?>
      <?php if ($has['n']) { ?><td align="center"><?php echo $target['n']; ?></td><?php } ?>
      <?php if ($has['p2o5']) { ?><td align="center"><?php echo $target['p2o5']; ?></td><?php } ?>
      <?php if ($has['k2o']) { ?><td align="center"><?php echo $target['k2o']; ?></td><?php } ?>
      <?php if ($has['s']) { ?><td align="center"><?php echo $target['s']; ?></td><?php } ?>
      <?php if ($has['b']) { ?><td align="center"><?php echo $target['b']; ?></td><?php } ?>
      <?php if ($has['zn']) { ?><td align="center"><?php echo $target['zn']; ?></td><?php } ?>
      <?php if ($has['pH']) { ?><td align="center"><?php echo $target['pH']; ?></td><?php } ?>
      <?php if ($has['total']) { ?><td align="center"><?php echo $target['total']; ?></td><?php } ?>
    </tr>
  <?php }
  if (is_array($upperLimit)) { ?>
    <tr>
      <td align="left">MAXIMUM</td>
      <?php if ($has['moisture']) { ?><td align="center"><?php echo $upperLimit['moisture']; ?></td><?php } ?>
      <?php if ($has['n']) { ?><td align="center"><?php echo $upperLimit['n']; ?></td><?php } ?>
      <?php if ($has['p2o5']) { ?><td align="center"><?php echo $upperLimit['p2o5']; ?></td><?php } ?>
      <?php if ($has['k2o']) { ?><td align="center"><?php echo $upperLimit['k2o']; ?></td><?php } ?>
      <?php if ($has['s']) { ?><td align="center"><?php echo $upperLimit['s']; ?></td><?php } ?>
      <?php if ($has['b']) { ?><td align="center"><?php echo $upperLimit['b']; ?></td><?php } ?>
      <?php if ($has['zn']) { ?><td align="center"><?php echo $upperLimit['zn']; ?></td><?php } ?>
      <?php if ($has['pH']) { ?><td align="center"><?php echo $upperLimit['pH']; ?></td><?php } ?>
      <?php if ($has['total']) { ?><td align="center"><?php echo $upperLimit['total']; ?></td><?php } ?>
    </tr><?php }
        if (is_array($lowerLimit)) { ?>
    <tr>
      <td align="left">MINIMUM</td>
      <?php if ($has['moisture']) { ?><td align="center"><?php echo isset($lowerLimit) ? $lowerLimit['moisture'] : '';  ?></td><?php } ?>
      <?php if ($has['n']) { ?><td align="center"><?php echo $lowerLimit['n']; ?></td><?php } ?>
      <?php if ($has['p2o5']) { ?><td align="center"><?php echo $lowerLimit['p2o5']; ?></td><?php } ?>
      <?php if ($has['k2o']) { ?><td align="center"><?php echo $lowerLimit['k2o']; ?></td><?php } ?>
      <?php if ($has['s']) { ?><td align="center"><?php echo $lowerLimit['s']; ?></td><?php } ?>
      <?php if ($has['b']) { ?><td align="center"><?php echo $lowerLimit['b']; ?></td><?php } ?>
      <?php if ($has['zn']) { ?><td align="center"><?php echo $lowerLimit['zn']; ?></td><?php } ?>
      <?php if ($has['pH']) { ?><td align="center"><?php echo $lowerLimit['pH']; ?></td><?php } ?>
      <?php if ($has['total']) { ?><td align="center"><?php echo $lowerLimit['total']; ?></td><?php } ?>
    </tr>
  <?php }
        if (!$is_blend && is_array($manufacturer)) { ?>
    <tr>
      <td align="left">MANUFACTURE RESULTS</td>
      <?php if ($has['moisture']) { ?>
        <td align="center" class="text-info"><b>
            <?php echo $manufacturer['moisture']; ?>
          </b></td>
      <?php } ?>
      <?php if ($has['n']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['n']; ?>
          </b></td><?php } ?>
      <?php if ($has['p2o5']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['p2o5']; ?>
          </b></td><?php } ?>
      <?php if ($has['k2o']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['k2o']; ?>
          </b></td><?php } ?>
      <?php if ($has['s']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['s']; ?>
          </b></td><?php } ?>
      <?php if ($has['b']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['b']; ?>
          </b></td><?php } ?>
      <?php if ($has['zn']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['zn']; ?>
          </b></td><?php } ?>
      <?php if ($has['pH']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['pH']; ?>
          </b></td><?php } ?>
      <?php if ($has['total']) { ?><td align="center" class="text-info"><b>
            <?php echo $manufacturer['total']; ?>
          </b></td><?php } ?>
    </tr><?php } ?>
  <tr>
    <td align="left">LAB RESULTS</td>
    <?php if ($has['moisture']) { ?><td align="center" class='<?php echo array_search('moisture', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('moisture', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['moisture']; ?>
        </b></td><?php } ?>
    <?php if ($has['n']) { ?><td align="center" class='<?php echo array_search('n', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('n', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['n']; ?>
        </b></td><?php } ?>
    <?php if ($has['p2o5']) { ?><td align="center" class='<?php echo array_search('p2o5', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('p2o5', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['p2o5']; ?>
        </b></td><?php } ?>
    <?php if ($has['k2o']) { ?><td align="center" class='<?php echo array_search('k2o', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('k2o', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['k2o']; ?>
        </b></td><?php } ?>
    <?php if ($has['s']) { ?><td align="center" class='<?php echo array_search('s', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('s', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['s']; ?>
        </b></td><?php } ?>
    <?php if ($has['b']) { ?><td align="center" class='<?php echo array_search('b', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('b', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['b']; ?>
        </b></td><?php } ?>
    <?php if ($has['zn']) { ?><td align="center" class='<?php echo array_search('zn', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('zn', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['zn']; ?>
        </b></td><?php } ?>
    <?php if ($has['pH']) { ?><td align="center" class='<?php echo array_search('pH', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('pH', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['pH']; ?>
        </b></td><?php } ?>
    <?php if ($has['total']) { ?><td align="center" class='<?php echo array_search('total', $specs['danger'] ?? []) !== false ? "text-warning spec" : (array_search('total', $specs['warn'] ?? []) !== false ? "text-white bg-warning" : "text-primary lab"); ?>'><b>
          <?php echo $current['total']; ?>
        </b></td><?php } ?>
  </tr>
</table>
<?php if ($full && isset($granule_size)) { ?>
  <h4>Physical Analysis</h4>
  <table border="1" width="100%" id="table1">
    <tr>
      <th colspan="3">Shear Strength</th>
      <th>Granule Size %</th>
      <th>Fines %</th>
      <th>Coating</th>
    </tr>
    <tr>
      <td>1st Test</td>
      <td>2nd Test</td>
      <td>3rd Test</td>
      <td rowspan="3"><?php echo $granule_size; ?></td>
      <td rowspan="3"><?php echo $fines; ?></td>
      <td rowspan="3"><?php echo $coating ? "Yes" : "No"; ?></td>
    </tr>
    <tr>
      <td><?php echo $first; ?></td>
      <td><?php echo $second; ?></td>
      <td><?php echo $third; ?></td>
    </tr>
    <tr>
      <td colspan="3"><b>Average: <?php echo round(($first + $second + $third) / 3, 2); ?></b></td>
    </tr>
  </table>
<?php }

if ($full && isset($seive['mean_particle_size'])) { ?>
  <br>
  <table border="1" width="100%" class="granulation">
    <tr>
      <th colspan="5">Granulation of Raw Material</th>
    </tr>
    <tr>
      <th>Item</th>
      <th>Dimension</th>
      <th>Target</th>
      <th>Tolerance</th>
      <th>Actual</th>
    </tr>
    <tr>
      <td>Mean Particle Size</td>
      <td>d50 (mm)</td>
      <td>3.25</td>
      <td>0.25</td>
      <td><?php echo $seive['mean_particle_size']; ?></td>
    </tr>
    <tr>
      <td>Fine Particles</td>
      <td>
        <1mm(% mass)</td>
      <td>0</td>
      <td>0.25</td>
      <td><?php echo $seive['fine_particles']; ?></td>
    </tr>
    <tr>
      <td>Coarse Particles</td>
      <td>>5mm (% mass)</td>
      <td>0</td>
      <td>1</td>
      <td><?php echo $seive['coarse_particles']; ?></td>
    </tr>
    <tr>
      <td>Mean Range</td>
      <td>2.5-4.0 mm (% mass)</td>
      <td>90</td>
      <td>5</td>
      <td><?php echo $seive['mean_range']; ?></td>
    </tr>
    <tr>
      <td>Granulation Spread Index(GSI)</td>
      <td id="gsi">
        <i id="formula">GSI =
          <div style="display: inline-block; padding: 0 5px;">
            <div>
              d<sub>85</sub> - d<sub>16</sub>
            </div>
            <hr class="hr" />
            <div>
              2 d<sub>50</sub>
            </div>
          </div>
          x 100
        </i>
      </td>
      <td>&lt;18</td>
      <td>na</td>
      <td><?php echo $seive['gsi']; ?></td>
    </tr>
  </table>
  <br />
  <table border="1" width="100%" class="granulation">
    <tr>
      <th colspan="3">Other Physical Properties</th>
    </tr>
    <tr>
      <th>Item</th>
      <th>Description</th>
      <th>Additional Comments</th>
    </tr>
    <tr>
      <td>Color</td>
      <td><?php echo $seive['color']; ?></td>
    </tr>
    <tr>
      <td>Dust Free</td>
      <td><?php echo $seive['dust_free'] ? "Yes" : "No"; ?></td>
    </tr>
    <tr>
      <td>Free Flowing</td>
      <td><?php echo $seive['free_flowing'] ? "Yes" : "No"; ?></td>
    </tr>
  </table>
  <?php } if (isset($physicals['mean_particle_size'])) {
    echo "<br/ >";
    physicalAnalysis($physicals, $sample_size);
  } if ($full && isset($damage['color_diff'])) { ?>
  <table border="1" width="100%" class="mt-4 granulation">
    <tr class="th">
      <th>Item</th>
      <th>Value (%)</th>
    </tr>
    <tr>
      <td>Color Difference %</td>
      <td><?php echo $damage['color_diff']; ?></td>
    </tr>
    <tr>
      <td>Granular Size %</td>
      <td><?php echo $damage['granular_size']; ?></td>
    </tr>
    <tr>
      <td>Identifiable Different Fertilizer Granules %</td>
      <td><?php echo $damage['idf_granules']; ?></td>
    </tr>
    <tr>
      <td>Foreign Matter %</td>
      <td><?php echo $damage['foreign_matter']; ?></td>
    </tr>
    <tr>
      <td>Lump %</td>
      <td><?php echo $damage['lump_percentage']; ?></td>
    </tr>
  </table>
  <?php } ?>
  <style>
    #formula {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #gsi {
      font-family: math;
    }

    .granulation td,
    .granulation th {
      text-align: center;
    }

    .hr {
      margin: 0;
      border-top: 1px solid #000;
    }
  </style>