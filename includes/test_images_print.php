<?php
$data=mysql_fetch_assoc(mysql_query("select count(*) as count from tbl_photos 
left join tbl_tests on tbl_tests.batchID = $batchID
where parent_type='test'
and parent_id in(tbl_tests.testID)"));
$odata=mysql_fetch_assoc(mysql_query("select count(*) as count from tbl_tests
where batchID=$batchID
and productPhoto <> 'no_image.jpg'
and packagePhoto <> 'no_image.jpg'
and labPhoto <> 'no_image.jpg'"));
$hasTestPhotos = $odata['count'] != 0 && $data !=0;
$gallery = [];
if($hasTestPhotos) {
  $sql = "SELECT * FROM tbl_tests WHERE testID='$testID'";
  $result = mysql_query($sql);
  while ($row1 = mysql_fetch_array($result)) {
    $productPhoto = $row1["productPhoto"];
    $packagePhoto = $row1["packagePhoto"];
    $labPhoto = $row1["labPhoto"];
  }
  $results = mysql_query("select tbl_photos.*, doc_types.name as type, doc_types.cover_image, locations.name as location, photo_descriptions.name as description from tbl_photos
  LEFT JOIN locations ON locations.id = tbl_photos.location_id
  LEFT JOIN photo_descriptions ON photo_descriptions.id = tbl_photos.description_id
  LEFT JOIN doc_types ON doc_types.id = tbl_photos.type_id
  where parent_id=$testID and parent_type='test'");
  if ($labPhoto != 'no_image.jpg') $gallery[] = ['comments' => '', 'location' => '', 'description' => '', 'file' => $labPhoto, 'type' => 'Lab Photo'];
  if ($productPhoto != 'no_image.jpg') $gallery[] = ['comments' => '', 'location' => '', 'description' => '', 'file' => $productPhoto, 'type' => 'Product Photo'];
  if ($packagePhoto != 'no_image.jpg') $gallery[] = ['comments' => '', 'location' => '', 'description' => '', 'file' => $packagePhoto, 'type' => 'Package Photo'];
  while ($row = mysql_fetch_array($results)) {
    $gallery[] = $row;
  }
} else {
  $results = mysql_query("select tbl_photos.*, doc_types.name as type, doc_types.cover_image, locations.name as location, photo_descriptions.name as description from tbl_photos
  LEFT JOIN locations ON locations.id = tbl_photos.location_id
  LEFT JOIN photo_descriptions ON photo_descriptions.id = tbl_photos.description_id
  LEFT JOIN doc_types ON doc_types.id = tbl_photos.type_id
  where parent_id=$batchID and parent_type='batch'");
  while ($row = mysql_fetch_array($results)) {
    $gallery[] = $row;
  }
}
echo '<div class="row">';
foreach ($gallery as $k => $attachment) {
  renderAttachment($attachment);
  if($k == 4) break;
}
if(count($gallery) == 6) renderAttachment($gallery[5]);
if(count($gallery) > 6) {
  ?>
    <div class="col-md-4">
      <div class="rounded h-50 w-50">
        <div class="row">
          <div class="col p-0">
            <?php renderAttachment($gallery[5], "", false); ?>
          </div>
          <div class="col p-0">
            <?php renderAttachment($gallery[6], "", false); ?>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col p-0">
            <?php if (isset($gallery[7])) renderAttachment($gallery[7], "", false); ?>
          </div>
          <div class="col">
            <a href="gallery.php?id=<?php echo $testID; ?>" target="_blank" rel="noopener noreferrer">
              <div style="width: 100px; height: 70px; padding-top: 20px" class="bg-light">
                <p class="text-center">View All</p>
              </div>
            </a>
          </div>
        </div>
      </div>
      </div>
    <?php
  }
    ?>
    </div>