<div class="form-group row">
  <label for="horizontalFormEmail" class="col-sm-4 control-label">TEST: <?php echo $selected; ?></label>
</div>
<?php if ($myLevel == 1 || $myLevel == 2) { ?>
  <div class="form-actions row">
    <label class="control-label">QA Comments
    </label>
    <div class="col-md-12">
      <label class="control-label pr-4"><input type="checkbox" name="comments[Caked]" id="Caked"> Caked</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Contaminated]" id="Contaminated"> Contaminated</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Damaged]" id="Damaged"> Damaged</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Dusty]" id="Dusty"> Dusty</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Lumpy]" id="Lumpy"> Lumpy</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Powder]" id="Powder"> Powder</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Reactant]" id="Reactant"> Reactant</label>
      <label class="control-label pr-4"><input type="checkbox" name="comments[Wet]" id="Wet"> Wet</label>
    </div>
  </div>
  <div class="form-actions row">
    <label class="control-label">QA Remarks
      <span class="required"></span>
    </label>
    <div class="col-md-12">
      <textarea name="execremarks" placeholder="Remarks" class="form-control-textarea" rows="5"></textarea>
    </div>
  </div>
  <div class="form-actions">
    <div class="row">
      <div class="offset-md-4 col-md-8">
        <button type="submit" name="submit" class="btn btn-info">Add Comment</button>
      </div>
    </div>
  </div>
<?php } ?>