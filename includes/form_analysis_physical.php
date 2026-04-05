<div class='border px-1 my-1'>
  <!-- <h4>Granulation of Raw Material</h4> -->
  <div class="form-group row">
    <label class="control-label col-md-4">Mean Particle Size
      <span class="required"> * </span>
    </label>
    <div class="col-md-8">
      <input type="text" name="mean_particle_size" placeholder="Mean Particle Size (mm)" class="form-control input-height" />
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-md-4">Fine Particles
      <span class="required"> * </span>
    </label>
    <div class="col-md-8">
      <input type="text" name="fine_particles" required placeholder="Fine Particles (%mass)" class="form-control input-height" />
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-md-4">Coarse Particles
      <span class="required"> * </span>
    </label>
    <div class="col-md-8">
      <input type="text" name="coarse_particles" required placeholder="Coarse Particles (%mass)" class="form-control input-height" />
    </div>
  </div>
  <div class="form-group row">
    <label class="control-label col-md-4">Mean Range
      <span class="required"> * </span>
    </label>
    <div class="col-md-8">
      <input type="text" name="mean_range" required placeholder="Mean Range (%mass)" class="form-control input-height" />
    </div>
  </div>
  <div class="form-group row">
    <label class="control-label col-md-4">Granulation Spread Index
      <span class="required"> * </span>
    </label>
    <div class="col-md-8">
      <input type="text" name="gsi" required placeholder="Granulation Spread Index (GSI)" class="form-control input-height" />
    </div>
  </div>
  <div class="form-group row">
    <label class="control-label col-md-4">Average Shear Strength
      <span class="required"> * </span>
    </label>
    <div class="col-md-8">
      <input type="text" name="avg_shear_strength" required placeholder="Average Shear Strength (kg/cm2)" class="form-control input-height" />
    </div>
  </div>
</div>
<div class="form-actions">
  <div class="row">
    <div class="offset-md-4 col-md-8">
      <button type="submit" name="submit" class="btn btn-info">Add Analysis</button>
    </div>
  </div>
</div>