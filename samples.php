<?php include("includes/header.php");
$res = mysql_query("
SELECT tbl_samples.*, tbl_sample_techs.name FROM tbl_samples
LEFT JOIN tbl_sample_techs ON tbl_sample_techs.id = tbl_samples.taken_by
ORDER BY delivery_time DESC");
?>
 
	 
	<div id="top"></div>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-bar">
				<div class="page-title-breadcrumb">
					<div class=" pull-left">
						<div class="page-title">Samples</div>
					</div>
					<ol class="breadcrumb page-breadcrumb pull-right">
						<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
						</li>
						<li class="active">Dashboard</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-body">
									<div class="panel tab-border card-topline-aqua">
										<header class="panel-heading panel-heading-gray custom-tab">
											<ul class="nav nav-tabs">
												<li class="nav-item">
													<a href="samples_add.php"> <i class="fa fa-plus"></i>Add Sample
													</a>
												</li>
											</ul>
										</header>
										<div class="card-body ">
										<div class="table-wrap">
											<div class="table-scrollable">
												<table class="table table-hover table-checkable order-column full-width" id="example3">
														<thead>
															<tr>
																<th>#</th>
																<th>Sample Number</th>
																<th>Taken By</th>
																<th>Taken At</th>
																<th>View</th>
															</tr>
														</thead>
														<tbody>
															<?php $i = 1;
															while ($row = mysql_fetch_array($res)) { ?>
																<tr>
																	<td><?php echo $i++; ?></td>
																	<td><?php echo $row['sample_number']; ?></td>
																	<td><?php echo $row['name']; ?></td>
																	<td><?php echo date("d/m/Y", strtotime($row['delivery_time'])); ?></td>
																	<td><a href='<?php echo "/sample.php?id={$row['id']}"; ?>' class='btn btn-info btn-xs'><i class='fa fa-eye '></i></a></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("includes/javascript_includes.php"); ?>
<?php include("includes/footer.php"); ?>
</body>

</html>