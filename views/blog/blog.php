<?php

use app\core\App;

?>
<?php $this->registerCSSFile(App::$app->router()->UrlTo('css/blog_common.min.css')); ?>

<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="content" class="col-xs-12 main-content-inner box" role="main">
    <?= $list; ?>
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
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/formsimple/edit.min.js'), 4); ?>
