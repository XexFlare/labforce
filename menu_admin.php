<div class="sidebar-container">
	<div class="sidemenu-container navbar-collapse collapse fixed-menu">
		<div id="remove-scroll" class="left-sidemenu">
			<ul class="sidemenu page-header-fixed sidemenu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
				<li class="sidebar-toggler-wrapper hide">
					<div class="sidebar-toggler">
						<span></span>
					</div>
				</li>
				<li class="sidebar-user-panel">
					<div class="user-panel">
						<div class="pull-left image">
							<img src="images/user/<?php echo "$myPic"; ?>" class="img-circle user-img-circle" alt="User Image" />
						</div>
						<div class="pull-left info">
							<p> <?php echo "$myFirst $myLast"; ?></p>
							<a href="#"><i class="fa fa-circle user-online"></i><span class="txtOnline"> Online</span></a>
						</div>
					</div>
				</li>
				<li class="nav-item">
					<a href="index.php" class="nav-link nav-toggle"> <i class="material-icons">home</i>
						<span class="title">Dashboard</span>
					</a>
				</li>
				<?php if ($myLevel <= 2) { ?>
					<li class="nav-item">
						<a href="executive_tests.php" class="nav-link nav-toggle"> <i class="material-icons">dashboard</i>
							<span class="title">Director's Dashboard</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="damaged.php" class="nav-link"><i class="material-icons">autorenew</i>
							<span class="title">Executive Dashboard</span>
						</a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a href="supplier_list.php" class="nav-link nav-toggle"> <i class="material-icons">train</i>
						<span class="title">Suppliers</span>
					</a>
				</li>
				
				<li class="nav-item">
					<a href="batch_add.php" class="nav-link nav-toggle"><i class="material-icons">search</i>
						<span class="title">Lab</span><span class="arrow"></span></a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a href="tests.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Tests</span></a>
						</li>
						<li class="nav-item">
							<a href="batch_add.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Create Lab Batch</span></a>
						</li>
						<li class="nav-item">
							<a href="batches.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Lab Batches</span></a>
						</li>
						<li class="nav-item">
							<a href="samples.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Samples</span></a>
						</li>
						<li class="nav-item">
							<a href="sweepings_add.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Create Sweepings Batch</span></a>
						</li>
						<li class="nav-item">
							<a href="sweepings_list.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Sweepings Batches</span></a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="fertilizers.php" class="nav-link nav-toggle"> <i class="material-icons">opacity</i>
						<span class="title">Fertilizers</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link nav-toggle"> <i class="material-icons">report</i>
						<span class="title">Reports</span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a href="contracts.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Contracts</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="fertilizer_types.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Fertilizer Types</span>
							</a>
						</li>
					</ul>
				</li>
				<!-- <li class="nav-item">
					<a href="#" class="nav-link nav-toggle"> <i class="material-icons">help</i>
						<span class="title">Help</span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a href="#" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Company Number Codes</span>
							</a>
						</li>
					</ul>
				</li> -->
					<?php if ($myLevel == 1) { ?>
					<li class="nav-item">
						<a href="#" class="nav-link nav-toggle"><i class="material-icons">settings</i>
							<span class="title">Settings</span><span class="arrow"></span></a>
						<ul class="sub-menu" id="settings-nav">
							<li class="nav-item">
								<a href="contract_add.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Contracts List</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="fertilizer_add.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Fertilizer Types</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="color_add.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Fertilizer Colors</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="business_unit_add.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Business Unit</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="suppliers.php" class="nav-link "> <span class="title"><i class="material-icons">chevron_right</i> Suppliers</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="system_users.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Users</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="directors_report.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i> Upload Report</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="alerts.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i>Email Alerts</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="audit.php" class="nav-link"> <span class="title"><i class="material-icons">chevron_right</i>Audit Trail</span></a>
							</li>
						</ul>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>