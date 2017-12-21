<form id="edit_form" action="<?= $action ?>" method="post"  data-title="<?=$form_title?>">
  <div class="row">
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Manufacturer Name:</strong></label>
        <input type="text" name="manufacturer" value="<?= $data['manufacturer'] ?>" class="input-text ">
      </div>
    </div>
  </div>
</form>
<script src='<?= App::$app->router()->UrlTo('js/simple/form.min.js'); ?>' type="text/javascript"></script>