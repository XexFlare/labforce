<div class="form-group row">
  <label for="horizontalFormEmail" class="col-sm-4 control-label">TEST: <?php echo $selected; ?></label>
</div>
<div class="form-group row">
  <h4>External Inspection of Raw Material</h4>
</div>
<div class="form-group row">
  <label class="control-label">Sampled lot was uniform</b></label>
  <div class="col-md-12">
    <label class="control-label">Probably
      <input type="radio" name="uniform" value="Probably"></label>
    <label class="control-label">Unlikely
      <input type="radio" name="uniform" value="Unlikely"></label>
  </div>
</div>
<div class="form-group row">
  <label class="control-label">Based on the following reasons</label>
</div>
<div class="form-group">
  <label class="control-label text-left row">
    <div class="col-md-10">The color of the raw material was <b>uniform</b></div>
    <div class="col-md-2">
      <input type="checkbox" name="uniform_color">
    </div>
  </label>
</div>
<div class="form-group">
  <label class="control-label text-left row">
    <div class="col-md-10">The particle size distribution of the raw material was <b>uniform</b></div>
    <div class="col-md-2">
      <input type="checkbox" name="uniform_size_distribution">
    </div>
  </label>
</div>
<div class="form-group">
  <label class="control-label text-left row">
    <div class="col-md-10">The packaging/transport vehicle was <b>clean</b></div>
    <div class="col-md-2">
      <input type="checkbox" name="clean_package">
    </div>
  </label>
</div>
<div class="form-group">
  <label class="control-label text-left row">
    <div class="col-md-10">The sealing of the packaging/transport vehicle was <b>uniform</b></div>
    <div class="col-md-2">
      <input type="checkbox" name="uniform_seal">
    </div>
  </label>
</div>
<div class="form-group row">
  <h4>Deterioration or Damage to the Raw Material</h4>
</div>
<div class="form-group">
  <label class="control-label text-left row">
    <div class="col-md-10">The raw material appeared to be <b>damaged</b></div>
    <div class="col-md-2">
      <input type="checkbox" name="damaged">
    </div>
  </label>
</div>
<div class="form-group">
  <label class="control-label text-left row">
    <div class="col-md-10">The deteriorated part was <b>sampled separated</b></div>
    <div class="col-md-2">
      <input type="checkbox" name="separated">
    </div>
  </label>
</div>
<!-- TODO: if damaged -->
<div class="">
  <div class="form-group">
    <label class="control-label text-left">The raw material appeared to be deteriorated/damaged by</label>
    <select name="damaged_by">
    <option selected='false' value=''></option>
      <option>Moisture</option>
      <option>Heat</option>
      <option>Damage to the packaging/transport vehicle cover</option>
      <option>Contamination from the packaging/transport vehicle</option>
      <option>Mixing with adjoining lots</option>
      <option>Segregation</option>
      <option>Hardening</option>
      <option>Other (Specify)</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label text-left">
      Other:
    </label>
    <input type="text" name="damaged_by_other" id="">
  </div>
</div>
<div class="form-group">
  <label class="control-label text-left">
    The deteriorated part of the lot included: (percent of the total lot, mass, number of transport vehicles, etc.)
    <textarea name="included" id="" rows="5" class="form-control-textarea"></textarea>
  </label>
</div>
<div class="form-actions">
  <button type="submit" name="submit" class="btn btn-info">Add Visual Inspection</button>
</div>