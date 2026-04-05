<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card card-box">
			<div class="card-body ">
				<div class="table-wrap">
					<div class="table-scrollable">
						<table class="table table-hover table-checkable order-column full-width" id="example1">
							<thead>
								<tr>
									<th>#</th>
									<th>Color</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query  = "SELECT * FROM tbl_colors ORDER BY color";
								$results = mysql_query($query);
								$nrows = mysql_num_rows($results);
								$row = mysql_num_rows($results);
								for ($i = 0; $i < $nrows; $i++) {
									$n = $i + 1;
									$row = mysql_fetch_array($results);
									extract($row);
									echo "<tr>
										<td>$n</td>
										<td>$color</td>
										<td>
										<a href='color_delete.php?id=$colorID' class='btn btn-danger btn-xs'>
										<i class='fa fa-trash-o '></i>
										</a>
										</td>
									</tr>";
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>