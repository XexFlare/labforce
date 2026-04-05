  <div class="page-footer">
  	<table border="0" width="100%" id="table1">
  		<tr>
  			<td align="center">
				  <?php 
				  	$res = mysql_query("SELECT shortname from tbl_business_units WHERE unitID = $myUnit");
				  	$unit = mysql_fetch_assoc($res);
					if($unit != NULL)
					  $logo = "images/logos/" . strtolower($unit["shortname"]) . ".png";
					else $logo = "images/logo.png";
				?>
  				<img src="<?php echo $logo; ?>" height="80">
  			</td>
  			<td align="center">&nbsp;</td>
  			<td align="center">
  				<img border="0" src="images/logo_bottom.png" height="80">
  			</td>
  		</tr>
  	</table>
  	<div class="scroll-to-top">
  		<i class="fa fa-arrow-up"></i>
  	</div>
  </div>
  </div>