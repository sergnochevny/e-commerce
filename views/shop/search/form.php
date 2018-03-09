<?php

use app\core\App;
use classes\helpers\AdminHelper;

/**
 * @var \app\core\Template $this
 */
?>
<form action="<?= $action ?>" method="post" data-search data-filter-additional>
  <?php if(AdminHelper::is_logged()): ?>
    <div class="row">
      <div class="col-xs-12 panel panel-default search-panel">
        <div class="panel-heading">
          <div class="search-container-title">
            <div class="row">
              <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
              <div class="h4 col-xs-10 search-result-list comment-text">
                <?php if(isset($search['a.pname'])): ?>
                  <div class="label label-search-info">Name Like: <?= $search['a.pname'] ?></div>
                <?php endif; ?>
                <?php if(isset($search['a.pnumber'])): ?>
                  <div class="label label-search-info">Product number Like: <?= $search['a.pnumber'] ?></div>
                <?php endif; ?>
                <?php if(isset($search['b.cid'])): ?>
                  <div class="label label-search-info">Category: <?= $search['categories'][$search['b.cid']] ?></div>
                <?php endif; ?>
                <?php if(isset($search['c.id'])): ?>
                  <div class="label label-search-info">Color: <?= $search['colors'][$search['c.id']] ?></div>
                <?php endif; ?>
                <?php if(isset($search['d.id'])): ?>
                  <div class="label label-search-info">Pattern: <?= $search['patterns'][$search['d.id']] ?></div>
                <?php endif; ?>
                <?php if(isset($search['e.id'])): ?>
                  <div class="label label-search-info">Manufacturer: <?= $search['manufacturers'][$search['e.id']] ?>
                  </div>
                <?php endif; ?>
                <?php if(isset($search['a.piece'])): ?>
                  <div class="label label-search-info">
                    Piece: <?= isset($search['a.piece']) && $search['a.piece'] == 1 ? 'YES' : 'NO' ?></div>
                <?php endif; ?>
                <?= isset($search['a.priceyard']['from']) && !empty((float)$search['a.priceyard']['from']) ? '<div class="label label-search-info">Price from: ' . $search['a.priceyard']['from'] . '</div>' : '' ?>
                <?= isset($search['a.priceyard']['to']) && !empty((float)$search['a.priceyard']['to']) ? '<div class="label label-search-info">Price to: ' . $search['a.priceyard']['to'] . '</div>' : '' ?>
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
            <div class="col-sm-6">
              <div class="form-row">
                <label>Product Name:</label>
                <input type="text" class="input-text" placeholder="Like ..." name="search[a.pname]"
                       value="<?= isset($search['a.pname']) ? $search['a.pname'] : '' ?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-row">
                <label>Product number:</label>
                <input type="text" name="search[a.pnumber]"
                       value="<?= isset($search['a.pnumber']) ? $search['a.pnumber'] : ''; ?>" class="input-text"
                       placeholder="e.g. abc888999">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-row">
                <label <?= isset($search['hidden']['b.cid']) ? 'disabled' : '' ?>>Specific category</label>
                <select name="search[b.cid]" <?= isset($search['hidden']['b.cid']) ? 'disabled' : '' ?>>
                  <option value="" <?= isset($search['b.cid']) ? '' : 'selected' ?>>Any</option>
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
            <div class="col-sm-6">
              <div class="form-row">
                <label <?= isset($search['hidden']['e.id']) ? 'disabled' : '' ?>>Specific manufacturer</label>
                <select name="search[e.id]" <?= isset($search['hidden']['e.id']) ? 'disabled' : '' ?>>
                  <option value="" <?= isset($search['e.id']) ? '' : 'selected' ?>>Any</option>
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
          <div class="row">
            <div class="col-sm-4">
              <div class="form-row">
                <label <?= isset($search['hidden']['c.id']) ? 'disabled' : '' ?>>In specific color</label>
                <select name="search[c.id]" <?= isset($search['hidden']['c.id']) ? 'disabled' : '' ?>>
                  <option value="" <?= isset($search['c.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['colors'])):
                    foreach($search['colors'] as $key => $val):?>
                      <option
                        value="<?= $key ?>" <?= (isset($search['c.id']) && ($key == $search['c.id'])) ? 'selected' : '' ?>>
                        <?= $val ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-row">
                <label <?= isset($search['hidden']['d.id']) ? 'disabled' : '' ?>>With specific pattern</label>
                <select name="search[d.id]" <?= isset($search['hidden']['d.id']) ? 'disabled' : '' ?>>
                  <option value="" <?= isset($search['d.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['patterns'])):
                    foreach($search['patterns'] as $key => $val):?>
                      <option
                        value="<?= $key ?>" <?= (isset($search['d.id']) && ($key == $search['d.id'])) ? 'selected' : '' ?>>
                        <?= $val ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-row">
                <label>Piece</label>
                <select name="search[a.piece]">
                  <option value="" <?= isset($search['a.piece']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.piece']) && $search['a.piece'] == 1 ? 'selected' : '' ?>>Yes
                  </option>
                  <option value="0" <?= isset($search['a.piece']) && $search['a.piece'] == 0 ? 'selected' : '' ?>>No
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="form-row">
                <label>Price ranges
                  from <?= isset($search['hidden']['a.priceyard']['from']) ? 'min = ' . number_format((float)$search['hidden']['a.priceyard']['from'], 2) : ''; ?> <?= isset($search['hidden']['a.priceyard']['to']) ? 'max = ' . number_format($search['hidden']['a.priceyard']['to'], 2) : ''; ?></label>
                <input
                  data-restrict
                  relation-max="#price-to"
                  min="<?= isset($search['hidden']['a.priceyard']['from']) ? $search['hidden']['a.priceyard']['from'] : 0; ?>"
                  max="<?= isset($search['hidden']['a.priceyard']['to']) ? $search['hidden']['a.priceyard']['to'] : 9999999; ?>"
                  data-inputmask="'alias': 'currency', 'prefix': '', 'rightAlign': 'false'"
                  type="text" class="input-text" id="price-from"
                  placeholder="Price ranges from"
                  name="search[a.priceyard][from]"
                  value="<?= isset($search['a.priceyard']['from']) ? $search['a.priceyard']['from'] : '' ?>">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-row">
                <label>Price ranges
                  to <?= isset($search['hidden']['a.priceyard']['from']) ? 'min = ' . number_format((float)$search['hidden']['a.priceyard']['from'], 2) : ''; ?> <?= isset($search['hidden']['a.priceyard']['to']) ? 'max = ' . number_format($search['hidden']['a.priceyard']['to'], 2) : ''; ?></label>
                <input
                  data-restrict
                  relation-min="#price-from"
                  min="<?= isset($search['hidden']['a.priceyard']['from']) ? $search['hidden']['a.priceyard']['from'] : 0; ?>"
                  max="<?= isset($search['hidden']['a.priceyard']['to']) ? $search['hidden']['a.priceyard']['to'] : 9999999; ?>"
                  data-inputmask="'alias': 'currency', 'prefix': '', 'rightAlign': 'false'"
                  type="text" class="input-text" id="price-to" placeholder="Price ranges to"
                  name="search[a.priceyard][to]"
                  value="<?= isset($search['a.priceyard']['to']) ? $search['a.priceyard']['to'] : '' ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="panel-footer hidden">
          <div class="row">
            <div class="col-sm-12">
              <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php else : ?>
    <div class="panel panel-default search-panel">
      <div class="panel-heading one-field">
        <div class="row">
          <div class="col-xs-10 col-sm-11">
            <div class="form-row">
              <input type="text" class="input-text" placeholder="Like ..." name="search[a.pname]"
                     value="<?= isset($search['a.pname']) ? $search['a.pname'] : '' ?>">
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
  <?php endif; ?>
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