<form id="edit_form" action="<?= $action ?>" method="post"  data-title="<?=$form_title?>">
  <div class="row">
    <div class="col-xs-12">
      <div class="form-row">
        <label class="required_field"><strong>Colour Name:</strong></label>
        <input type="text" name="colour" value="<?= $rows['colour'] ?>" class="input-text ">
      </div>
    </div>
  </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/form.min.js'); ?>' type="text/javascript"></script>