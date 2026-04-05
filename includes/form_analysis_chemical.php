<div class="form-group row">
  <label for="horizontalFormEmail" class="col-sm-4 control-label">TEST: <?php echo $selected; ?></label>
</div>
<?php if ($myLevel == 3 || $myLevel == 1) { ?>
	<input type="hidden" value="LAB RESULTS" name="item">
	<div class="form-group row">
		<label class="control-label col-md-4">Moisture
			<span class="required"> * </span>
		</label>
		<div class="col-md-8">
			<input type="text" name="moisture" placeholder="MOISTURE" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">N
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="n" required placeholder="N" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">P2O5
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="p2o5" required placeholder="P2O5" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">K2O
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="k2o" required placeholder="K2O" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">S
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="s" required placeholder="S" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">B
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="b" required placeholder="B" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">Zn
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="zn" required placeholder="Zn" class="form-control input-height" />
		</div>
	</div>
	<div class="form-group row">
		<label class="control-label col-md-4">pH
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="pH" required placeholder="pH" class="form-control input-height" />
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-md-4">Total
			<span class="required"> * </span>
		</label>
		<div class="col-md-5">
			<input type="text" name="total" placeholder="Total" class="form-control input-height" />
		</div>

	</div>
	<div class="form-actions row">
	<?php } ?>
	<div class="form-actions">
		<div class="row">
			<div class="offset-md-4 col-md-8">
				<button type="submit" name="submit" class="btn btn-info">Add Analysis</button>
			</div>
		</div>
	</div>