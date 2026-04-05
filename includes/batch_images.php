 <?php 
 $images = mysql_query("select tbl_photos.*, locations.name as location from tbl_photos
 LEFT JOIN locations ON locations.id = tbl_photos.location_id
 where parent_id=$batch and parent_type='batch'");
  $lab1 = ['comments' => '', 'location' => '', 'file' => 'no_image.jpg'];
  $product = ['comments' => '', 'location' => '', 'file' => 'no_image.jpg'];
  $package = ['comments' => '', 'location' => '', 'file' => 'no_image.jpg'];
  $lab2 = ['comments' => '', 'location' => '', 'file' => 'no_image.jpg'];
  $lab3 = ['comments' => '', 'location' => '', 'file' => 'no_image.jpg'];
  $gallery = [];
 while ($row = mysql_fetch_array($images)) {
    if($row['ref'] == 'package')
      $package = $row;
    if ($row['ref'] == 'product')
      $product = $row;
    if ($row['ref'] == 'lab1')
      $lab1 = $row;
    if ($row['ref'] == 'lab2')
      $lab2 = $row;
    if ($row['ref'] == 'lab3')
      $lab3 = $row;
    if ($row['ref'] == 'gallery')
      $gallery[] = $row;
  }
  ?>
 <div class="row">
   <div class="col-md-4">
     <div class="thumbnail">
       <a href="images/analysis/<?php echo $product['file']; ?>">
         <img src="images/analysis/<?php echo $product['file']; ?>" alt="Lights" style="height:100px" />
         <div class="caption"></div>
       </a>
       <p><small>
           Comment<br />
           <?php echo $product['comments']; ?><br />
           Location<br />
           <?php echo $product['location']; ?>
         </small></p>
       <p><a href="photo_lab_add.php?batch=<?php echo "$batchID"; ?>&ref=product">Add Photo 1</a></p>
     </div>
   </div>

   <div class="col-md-4">
     <div class="thumbnail">
       <a href="images/analysis/<?php echo $package['file']; ?>">
         <img src="images/analysis/<?php echo $package['file']; ?>" alt="Nature" style="height:100px">
         <div class="caption"></div>
       </a>
       <p><small>
           Comment<br />
           <?php echo $package['comments']; ?><br />
           Location<br />
           <?php echo $package['location']; ?>
         </small></p>
       <p><a href="photo_lab_add.php?batch=<?php echo "$batchID"; ?>&ref=package"> Add Photo 2</a></p>
     </div>

   </div>
   <div class="col-md-4">
     <div class="thumbnail">
       <a href="images/analysis/<?php echo $lab1['file']; ?>">
         <img src="images/analysis/<?php echo $lab1['file']; ?>" alt="Fjords" style="height:100px">
         <div class="caption"></div>
       </a>
       <p><small>
           Comment<br />
           <?php echo $lab1['comments']; ?><br />
           Location<br />
           <?php echo $lab1['location']; ?>
         </small></p>
       <p><a href="photo_lab_add.php?batch=<?php echo "$batchID"; ?>&ref=lab1">Add Photo 3</a></p>
     </div>
   </div>
   <div class="col-md-4">
     <div class="thumbnail">
       <a href="images/analysis/<?php echo $lab2['file']; ?>">
         <img src="images/analysis/<?php echo $lab2['file']; ?>" alt="Fjords" style="height:100px">
         <div class="caption"></div>
       </a>
       <p><small>
           Comment<br />
           <?php echo $lab2['comments']; ?><br />
           Location<br />
           <?php echo $lab2['location']; ?>
         </small></p>
       <p><a href="photo_lab_add.php?batch=<?php echo "$batchID"; ?>&ref=lab2">Add Photo 4</a></p>
     </div>
   </div>
   <div class="col-md-4">
     <div class="thumbnail">
       <a href="images/analysis/<?php echo $lab3['file']; ?>">
         <img src="images/analysis/<?php echo $lab3['file']; ?>" alt="Fjords" style="height:100px">
         <div class="caption"></div>
       </a>
       <p><small>
           Comment<br />
           <?php echo $lab3['comments']; ?><br />
           Location<br />
           <?php echo $lab3['location']; ?>
         </small></p>
       <p><a href="photo_lab_add.php?batch=<?php echo "$batchID"; ?>&ref=lab3">Add Photo 5</a></p>
     </div>
   </div>
   <div class="col-md-4">
     <div class="rounded bg-light h-50 p-5 w-50">
       <p><a href="photo_lab_add.php?batch=<?php echo "$batchID"; ?>&ref=gallery"><i class="fa fa-plus" style="font-size: 50px;"></i></a></p>
       <p><?php echo count($gallery); ?></p>
     </div>
   </div>
 </div>