<?php

use app\core\App;

?>
<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 col-md-20-prc">
    <div class="row w_search">
      <?= isset($shop_menu) ? $shop_menu : ''; ?>
    </div>
  </div>
  <div class="col-xs-12 col-md-80-prc main-content-inner-side box" role="main">
    <div id="content" class="content">
      <?=$list;?>
    </div>
  </div>
</div>
<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
  <div class="fcheck"></div>
  <a class="close" href="javascript:void(0)" title="close"><i class="fa fa-times" aria-hidden="true"></i></a>

  <div class="b_cap_cod_main">
    <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
    <br/>
    <div class="text-center" style="width: 100%">
      <input id="confirm_action" type="button" value="Yes confirm" class="button"/>
      <input id="confirm_no" type="button" value="No" class="button"/>
    </div>
  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/shop/shop.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/simple/edit.min.js'), 4); ?>
	
    

