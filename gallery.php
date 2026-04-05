<?php include("includes/header.php"); ?>
<?php include("includes/helpers.php"); ?>
 
   
  <div id="top"></div>
  <div class="page-content-wrapper">
    <div class="page-content ">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">Gallery</font>
            </div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Gallery</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="white-box">
            <?php
            if (isset($_GET['id'])) {
              $id = $_GET['id'];
              $result = mysql_query("SELECT * FROM tbl_tests WHERE testID='$id'");
              while ($row1 = mysql_fetch_array($result)) {
                $productPhoto = $row1["productPhoto"];
                $packagePhoto = $row1["packagePhoto"];
                $labPhoto = $row1["labPhoto"];
                $batchID = $row1["batchID"];
              }
              $results = mysql_query("select tbl_photos.*, doc_types.name as type, doc_types.cover_image, locations.name as location, photo_descriptions.name as description from tbl_photos
              LEFT JOIN locations ON locations.id = tbl_photos.location_id
              LEFT JOIN photo_descriptions ON photo_descriptions.id = tbl_photos.description_id
              LEFT JOIN doc_types ON doc_types.id = tbl_photos.type_id
                WHERE parent_id=$id AND parent_type='test'
                OR parent_id=$batchID AND parent_type='batch'
                ");
              $gallery = [];
              if ($labPhoto != 'no_image.jpg') $gallery[] = ['comments' => '', 'location' => '','description' => '', 'file' => $labPhoto, 'type' => 'Lab Photo'];
              if ($productPhoto != 'no_image.jpg') $gallery[] = ['comments' => '', 'location' => '','description' => '', 'file' => $productPhoto, 'type' => 'Product Photo'];
              if ($packagePhoto != 'no_image.jpg') $gallery[] = ['comments' => '', 'location' => '','description' => '', 'file' => $packagePhoto, 'type' => 'Package Photo'];
              while ($row = mysql_fetch_array($results)) {
                $gallery[] = $row;
              }
              echo '<div class="row">';
              foreach ($gallery as $attachment) {
                renderAttachment($attachment);
              }
            }
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php include("includes/footer.php"); ?>
    </div>
    <?php include("includes/javascript_includes.php"); ?>
    </body>

    </html>