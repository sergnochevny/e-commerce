<div id="cart_main_container" class="container">
  <?= isset($content) ? $content : ''; ?>
</div>
<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
  <div class="fcheck"></div>
  <a class="close" title="close">&times;</a>

  <div class="b_cap_cod_main">
    <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
    <br/>
    <div class="text-center" style="width: 100%">
      <a id="confirm_action">
        <input type="button" value="Yes confirm" class="button"/>
      </a>
      <a id="confirm_no">
        <input type="button" value="No" class="button"/>
      </a>
    </div>
  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/cart/container.js'); ?>' type="text/javascript"></script>

