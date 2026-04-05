  <?php
  $q = mysql_query("SELECT testID from tbl_tests where batchID=$batch ORDER BY testID ASC");
  $letter = 'A';
  while ($data = mysql_fetch_assoc($q)) {
    if ($test == $data['testID']) $selected = $letter;
    if ($data['testID'] == $testID) break;
    $letter++;
  }
  ?>
  <div class='panel panel-default'>
    <div class='panel-heading panel-heading-gray'>
      <h4 class='panel-title d-flex justify-content-between'>
        <div>
          <a class='accordion-toggle accordion-toggle-styled collapsed' data-toggle='collapse' data-parent='#accordion3' title="CLICK TO VIEW TEST DETAILS" href='#<?php echo $letter; ?>'>Test: <?php echo $letter; ?></a>
          <a title="DELETE THIS TEST" href="test_delete.php?id=<?php echo "$testID"; ?>">
            <font color="#FF0000">
              <i class="fa fa-trash-o"></i>
            </font>
          </a>
        </div>
        <a href="analysis_add.php?id=<?php echo "$batch&test=$testID&type=chemical"; ?>">
          Chemical Analysis
        </a>
        <a href="analysis_add.php?id=<?php echo "$batch&test=$testID&type=visual"; ?>">
          Visual Analysis
        </a>
        <a href="analysis_add.php?id=<?php echo "$batch&test=$testID&type=damage"; ?>">
          Damage Analysis
        </a>
        <div class="dropdown">
          <div class="dropdown-toggle" id="addComment" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Add Comment
          </div>
          <div class="dropdown-menu" aria-labelledby="addComment">
            <a class="dropdown-item" href="analysis_add.php?id=<?php echo "$batch&test=$testID&type=lab_comment"; ?>">
              Add Lab Comment
            </a>
            <?php if ($myLevel == 1) { ?>
              <a class="dropdown-item" href="analysis_add.php?id=<?php echo "$batch&test=$testID&type=comment"; ?>">
                Add QA Comment
              </a>
            <?php } ?>
          </div>
        </div>
      </h4>
    </div>
    <div id='<?php echo $letter; ?>' class='panel-collapse collapse'>
      <div class='panel-body' style='height:260px; overflow-y:auto;'>
        <?php include("fertilizer_limits_guide.php"); ?>
      </div>
    </div>
  </div>