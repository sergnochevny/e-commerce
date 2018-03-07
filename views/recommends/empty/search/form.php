<?php

use app\core\App;

?>
<form action="<?= $action ?>" method="post" data-search class="col-xs-12 recommends_filter">
  <div class="row">
    <div class="col-xs-12 annotation">
      <div class="form-row">
        <p>
          Based on the information you provide, we can give you some fabric recommendations. Simply fill out the form
          with as many or few options as you wish, and we will search our database for fabrics matching the criteria you
          have provided.
        </p>
        <p>
          iLuvFabrix values your feedback. Please
          <a data-waitloader href="<?= App::$app->router()->UrlTo('contact'); ?>">contact us</a>
          with any suggestions or comments on how this feature works.
        </p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="row">
        <div class="form-row">
          <label>Select A Type:</label>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="row">
        <div class="form-row">
          <select name="search[b.cid]">
            <option value="" <?= isset($search['b.cid']) ? '' : 'selected' ?>>No Preference</option>
            <?php if(isset($search['categories'])):
              foreach($search['categories'] as $key => $val): ?>
                <option
                  value="<?= $key ?>" <?= (isset($search['b.cid']) && ($key == $search['b.cid'])) ? 'selected' : '' ?>>
                  <?= $val ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="row">
        <div class="form-row">
          <label>Select A Manufacturer:</label>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="row">
        <div class="form-row">
          <select name="search[e.id]">
            <option value="" <?= isset($search['e.id']) ? '' : 'selected' ?>>No Preference</option>
            <?php if(isset($search['manufacturers'])):
              foreach($search['manufacturers'] as $key => $val):?>
                <option
                  value="<?= $key ?>" <?= (isset($search['e.id']) && ($key == $search['e.id'])) ? 'selected' : '' ?>>
                  <?= $val ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="row">
        <div class="form-row">
          <label>Select Colour Preferences:</label>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="row">
        <div class="filter_select_panel row form-row">
          <div class="col-xs-12 select_panel">
            <?php if(isset($search['colors'])): ?>
              <ul class="filter_sel sel_item">
                <?php foreach($search['colors'] as $key => $val): ?>
                  <li class="select_item">
                    <div class="col-xs-12">
                      <div class="row">
                        <label>
                          <input name="search[c.id][]" type="checkbox"
                                 value="<?= $key ?>" <?= (!empty($search['c.id']) && is_array($search['c.id']) && in_array($key, $search['c.id'])) ? 'checked' : '' ?>>
                          <?= $val; ?>
                        </label>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="row">
        <div class="form-row">
          <label>Select Pattern Preferences:</label>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="row">
        <div class="filter_select_panel row form-row">
          <div class="col-xs-12 select_panel">
            <?php if(isset($search['patterns'])): ?>
              <ul class="filter_sel sel_item">
                <?php foreach($search['patterns'] as $key => $val): ?>
                  <li class="select_item">
                    <div class="col-xs-12">
                      <div class="row">
                        <label>
                          <input name="search[d.id][]" type="checkbox"
                                 value="<?= $key ?>" <?= (!empty($search['d.id']) && is_array($search['d.id']) && in_array($key, $search['d.id'])) ? 'checked' : '' ?>>
                          <?= $val; ?>
                        </label>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="row">
        <div class="form-row">
          <label>Select A Price Range:</label>
        </div>
      </div>
    </div>
    <div class="col-sm-8">
      <div class="row">
        <div class="form-row">
          <select name="search[a.priceyard]">
            <option value="" <?= isset($search['a.priceyard']) ? '' : 'selected' ?>>Display All</option>
            <?php if(isset($search['prices'])):
              foreach($search['prices'] as $key => $val):?>
                <option
                  value="<?= $key ?>" <?= (isset($search['a.priceyard']) && ($key == $search['a.priceyard'])) ? 'selected' : '' ?>>
                  <?= $val ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 text-center">
        <div class="form-row">
          <a data-search_submit class="button text-capitalize" href="<?= $action ?>">Get My Recommendations</a>
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
  if(isset($search['firstpage'])):?>
    <input type="hidden" name="search[firstpage]" value="<?= $search['firstpage'] ?>"/>
  <?php endif; ?>
</form>

<?php
$this->registerJSFile(App::$app->router()->UrlTo('js/formsimple/list.min.js'), 4);
$this->registerJSFile(App::$app->router()->UrlTo('js/select.ui.min.js'), 4);
?>
