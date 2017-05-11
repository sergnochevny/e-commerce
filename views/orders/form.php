<form id="edit_form" action="<?= $action ?>" data-title="<?= $form_title ?>" style="margin-bottom: 0">
  <div class="row">
    <div class="col-xs-4">
      <div class="form-row">
        <input type="text"
               id="track_code"
               style="width: 100%"
               value="<?= $data['track_code'] ?>"
               name="track_code"
               class="input-text"
               placeholder="Add track code">
      </div>
    </div>
    <div class="col-xs-4">
      <div class="form-row">
        <select id="status_select" style="width: 100%; margin: 0; padding: 6px 10px" size="1" name="status">
          <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>In process</option>
          <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Completed</option>
        </select>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="form-row">
        <input type="text"
               style="width: 100%; padding-left: 15px; padding-right: 15px"
               name="end_date"
               id="dateFrom"
               value="<?= !is_null($data['end_date']) ? date("m/d/Y", strtotime($data['end_date'])) : '' ?>"
               placeholder="Chose end date"
               class="input-text ">
      </div>
    </div>
  </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.min.js'); ?>' type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/orders/form.min.js'); ?>' type="text/javascript"></script>