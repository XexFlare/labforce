<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="card card-box">
      <div class="card-body">
        <form method="POST" action="fertilizer_limit_add2.php" class="form-horizontal">
          <div class="form-body">
            <div class="form-group row">
              <label class="control-label col-md-4">Item
                <span class="required"> * </span>
              </label>
              <div class="col-md-8">
                <select class="form-control input-height" required name="item">
                  <option value="">Item...</option>
                  <option value="UPPER LIMIT">UPPER LIMIT</option>
                  <option value="LOWER LIMIT">LOWER LIMIT</option>
                  <option value="TARGET">TARGET</option>
                </select>
              </div>
            </div>
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
                <input type="text" name="ph" required placeholder="pH" class="form-control input-height" />
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-4">Total
                <span class="required"> * </span>
              </label>
              <div class="col-md-5">
                <input type="text" name="total" required placeholder="Total" class="form-control input-height" />
              </div>
            </div>
            <input name="fertilizerID" type="hidden" value="<?php echo "$id"; ?>">
            <div class="form-actions">
              <div class="row">
                <div class="offset-md-4 col-md-8">
                  <button type="submit" class="btn btn-info">Add Limit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>