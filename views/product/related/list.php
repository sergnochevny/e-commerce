<div class="col-xs-12">
  <div class="row">
    <h3 class="section-title">Related Fabrics</h3>
  </div>
</div>
<div class="row related-selected">
  <div class="col-xs-12">
    <div class="col-xs-12">
      <div class="row" data-carousel data-related>
        <?php if(!empty($list)): ?>
          <?= $list; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="text-center">
      <a data-related-add class="button" style="width: 250px;">Add Related Fabrics</a>
    </div>
  </div>
</div>

<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
  <div class="fcheck"></div>
  <a class="close" title="close">&times;</a>

  <div class="b_cap_cod_main">
    <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
    <br/>
    <div class="text-center" style="width: 100%">
      <a id="confirm_action"><input type="button" value="Yes confirm" class="button"/></a>
      <a id="confirm_no"><input type="button" value="No" class="button"/></a></div>
  </div>
</div>

