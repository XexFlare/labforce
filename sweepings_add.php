<?php include("includes/header.php"); 
  $query = "select tbl_contracts.*, tbl_fertilizer_types.fertilizer from tbl_contracts, tbl_fertilizer_types WHERE tbl_contracts.fertilizer_name = tbl_fertilizer_types.fertilizerID AND tbl_contracts.hidden = 0 ORDER BY tbl_fertilizer_types.fertilizer, tbl_contracts.meridian_contract ASC";
  $result = mysql_query($query) or die("Couldn't execute query.");
  ?>
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="page-bar">
        <div class="page-title-breadcrumb">
          <div class=" pull-left">
            <div class="page-title">CREATE SWEEPINGS BATCH</div>
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
              <div class="panel tab-border card-topline-aqua">
                <header class="panel-heading panel-heading-gray custom-tab">
                </header>
                <form action="sweepings_add2.php" id="form_sample_1" class="form-horizontal" method="POST">
                  <br>
                  <div class="form-group row">
                    <label for="contract" class="col-sm-3 control-label">Contract:</label>
                    <span class="required"></span>
                    <div class="col-sm-4">
                      <div class="search-box">
                        <select name='contract' class='form-control input-height' required>
                          <option selected='false' value=''>Contract</font>
                          </option>
                          <?php
                          while ($row = mysql_fetch_array($result)) {
                            extract($row);
                            $date = date("d M Y", strtotime($contractDate));
                            echo "<option value='$contractID'>$fertilizer - $meridian_contract - $date</option>";
                          }
                          ?>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="grade" class="col-sm-3 control-label">Grade:</label>
                    <span class="required"></span>
                    <div class="col-sm-4">
                      <div class="search-box">
                        <select name='grade' class='form-control input-height' required>
                          <option value='DRY DAMAGED FERTILIZER'>DRY DAMAGED FERTILIZER</option>
                          <option value='WET DAMAGED FERTILIZER'>WET DAMAGED FERTILIZER</option>
                          <option value='DISQUALIFIED RAW MATERIAL'>DISQUALIFIED RAW MATERIAL</option>
                          <option value='FACTORY FLOOR SWEEPINGS'>FACTORY FLOOR SWEEPINGS</option>
                          <?php
                          // while ($row = mysql_fetch_array($result)) {
                          //   extract($row);
                          //   $date = date("d M Y", strtotime($contractDate));
                          //   echo "<option value='$contractID'>$fertilizer - $meridian_contract - $date</option>";
                          // }
                          ?>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="color" class="col-sm-3 control-label">Color:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <select name='color' class='form-control input-height' required>
                          <option value='CREAMISH'>CREAMISH</option>
                          <option value='MULTICOLORED'>MULTICOLORED</option>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="moisture" class="col-sm-3 control-label">Moisture Content:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <select name='moisture' class='form-control input-height' required>
                          <option value='DRY'>DRY</option>
                          <option value='WET'>WET</option>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="particle_size" class="col-sm-3 control-label">Particle size Range:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <select name='particle_size' class='form-control input-height' required>
                          <option value='FINE TO COURSE'>FINE TO COURSE</option>
                          <option value='LUMPS'>LUMPS</option>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="foreign_matter" class="col-sm-3 control-label">Foreign Matter:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <input type="text" class="form-control input-height" name="foreign_matter"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="appearance" class="col-sm-3 control-label">Visual Appearance:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <select name='appearance' class='form-control input-height' required>
                          <option value='DRY WHITE POWDER'>DRY WHITE POWDER</option>
                          <option value='OFF-WHITE POWDER'>OFF-WHITE POWDER</option>
                          <option value='MULTICOLOR/WHITE'>MULTICOLOR/WHITE</option>
                          <option value='MULTICOLOR/BLACK'>MULTICOLOR/BLACK</option>
                          <option value='WET WHITE POWDER/ WET NPK '>WET WHITE POWDER/ WET NPK </option>
                          <option value='WET MULTICOLOR /MOSTLY WHITE POWDER'>WET MULTICOLOR /MOSTLY WHITE POWDER</option>
                          <option value='WET MULTICOLOR/MOSTLY BLACK POWDER'>WET MULTICOLOR/MOSTLY BLACK POWDER</option>
                          <option value='UREA'>UREA</option>
                          <option value='GSOA'>GSOA</option>
                          <option value='SWEEPINGS (MAKOPE'>SWEEPINGS (MAKOPE</option>
                          <option value='C S OA'>C S OA</option>
                          <option value='DAP'>DAP</option>
                          <option value='GAS  +UREA  LUMPS +POWDER'>GAS  +UREA  LUMPS +POWDER</option>
                          <option value='CAN'>CAN</option>
                          <option value='90% GRANULAR SWEEPING'>90% GRANULAR SWEEPING</option>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="approx_age" class="col-sm-3 control-label">Approximate Age:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <select name='approx_age' class='form-control input-height' required>
                          <option value='1 Months'>1 Months</option>
                          <option value='2 Months'>2 Months</option>
                          <option value='3 Months'>3 Months</option>
                          <option value='4 Months'>4 Months</option>
                          <option value='5 Months'>5 Months</option>
                          <option value='6 Months'>6 Months</option>
                          <option value='7 Months'>7 Months</option>
                          <option value='8 Months'>8 Months</option>
                          <option value='9 Months'>9 Months</option>
                          <option value='10 Months'>10 Months</option>
                          <option value='11 Months'>11 Months</option>
                          <option value='1 Year'>1 Year</option>
                          <option value='2 Years'>2 Years</option>
                          <option value='3-4 Years'>3-4 Years</option>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="horizontalFormEmail" class="col-sm-3 control-label">Origin
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <select name='origin' class='form-control input-height' required>
                          <option value='WAGONS'>WAGONS</option>
                          <option value='PRODUCTION/STOCK FOR PROCESSING'>PRODUCTION/STOCK FOR PROCESSING</option>
                          <option value='STOCKS FO PROCESSING'>STOCKS FO PROCESSING</option>
                          <option value='PRODUCTION'>PRODUCTION</option>
                        </select>
                        <div class="result"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="approx_tonnage" class="col-sm-3 control-label">Approximate Total Tonnes:
                      <span class="required"> * </span>
                    </label>
                    <div class="col-md-3">
                      <div class="search-box">
                        <input type="text" class="form-control input-height" name="approx_tonnage"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-actions">
                    <div class="row">
                      <div class="offset-md-3 col-md-9">
                        <button type="submit" class="btn btn-info">Proceed >></button>
                        <a href="batch_add.php"><button type="button" class="btn btn-default">Cancel</button></a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("includes/footer.php"); ?>
  </div>
  <?php include("includes/javascript_includes.php"); ?>
  </body>

  </html>