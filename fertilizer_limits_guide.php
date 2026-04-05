<?php
include_once('includes/helpers.php');
$query1 = "SELECT tbl_seive_analysis.*, tbl_colors.color FROM tbl_seive_analysis left JOIN tbl_colors ON tbl_colors.colorID = tbl_seive_analysis.color WHERE test_id=$testID";
$results21 = mysql_query($query1);
$seive = mysql_fetch_array($results21);
$damage = mysql_fetch_array(mysql_query("SELECT * FROM damage_analysis WHERE test_id=$testID"));
$query1 = "SELECT * FROM tbl_physical_analysis WHERE test_id=$testID";
$results21 = mysql_query($query1);
while ($physical = mysql_fetch_array($results21))
  extract($physical);
$query1 = "SELECT * FROM physical_analysis WHERE test_id=$testID";
$results21 = mysql_query($query1);
$physicals = mysql_fetch_array($results21);

$query4  = "SELECT * FROM tbl_analysis where testID='$testID' && item='MANUFACTURE RESULTS'";
$results4 = mysql_query($query4);
$row = mysql_fetch_array($results4);
  $analysisID4 = $row["analysisID"] ?? '';
  $moisture4 = $row["moisture"] ?? '';
  $n4 = $row["n"] ?? '';
  $p2o54 = $row["p2o5"] ?? '';
  $k2o4 = $row["k2o"] ?? '';
  $s4 = $row["s"] ?? '';
  $b4 = $row["b"] ?? '';
  $zn4 = $row["zn"] ?? '';
  $ph4 = $row["pH"] ?? '';
  $total4 = $row["total"] ?? '';


$query5  = "SELECT a.*, u.firstname, u.lastname FROM tbl_analysis as a
left join tbl_system_users as u ON u.userID = qa_comments_by
 where testID='$testID' && item = 'LAB RESULTS'";
$results5 = mysql_query($query5);
$row = mysql_fetch_array($results5);
  $analysisID5 = $row["analysisID"] ?? '';
  $moisture5 = $row["moisture"] ?? '';
  $n5 = $row["n"] ?? '';
  $p2o55 = $row["p2o5"] ?? '';
  $k2o5 = $row["k2o"] ?? '';
  $s5 = $row["s"] ?? '';
  $b5 = $row["b"] ?? '';
  $zn5 = $row["zn"] ?? '';
  $ph5 = $row["pH"] ?? '';
  $total5 = $row["total"] ?? '';
  $comments = $row["exec_comments"] ?? '';
  $execremarks = $row["exec_remarks"] ?? '';
  $qa = isset($row["firstname"]) ? $row["firstname"]  . " " .$row['lastname'] : '';
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
<?php } ?>
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
      <font color="#006666">ZnSO4</font>
    </td>
    <td bgcolor="#C0C0C0" align="center">
      <font color="#006666">pH</font>
    </td>
    <td bgcolor="#C0C0C0" align="center">
      <font color="#006666">TOTAL</font>
    </td>
    <td bgcolor="#C0C0C0" align="center">
      <font color="#006666"><i class="fa fa-cog"></i></font>
    </td>
  </tr>
<?php 
  printLimit('UPPER LIMIT', $fertilizerType); 
  printLimit('LOWER LIMIT', $fertilizerType); 
  printLimit('TARGET', $fertilizerType); 
  ?>
  <?php if(isset($moisture4)) { ?>
  <tr>
    <td align="left">MANUFACTURE RESULTS</td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$moisture4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$n4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$p2o54"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$k2o4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$s4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$b4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$zn4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$ph4"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$total4"; ?></font>
      </b></td>
    <td align="center"> <a target='_blank' title='Delete Sample' href='sample_delete.php?id=<?php echo "$analysisID4"; ?>' class='btn btn-danger btn-xs'>
        <i class='fa fa-trash '></i>
      </a></td>
  </tr>
<?php } ?>

  <tr>
    <td align="left">LAB RESULTS</td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$moisture5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$n5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$p2o55"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$k2o5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$s5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$b5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$zn5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$ph5"; ?></font>
      </b></td>
    <td align="center"><b>
        <font color="#FF6600"><?php echo "$total5"; ?></font>
      </b></td>
    <td align="center"> <a target='_blank' title='Delete Sample' href='sample_delete.php?id=<?php echo "$analysisID5"; ?>' class='btn btn-danger btn-xs'>
        <i class='fa fa-trash '></i>
      </a></td>
  </tr>



</table>
<?php if (isset($execremarks)) { ?>
  <p>
    <b>QA Remarks: <?php echo $execremarks; ?></b>
  </p>
<?php }
if (isset($comments)) { ?>
  <p>
    <b>QA Comments: <?php echo $comments; ?></b>
  </p>
<?php }
if (isset($qa)) { ?>
  <p>
    <b>QA: <?php echo $qa; ?></b>
  </p>
<?php }
if (isset($granule_size)) { ?>
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
if (isset($seive['mean_particle_size'])) { ?>
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
    physicalAnalysis($physicals, $size);
  } if (isset($damage['color_diff'])) { ?>
  <table border="1" width="100%" class="granulation">
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
