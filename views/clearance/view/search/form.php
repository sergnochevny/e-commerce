<?php

use app\core\App;

?>
<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?php if(isset($search['a.pname'])): ?>
                <div class="label label-search-info">Like: <?= $search['a.pname'] ?></div>
              <?php endif; ?>
              <?= isset($search['active']) ? '<a data-search_reset href="javascript:void(0)" title="Reset search" class="reset"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>' : '' ?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-2x fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">

        <div class="row">
          <div class="col-xs-12">
            <div class="form-row">
              <label>Product/Type/Color/Pattern/Manufacturer Name or Product Number:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[a.pname]"
                     value="<?= isset($search['a.pname']) ? $search['a.pname'] : '' ?>">
            </div>
          </div>
        </div>
      </div>
      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-xs-12">
            <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  if(isset($search['hidden'])):
    foreach($search['hidden'] as $field_name => $field_value):?>
      <?php if(is_array($field_value)): ?>
        <input type="hidden" name="search[hidden][<?= $field_name ?>][from]" value="<?= $field_value['from'] ?>"/>
        <input type="hidden" name="search[hidden][<?= $field_name ?>][to]" value="<?= $field_value['to'] ?>"/>
      <?php else: ?>
        <input type="hidden" name="search[hidden][<?= $field_name ?>]" value="<?= $field_value ?>"/>
      <?php endif; ?>
    <?php
    endforeach;
  endif;
  ?>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/search.min.js'), 4, true);?>