<div class="row">
  <?php if(isset($warning)) { ?>
    <div class="col-xs-12 alert-success danger" style="display: none;">
      <?php
        foreach($warning as $msg) {
          echo $msg . '<br/>';
        }
      ?>
    </div>
  <?php }
    if(isset($error)) { ?>
      <div class="col-xs-12 alert-danger danger" style="display: none;">
        <?php foreach($error as $msg) {
          echo $msg . '<br/>';
        } ?>
      </div>
    <?php } ?>
</div>
<form action="<?= $action ?>" id="edit_form" method="post">
  <div class="col-xs-4">
    <div class="row">
      <input type="text" id="track_code" style="width: 100%"
             value="<?= $data['track_code'] ?>" name="track_code"
             class="col-lg-12" placeholder="Add track code">
    </div>
  </div>
  <div class="col-xs-4">

    <select id="status_select" style="width: 100%; margin: 0; padding: 6px 10px" size="1" name="status">
      <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>In process</option>
      <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Completed</option>
    </select>

  </div>
  <div class="col-xs-3" style="padding-left: 0">
    <input type="text" style="width: 100%; padding-left: 15px; padding-right: 15px"
           name="end_date" id="dateFrom"
           value="<?= !is_null($data['end_date']) ? date("m/d/Y", strtotime($order['end_date'])) : '' ?>"
           placeholder="Chose end date"
           class="input-text ">

  </div>
  <div class="col-xs-1 text-right" style="padding: 0 !important;">
    <button title="Search"
            style="height: 34px;"
            class="btn small"
            type="button"
            id="edit_order_info"
            name="edit_order_info">
      <b>Save</b>
    </button>
  </div>

</form>