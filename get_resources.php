<?php
  include_once("connect/dbconnect.php");
  include_once("includes/helpers.php");
  function rename_fields($row, $def){
    foreach ($def as $old => $new) {
      if(!is_array($row)){
        $row = get_object_vars($row);
      }
      $row[$new] = $row[$old];
      unset($row[$old]);
    }
    return $row;
  }
  function createOrUpdate($row, $table, $fields, $id_field = 'hub_id'){
    if(!is_array($row)){
      $row = get_object_vars($row);
    }
    $current = find($table, $row['id'], $id_field);
    $row = rename_fields($row, ['id' => 'hub_id']);
    if($current){
      unset($fields[array_search($id_field, $fields)]);
      update($fields, $row, [$id_field => $row[$id_field]], $table, false);
    } else {
      insert($fields, $row, $table, false);
    }
  }
  $res = file_get_contents(getenv('FORCEHUB_URL').'/api/resources', false, stream_context_create([
    'http' => [
      'header'  => "Accept: application/json"
    ]
  ]));
  $resource = json_decode($res);
  foreach ($resource->blends as $row) {
    createOrUpdate($row, 'tbl_blend_types', ['name','hub_id']);
  }
  foreach ($resource->business_units as $row) {
    $row = rename_fields($row, ['name' => 'unit_name']);
    createOrUpdate($row, 'tbl_business_units', ['hub_id','unit_name','shortname']);
  }
  foreach ($resource->suppliers as $row) {
    $row = rename_fields($row, ['name' => 'details', 'country_id' => 'country']);
    createOrUpdate($row, 'tbl_suppliers', ['hub_id','details','country','email','phone','address','notes']);
  }
  foreach ($resource->fertilizers as $row) {
    $row = rename_fields($row, ['name' => 'fertilizer']);
    $blend = find('tbl_blend_types',$row['blend_id'], 'hub_id');
    $row['blend'] = $blend['name'];
    createOrUpdate($row, 'tbl_fertilizer_types', ['hub_id','fertilizer','blend','formula']);
  }
  foreach ($resource->contracts as $row) {
    $row = rename_fields($row, ['accpac_ref' => 'acc_reference', 'date' => 'contractDate', 'blend_id' => 'blend_type_id', 'symbian_contract' => 'sybrian_contract']);
    $fertilizer = find('tbl_fertilizer_types',$row['fertilizer_id'], 'hub_id');
    $supplier = find('tbl_suppliers',$row['supplier_id'], 'hub_id');
    $ship = find('tbl_ship_details',$row['ship_id'], 'hub_id');
    $row['blend'] =  $blend['name'] ?? NULL;
    $row['ship_name'] = $ship['ship_name'] ?? NULL;
    $row['supplier_id'] =  $supplier['supplierID'] ?? NULL;
    $row['fertilizer_name'] =  $fertilizer['fertilizerID'] ?? NULL;
    createOrUpdate($row, 'tbl_contracts', ['hub_id','meridian_contract','fertilizer_name','sybrian_contract','ship_name','contractDate','vessel','blend_type_id','supplier_id','acc_reference','country_id']);
  }
?>