<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include_once("connect/dbconnect.php");
include("connect/login_script.php");
include('includes/helpers.php');

$id = $_GET['analysisID'] ?? $_GET['id'];
$type = $_GET['type'] ?? 'contract';
if($type == 'contract'){
  $query = mysql_query("SELECT c.*, s.details, co.country, b.name as blend, f.fertilizer from tbl_contracts AS c
  LEFT JOIN tbl_suppliers AS s ON s.supplierID = c.supplier_id
  LEFT JOIN tbl_blend_types AS b ON b.id = c.blend_type_id 
  LEFT JOIN tbl_countries AS co ON co.countryID = s.country
  LEFT JOIN tbl_fertilizer_types AS f ON f.fertilizerID = c.fertilizer_name
  WHERE contractID=$id");
  $condition = "WHERE c.contractID = $id
  AND a.item = 'LAB RESULTS'";
} else {
  $query = mysql_query("SELECT * from tbl_fertilizer_types
  WHERE fertilizerID=$id");
  $fertilizer_name = $id;
  $condition = "WHERE c.fertilizer_name = $id
  AND a.item = 'LAB RESULTS'";
}
$current = mysql_fetch_array($query);
extract($current);
$resultsQuery = mysql_fetch_array(mysql_query("SELECT ROUND(damaged / total * 100, 1) AS damaged_rate, 
ROUND(spec / total * 100, 1) AS spec_rate, 
ROUND(good / total * 100, 1) AS good_rate, 
damaged, total, spec, good
FROM (
	SELECT 
	COUNT(*) as total,
	COUNT(IF(exec_comments IS NOT NULL AND exec_comments <> '', 1, null)) AS damaged,
	COUNT(IF(
       cast(a.n as float) < cast(lowr.n as float) OR cast(a.n as float) > cast(upr.n as float)
    OR cast(a.p2o5 as float) < cast(lowr.p2o5 as float) OR cast(a.p2o5 as float) > cast(upr.p2o5 as float)
    OR cast(a.k2o as float) < cast(lowr.k2o as float) OR cast(a.k2o as float) > cast(upr.k2o as float)
    OR cast(a.s as float) < cast(lowr.s as float) OR cast(a.s as float) > cast(upr.s as float)
    OR cast(a.b as float) < cast(lowr.b as float) OR cast(a.b as float) > cast(upr.b as float)
    OR cast(a.zn as float) < cast(lowr.zn as float) OR cast(a.zn as float) > cast(upr.zn as float), 
    1, null)) AS spec,
	COUNT(IF(
      (lowr.n is null OR cast(a.n as float) > cast(lowr.n as float) AND cast(a.n as float) < cast(upr.n as float))
    AND (lowr.p2o5 is null OR cast(a.p2o5 as float) > cast(lowr.p2o5 as float) AND cast(a.p2o5 as float) < cast(upr.p2o5 as float))
    AND (lowr.k2o is null OR cast(a.k2o as float) > cast(lowr.k2o as float) AND cast(a.k2o as float) < cast(upr.k2o as float))
    AND (lowr.s is null OR cast(a.s as float) > cast(lowr.s as float) AND cast(a.s as float) < cast(upr.s as float))
    AND (lowr.b is null OR cast(a.b as float) > cast(lowr.b as float) AND cast(a.b as float) < cast(upr.b as float))
    AND (lowr.zn is null OR cast(a.zn as float) > cast(lowr.zn as float) AND cast(a.zn as float) < cast(upr.zn as float))
    AND (exec_comments IS NULL OR exec_comments = ''), 
    1, null)) AS good
	FROM tbl_analysis AS a
	LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
	LEFT JOIN tbl_contracts AS c ON c.contractID = b.contractID
	JOIN (
		    SELECT * FROM tbl_fertilizer_limits
			WHERE fertilizerID=$fertilizer_name
			AND item = 'LOWER LIMIT'
		) as lowr,
	    (
		    SELECT * FROM tbl_fertilizer_limits
			WHERE fertilizerID=$fertilizer_name
			AND item = 'UPPER LIMIT'
		) as upr $condition
) AS dmg
"));
extract($resultsQuery);
$results = mysql_query("SELECT a.*, b.batchNum, co.color, c.meridian_contract,
IF(cast(a.n as float) < cast(lowr.n as float) OR cast(a.n as float) > cast(upr.n as float)
    OR cast(a.p2o5 as float) < cast(lowr.p2o5 as float) OR cast(a.p2o5 as float) > cast(upr.p2o5 as float)
    OR cast(a.k2o as float) < cast(lowr.k2o as float) OR cast(a.k2o as float) > cast(upr.k2o as float)
    OR cast(a.s as float) < cast(lowr.s as float) OR cast(a.s as float) > cast(upr.s as float)
    OR cast(a.b as float) < cast(lowr.b as float) OR cast(a.b as float) > cast(upr.b as float)
    OR cast(a.zn as float) < cast(lowr.zn as float) OR cast(a.zn as float) > cast(upr.zn as float),'Spec',if(exec_comments IS NOT NULL AND exec_comments <> '', 'Damaged', 'Good')) as status
FROM tbl_analysis AS a
LEFT JOIN tbl_batches AS b ON b.batchID = a.batchID
LEFT JOIN tbl_contracts AS c ON c.contractID = b.contractID
LEFT JOIN tbl_colors as co ON b.color = co.colorID
JOIN (
    SELECT * FROM tbl_fertilizer_limits
  WHERE fertilizerID=$fertilizer_name
  AND item = 'LOWER LIMIT'
) as lowr,
  (
    SELECT * FROM tbl_fertilizer_limits
  WHERE fertilizerID=$fertilizer_name
  AND item = 'UPPER LIMIT'
) as upr $condition");
$prefix = $type == 'contract' ? $meridian_contract : $fertilizer;
$fileName = "$type-report-$prefix-" . date('Y-m-d') . ".xls"; 

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$writer = new Xlsx($spreadsheet);
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
function filterData(&$str){ 
  $str = preg_replace("/\t/", "\\t", $str); 
  $str = preg_replace("/\r?\n/", "\\n", $str); 
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
$fields = array('Date','Fertilizer','Batch','Contract','Color','N','P205','K20','S','B','ZnS04','Total','Status'); 
$op = $type == 'contract' ? [
  ["CONTRACT", $meridian_contract,'','Tests Done', $total],
  ["VESSEL NAME", $vessel,'','Good Results', $good . " ($good_rate%)"],
  ["SUPPLIER", $details,'','Out of Spec Results', $spec . " ($spec_rate%)"],
  ["COUNTRY OF ORIGIN", $country,'','Damaged Results', $damaged . " ($damaged_rate%)"],
  ["BLEND TYPE", $blend,'',''],
  [],
  $fields
] : [
  ["FERTILIZER", $fertilizer,'','Tests Done', $total],
  ['','','','Good Results', $good . " ($good_rate%)"],
  ['','','','Out of Spec Results', $spec . " ($spec_rate%)"],
  ['','','','Damaged Results', $damaged . " ($damaged_rate%)"],
  ['','','',''],
  [],
  $fields
];
if(mysql_num_rows($results) > 0){ 
  // Output each row of the data 
  while ($row = mysql_fetch_array($results)) {
    $lineData = array(date("d/m/Y", strtotime($row['time'])), $fertilizer,$row['batchNum'],$row['meridian_contract'],$row['color'],$row['n'],$row['p2o5'],$row['k2o'],$row['s'],$row['b'],$row['zn'],$row['total'],$row['status']); 
    array_walk($lineData, 'filterData');
    $op[] = $lineData;
  }
  // echo "<pre>";
  // print_r($op);
  // echo "</pre>";
} 
$spreadsheet->getActiveSheet()->fromArray($op);
for($i=8; $i < mysql_num_rows($results) + 8; $i++){
  $spreadsheet->getActiveSheet()->getStyle("A$i")
  ->getNumberFormat()
  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
}
$extension = 'Xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$fileName.{$extension}\"");
 
// Render excel data 
$writer->save('php://output');
exit;
 
