<div class="col-md-12">
  <div class="card  card-topline-green">
    <div class="card-body no-padding height-12">
      <div class="row">
        <div class="noti-information notification-menu">
          <div class="notification-list">
            <h4>
              <center>
                <font color="#FF0000">Success!</font>
              </center>
            </h4>
            <font color="green"><i class="fa fa-check-square-o"></i></font>
            <span>Action successfully completed.</span>
            <?php if (isset($$hideBack) && !$hideBack) { ?>
              <strong>
                <a class="single-mail text-center view-all" href="javascript:history.back(-1);">GO BACK</a>
              </strong>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>