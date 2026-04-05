<div class="form-group row">
  <label for="horizontalFormEmail" class="col-sm-4 control-label">TEST: <?php echo $selected; ?></label>
</div>
<div class="form-group row">
	<label class="control-label col-md-4">Color difference %
	</label>
	<div class="col-md-5">
		<input type="text" name="color_diff" placeholder="Color difference %" class="form-control input-height" />
	</div>
</div>
<div class="form-group row">
	<label class="control-label col-md-4">Granular size %
	</label>
	<div class="col-md-5">
		<input type="text" name="granular_size" required placeholder="Granular size %" class="form-control input-height" />
	</div>
</div>
<div class="form-group row">
	<label class="control-label col-md-4">Identifiable different fertilizer granules%
	</label>
	<div class="col-md-5">
		<input type="text" name="idf_granules" required placeholder="Identifiable different fertilizer granules%" class="form-control input-height" />
	</div>
</div>
<div class="form-group row">
	<label class="control-label col-md-4">Foreign matter %
	</label>
	<div class="col-md-5">
		<input type="text" name="foreign_matter" required placeholder="Foreign matter %" class="form-control input-height" />
	</div>
</div>
<div class="form-group row">
	<label class="control-label col-md-4">Lump %
	</label>
	<div class="col-md-5">
		<input type="text" name="lump_percentage" required placeholder="Lump %" class="form-control input-height" />
	</div>
</div>
<div class="form-actions">
	<div class="row">
		<div class="offset-md-4 col-md-8">
			<button type="submit" name="submit" class="btn btn-info">Add Analysis</button>
		</div>
	</div>
</div>