<?php

use app\core\App;

?>
<div class="footer-credit">
  <div class="container inner-offset-top half-outer-offset-bottom">
    <div class="copyright">
      <div class="row">
        <div class="footer-credit-left col-md-6 col-xs-12">
          <p><?= date('Y') ?> Copyright &copy; ILuvFabrix</p>
        </div>
        <div class="footer-credit-right col-md-6 col-xs-12">
          <p><img src="<?= App::$app->router()->UrlTo('images/payment.png'); ?>" alt=""></p>
        </div>
      </div>
    </div>
  </div>
</div>