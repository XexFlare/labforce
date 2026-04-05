<?php

abstract class FertLimit
{
    const LOWER = 'LOWER LIMIT';
    const UPPER = 'UPPER LIMIT';
    const TARGET = 'TARGET';
}

function getFertilizerLimits($id, $limit)
{
    $query = "SELECT * FROM tbl_fertilizer_limits WHERE fertilizerID='$id' && item ='$limit'";
    $results = mysql_query($query);
    return mysql_fetch_array($results);
}

function compare($current, $limit, $bounds)
{
    $props = [];
    foreach (['moisture', 'n', 'p2o5', 'k2o', 's', 'b', 'zn', 'pH', 'total'] as $key) {
        if(checkSpec($current[$key], $limit[$key], $bounds))
            array_push($props, $key);
    }
    return $props;
}

function checkSpec($current, $limit, $bounds)
{
    if($limit == null || trim($limit) == '') return false;
    return $bounds == FertLimit::LOWER ? $limit > $current : $limit < $current ;
}

function compareLimits($current, $lower, $upper, $is_blend)
{
    $lowerComparison = is_array($lower) ? compare($current, $lower, FertLimit::LOWER) : [];

    $upperComparison = is_array($upper) ? compare($current, $upper, FertLimit::UPPER) : [];
    if($is_blend)
        return count($upperComparison) > 0 || count($lowerComparison) > 0
            ? ['result' => false, 'danger' => [...$upperComparison, ...$lowerComparison]]
            : ['result' => true];
    return count($upperComparison) > 0 || count($lowerComparison) > 0
        ? ['result' => false, 'warn' => $upperComparison, 'danger' => $lowerComparison]
        : ['result' => true];
}

function sendWarningEmail($id, $fertilizer, $contract, $comments, $results, $upperLimit, $lowerLimit, $images)
{
    $server = getenv('APP_URL');
    $link = "$server/analysis_report.php?id=$id";
    require_once("PHPMailer/Mail.php");
    $comments = strtoupper($comments);
    $rcpt = getReceipients('REPORTS', 2);
    if ($rcpt['to'] == null) return;
    $upperLimit = is_array($upperLimit) ? $upperLimit : [];
    $lowerLimit = is_array($lowerLimit) ? $lowerLimit : [];
    $titles = ['title'=>'','moisture' => 'Moisture','n' => 'N','p2o5' => 'P','k2o' => 'K','s' => 'S','b' => 'B','zn' => 'Zn','total' => 'Total'];
    $upperLimit = ['title'=>'Upper Limit', ...$upperLimit ];
    $lowerLimit = ['title'=>'Lower Limit', ...$lowerLimit ];
    $results = ['title'=>'Results', ...$results ];
    $table = StringTools::toAsciiTable([ $titles,$upperLimit, $lowerLimit, $results], ['title','moisture','n','p2o5','k2o','s','b','zn','total'], 50);
    $body = "Hello {$rcpt['to']['name']},
    
Please review the results of the following $fertilizer test from $contract 
which has returned $comments results.

Results
$table

Click the following link or paste it in you browser
$link

Regards,
LabForce Team";
  send_email(new Recepient($rcpt['to']['email'], $rcpt['to']['name']), "LabForce Test Results ($fertilizer - $contract: [$comments])", $body, $rcpt['cc'],'', $images);
}

function sendExecActionEmail($id, $to, $exec, $action, $fertilizer, $contract)
{
    $server = getenv('APP_URL');
    $link = "$server/analysis_report.php?id=$id";
    $rcpt = getReceipients('EXEC_ACTION');
    if ($rcpt['to'] == null) return;
    require_once("PHPMailer/Mail.php");
    $body = "Hello {$to['name']},

The results of the following $fertilizer test from $contract 
require the following action: $action
Requested by $exec.

Click the following link or paste it in you browser to view the details.
$link

Regards,
LabForce Team";
    send_email(new Recepient($to['email'], $to['name']), "LabForce Executive Action ($fertilizer - $contract)", $body, $rcpt['cc']);
}

function getReceipients($type, $unitID = null)
{
    if ($unitID)
        $result  = mysql_query("SELECT * FROM alert_recipients 
        WHERE (`condition` LIKE '%$type%' OR `condition` = 'ALL') 
        AND (`unit` = '$unitID' OR `unit` IS NULL)");
    else
        $result  = mysql_query("SELECT * FROM alert_recipients 
        WHERE (`condition` LIKE '%$type%' OR `condition` = 'ALL')");
    $cc = [];
    $to = null;
    while ($row = mysql_fetch_assoc($result)) {
        if ($row['main'])
            $to = $row;
        else $cc[] = $row;
    }
    if ($to == null && count($cc) > 0) $to = array_pop($cc);
    return ['to' => $to, 'cc' => $cc];
}

function has($props = [], $result = [], $lower = [], $upper = [], $target = [], $man = [])
{
    $has = [];
    foreach ($props as $prop) {
        $has[$prop] = ne($result, $prop) || ne($lower, $prop) || ne($upper, $prop) || ne($target, $prop) || ne($man, $prop);
    }
    return $has;
}
function ne($arr, $value)
{
    return isset($arr[$value]) && $arr[$value] != '' && (float)($arr[$value]) > 0;
}
function eod($val, $def = [])
{
    return isset($val) && is_array($val)  ? $val : $def;
}

function necho($val)
{
    if (isset($val)) echo $val;
}

function find($table, $id, $id_field='id'){
  if($id == null) return;
  $query = mysql_query("SELECT * FROM $table WHERE $id_field=$id");
  return mysql_fetch_assoc($query);
}

function insert($field_names, $fields, $table, $log = true)
{
    $values = [];
    $names = [];
    foreach ($field_names as $field) {
        if (is_array($field)) {
            $names[] = key($field);
            $type = $field[key($field)];
            if ($type == 'checkbox')
                $values[] = isset($_POST[key($field)]) ? $_POST[key($field)] === 'on' : 0;
        } else {
            $names[] = $field;
            $values[] = isset($fields[$field]) ? "'" . addslashes($fields[$field]) . "'" : 'NULL';
        }
    }
    $names = join(', ', $names);
    $values = join(', ', $values);
    $query = "INSERT INTO $table ($names) VALUES ($values)";
    mysql_query($query, null, $log) or die(mysql_error());
    return mysql_insert_id();
}

function update($field_names, $fields, $id, $table, $log = true)
{
  $set = '';
  foreach ($field_names as $field) {
      if (is_array($field)) {
          $names[] = key($field);
          $type = $field[key($field)];
          if ($type == 'checkbox')
              $values[] = isset($_POST[key($field)]) ? $_POST[key($field)] === 'on' : 0;
      } else {
          $value = isset($fields[$field]) ? "'" . addslashes($fields[$field]) . "'" : 'NULL';
          $set .= strlen($set) > 0 ? ', ' : '';
          $set .= "$field = $value";
      }
  }
  $id_field = 'id';
  if(is_array($id)){
    $id_field = array_keys($id)[0];
    $id = $id[$id_field];
  }
  $query = "UPDATE $table SET $set WHERE $id_field = $id";
  mysql_query($query, null, $log) or die(mysql_error());
  return true;
}

function renderImage($link, $cover = '', $width = '')
{
    if ($cover == '') $link = $cover;
    $style = $width != '' ? "width:$width" : "height: 120px;";
    return "<a href='$link' target='_blank' rel='noopener noreferrer'>
      <img src='$cover' alt='Fjords' style='$style'>
    </a>";
}
function fileIcon($filename)
{
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    if (in_array(strtolower($extension), ['doc','docx','pdf','xls','xlsx','ppt','pptx'])) return "images/icons/$extension.png";
    return "images/icons/file.png";
}
function renderAttachment($attachment, $label = "", $full = true)
{
    if ($attachment == null || $attachment['file'] == 'no_image.jpg') return;
    $label .= $label != '' ? "<br />" : "";
    if (!isset($attachment['type']) 
        || $attachment['type'] == null 
        || $attachment['type'] == 'Image' 
        || in_array(pathinfo(strtolower($attachment['file']), PATHINFO_EXTENSION),['jpg','png','gif','webp','jpeg'])
    ) {
        $display = "images/analysis/{$attachment['file']}";
    }
    else if (!isset($attachment['cover_image']) || $attachment['cover_image'] == null) {
        $display = fileIcon($attachment['file']);
    } else {
        $display = $attachment['cover_image'];
    }
    $attachment['file'] = "images/analysis/{$attachment['file']}";
    $type = $attachment['type'] ?? 'Image';
    $image = $full ? renderImage($attachment['file'], $display) : renderImage($attachment['file'], $display, '80px');
    echo $full ? "<div class='col-md-4'>
    <div class='thumbnail'>
      $image
      <div class='caption'>
        <p>$label
        <b>$type</b><br/>
        " . ($attachment['comments'] != null ? "Comment: {$attachment['comments']}<br/>" : '') . "
        " . ($attachment['description'] != null ? "Description: {$attachment['description']}<br/>" : '') . "
        " . ($attachment['location'] != null ? "Location: {$attachment['location']}" : '') . "
        </p>
      </div>
    </div>
  </div>" : $image;
}

function printLimit($name, $type) {
  $query1 = "SELECT * FROM tbl_fertilizer_limits WHERE fertilizerID='$type' && item ='$name'";
  $results21 = mysql_query($query1);
  if($row = mysql_fetch_array($results21))
    extract($row); ?>
  <tr>
    <td align="left"><?php echo $name; ?></td>
    <td align="center"><?php echo $moisture ?? ''; ?></td>
    <td align="center"><?php echo $n ?? ''; ?></td>
    <td align="center"><?php echo $p2o5 ?? ''; ?></td>
    <td align="center"><?php echo $k2o ?? ''; ?></td>
    <td align="center"><?php echo $s ?? ''; ?></td>
    <td align="center"><?php echo $b ?? ''; ?></td>
    <td align="center"><?php echo $zn ?? ''; ?></td>
    <td align="center"><?php echo $pH ?? ''; ?></td>
    <td align="center"><?php echo $total ?? ''; ?></td>
    <td align="center"><i class="fa fa-check"></i></td>

  </tr>
<?php }

function physicalAnalysis($physicals, $sample_size)
{
    switch ($sample_size) {
        case 'Granular':
          $target = 2.5;
          $tolerance = 0.5;
          $fine_dimensions = 2;
          $coarse_dimensions = 5;
          $std_range = '2.0-5.0';
          break;
        case 'Prilled':
          $target = 1.5;
          $tolerance = 0.5;
          $fine_dimensions = 1;
          $coarse_dimensions = 2;
          $std_range = '1.0-2.0';
          break;
        case 'Crystaline':
          $target = 0.7;
          $tolerance = 0.3;
          $fine_dimensions = 0.4;
          $coarse_dimensions = 1.0;
          $std_range = '0.4-1.0';
          break;
        default:
          $target = 0.7;
          $tolerance = 0.3;
          $fine_dimensions = 0.4;
          $coarse_dimensions = 1.0;
          $std_range = '0.4-1.0';
          break;
      }
      ?>
    <table border="1" width="100%" class="granulation">
      <tr>
        <th colspan="5">Physical Analysis</th>
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
        <td><?php echo $target; ?></td>
        <td>±<?php echo $tolerance; ?></td>
        <td><?php echo $physicals['mean_particle_size']; ?></td>
      </tr>
      <tr>
        <td>Fine Particles</td>
        <td>
          <<?php echo $fine_dimensions; ?>mm(% mass)</td>
        <td><5</td>
        <td>n/a</td>
        <td><?php echo $physicals['fine_particles']; ?></td>
      </tr>
      <tr>
        <td>Coarse Particles</td>
        <td>><?php echo $coarse_dimensions; ?>mm (% mass)</td>
        <td><5</td>
        <td>n/a</td>
        <td><?php echo $physicals['coarse_particles']; ?></td>
      </tr>
      <tr>
        <td>Mean Range</td>
        <td><?php echo $std_range; ?> mm (% mass)</td>
        <td>95</td>
        <td>±5</td>
        <td><?php echo $physicals['mean_range']; ?></td>
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
        <td>n/a</td>
        <td><?php echo $physicals['gsi']; ?></td>
      </tr>
      <tr>
        <td>Average Shear Strength</td>
        <td>
           (kg/cm<sup>2</sup>)
        </td>
        <td>
          n/a
        </td>
        <td>
          n/a
        </td>
        <td><?php echo $physicals['avg_shear_strength']; ?></td>
      </tr>
    </table><?php
}

class StringTools
{
  public static function convertForLog($variable) {
    if ($variable === null) {
      return 'null';
    }
    if ($variable === false) {
      return 'false';
    }
    if ($variable === true) {
      return 'true';
    }
    if (is_array($variable)) {
      return json_encode($variable);
    }
    return $variable ? $variable : "";
  }

  public static function toAsciiTable($array, $fields, $wrapLength) {
    // get max length of fields
    $fieldLengthMap = [];
    foreach ($fields as $field) {
      $fieldMaxLength = 0;
      foreach ($array as $item) {
        $value = self::convertForLog(trim($item[$field] ?? ""));
        $length = strlen($value);
        $fieldMaxLength = $length > $fieldMaxLength ? $length : $fieldMaxLength;
      }
      $fieldMaxLength = $fieldMaxLength > $wrapLength ? $wrapLength : $fieldMaxLength;
      $fieldLengthMap[$field] = $fieldMaxLength;
    }

    // create table
    $asciiTable = "";
    $totalLength = 0;
    foreach ($array as $item) {
      // prepare next line
      $valuesToLog = [];
      foreach ($fieldLengthMap as $field => $maxLength) {
        $valuesToLog[$field] = self::convertForLog(trim($item[$field] ?? ""));
      }

      // write next line
      $lineIsWrapped = true;
      while ($lineIsWrapped) {
        $lineIsWrapped = false;
        foreach ($fieldLengthMap as $field => $maxLength) {
          $valueLeft = $valuesToLog[$field];
          $valuesToLog[$field] = "";
          if (strlen($valueLeft) > $maxLength) {
            $valuesToLog[$field] = substr($valueLeft, $maxLength);
            $valueLeft = substr($valueLeft, 0, $maxLength);
            $lineIsWrapped = true;
          }
          $asciiTable .= "| {$valueLeft} " . str_repeat(" ", $maxLength - strlen($valueLeft));
        }
        $totalLength = $totalLength === 0 ? strlen($asciiTable) + 1 : $totalLength;
        $asciiTable .= "|\n";
      }
    }

    // add lines before and after
    $horizontalLine = str_repeat("-", $totalLength);
    $asciiTable = "{$horizontalLine}\n{$asciiTable}{$horizontalLine}\n";
    return $asciiTable;
  }
}