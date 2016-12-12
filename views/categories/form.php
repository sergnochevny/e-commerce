<form id="edit_form" action="<?= $action ?>" method="post"  data-title="<?=$form_title?>">
    <div class="row">
      <div class="col-md-8 col-xs-12">
        <div class="form-row">
          <label class="required_field"><strong>Category:</strong></label>
          <input type="text" name="cname" value="<?= $data['cname'] ?>" class="input-text ">
          <small style="color: #999">NOTE: the title cannot be more than 28 characters.</small>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <div class="form-row">
          <label class="required_field"><strong>Display order:</strong></label>
          <input name="displayorder" type="number" value="<?= $data['displayorder'] ?>" class="input-text ">
        </div>
      </div>
    </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.min.js'); ?>' type="text/javascript"></script>