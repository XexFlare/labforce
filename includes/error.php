<div class="col-md-12">
  <div class="card  card-topline-green">
    <div class="card-body no-padding height-12">
      <div class="row">
        <div class="noti-information notification-menu">
          <div class="notification-list">
            <h4>
              <center>
                <font color="#FF0000"><?php echo $title ?? 'System Error!'; ?></font>
              </center>
            </h4>
            <font color="red"><i class="fa fa-times"></font></i>
            <?php if ($message) {
              echo "<strong>$message</strong>";
            } else {
              echo $add; ?>
              <strong> Action failure! Please try again.</strong>
            <?php } ?>
            <?php if (!isset($hideBack) || !$hideBack) { ?>
              <strong>
                <a class="single-mail text-center view-all" href="javascript:history.back();">GO BACK</a>
              </strong>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>