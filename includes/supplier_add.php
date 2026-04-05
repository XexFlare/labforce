<div class="row">
	<div class="col-md-12 col-sm-12">
		<header><b>ADD SUPPLIER:</b></header>
		<div class="card card-box">
			<div class="card-body">
				<form method="POST" action="supplier_add2.php" class="form-horizontal">
					<div class="form-body">
						<div class="form-group row">
							<label class="control-label col-md-3">Supplier Name
								<span class="required"> * </span>
							</label>
							<div class="col-md-7">
								<input type="text" name="details" required placeholder="Supplier name" class="form-control input-height" />
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Address
								<span class="required"> * </span>
							</label>
							<div class="col-md-5">
								<textarea name="address" required placeholder="Address" class="form-control-textarea" rows="5"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="horizontalFormEmail" class="col-sm-3 control-label">Countries</label>
							<span class="required"> * </span>
							<div class="col-sm-3">
								<div class="search-box">
									<?php
									$query = "select * from tbl_countries ORDER BY country ASC";
									$result = mysql_query($query) or die("Couldn't execute query.");
									echo "<select name='country' class='form-control input-height' required>\n";
									echo "<option selected='false' value=''>Select Country</font></option> ";
									while ($row = mysql_fetch_array($result)) {
										extract($row);
										echo "<option value='$countryID'>$country\n";
									}
									echo "</select>\n";
									?>
									<div class="result"></div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Phone No.
								<span class="required"> * </span>
							</label>
							<div class="col-md-3">
								<input name="phone" required type="text" placeholder="Phone number" class="form-control input-height" />
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Email
							</label>
							<div class="col-md-5">
								<div class="input-group">

									<input type="email" class="form-control input-height" name="email" placeholder="Email Address">
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-3">Remarks
								<span class="required"> * </span>
							</label>
							<div class="col-md-6">
								<textarea name="notes" placeholder="Partner related notes" class="form-control-textarea" rows="5"></textarea>
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="offset-md-3 col-md-9">
									<button type="submit" class="btn btn-info">Add Supplier</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>