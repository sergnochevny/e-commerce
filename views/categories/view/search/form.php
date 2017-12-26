<?php

use app\core\App;

?>
<form action="<?= $action ?>" method="post" data-search>
  <div class="panel panel-default search-panel">
    <div class="panel-heading one-field">
      <div class="row">
        <div class="col-xs-10 col-sm-11">
          <div class="form-row">
            <input type="text" class="input-text" placeholder="Category Name: Like ..." name="search[a.cname]"
                   value="<?= isset($search['a.cname']) ? $search['a.cname'] : '' ?>">
          </div>
        </div>
        <div class="col-xs-2 col-sm-1">
          <?php if(isset($search['active'])): ?>
            <a data-search_reset href="javascript:void(0)" title="Reset search" class="search-reset">
              <i class="fa fa-2x fa-times" aria-hidden="true"></i>
            </a>
          <?php endif; ?>
          <a data-search_submit class="pull-right search-button" href="<?= $action ?>">
            <i class="fa fa-3x fa-search"></i>
          </a>
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
<script src="<?= App::$app->router()->UrlTo('js/search.min.js'); ?>"></script>
