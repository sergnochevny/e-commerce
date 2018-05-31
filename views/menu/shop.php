<?php

use app\core\App;

?>
<div class="shop__sidebar bar_menu">
  <nav>
    <ul class="shop__sidebar-list">
      <li class="shop__sidebar-item">
        <a data-waitloader data-index title="All Fabrics"
           href="<?= App::$app->router()->UrlTo('shop') ?>"
           class="shop__sidebar-link<?= (!isset($idx) || ($idx == 0)) ? ' active' : '' ?>">All Fabrics</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="5" title="Specials Fabrics"
           href="<?= App::$app->router()->UrlTo('shop/specials', null, 'specials') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 6)) ? ' active' : '' ?>">Specials</a>
      </li>
    </ul>
  </nav>
</div>

<!-- filter begin -->
<div class="col-xs-12 title">
  <div class="row no-offset-right outer-offset-top half-outer-offset-bottom">
    <b>Organize Fabrics by:</b>
  </div>
</div>
<div class="clear"></div>
<div class="shop__sidebar bar_filter" data-filter-storage='<?= json_encode(!empty($filter) ? $filter : []); ?>'>
  <nav>
    <ul class="shop__sidebar-list shop__sidebar-w-filter">
      <?php $prm = "e.id"; ?>
      <li class="shop__sidebar-item" data-filter-prm="<?= $prm; ?>">
        <a data-waitloader data-index="0" title="Filter by Manufacturer"
           href="<?= App::$app->router()->UrlTo('manufacturers/view', null, 'manufacturer') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 1)) ? ' active' : '' ?>">Manufacturer</a>
        <a title="Clear Filter by Manufacturer" data-link-clear-filter
           href="<?= App::$app->router()->UrlTo('shop/filter') ?>"
          <?= !empty($filter[$prm]) ? '' : 'disabled' ?>
           class="shop__sidebar-link-filter-clear">
          <i class="fa fa-filter"></i>
        </a>
      </li>
      <?php $prm = "b.cid"; ?>
      <li class="shop__sidebar-item" data-filter-prm="<?= $prm; ?>">
        <a data-waitloader data-index="1" title="Filter by Type/Category"
           href="<?= App::$app->router()->UrlTo('categories/view', null, 'type') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 2)) ? ' active' : '' ?>">Type</a>
        <a title="Clear Filter by Type" data-link-clear-filter
           href="<?= App::$app->router()->UrlTo('shop/filter') ?>"
          <?= !empty($filter[$prm]) ? '' : 'disabled' ?>
           class="shop__sidebar-link-filter-clear">
          <i class="fa fa-filter"></i>
        </a>
      </li>
      <?php $prm = "d.id"; ?>
      <li class="shop__sidebar-item" data-filter-prm="<?= $prm; ?>">
        <a data-waitloader data-index="2" title="Filter by Pattern"
           href="<?= App::$app->router()->UrlTo('patterns/view', null, 'pattern') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 3)) ? ' active' : '' ?>">Pattern</a>
        <a title="Clear Filter by Pattern" data-link-clear-filter
           href="<?= App::$app->router()->UrlTo('shop/filter') ?>"
          <?= !empty($filter[$prm]) ? '' : 'disabled' ?>
           class="shop__sidebar-link-filter-clear">
          <i class="fa fa-filter"></i>
        </a>
      </li>
      <?php $prm = "c.id"; ?>
      <li class="shop__sidebar-item" data-filter-prm="<?= $prm; ?>">
        <a data-waitloader data-index="3" title="Filter by Color"
           href="<?= App::$app->router()->UrlTo('colors/view', null, 'color') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 4)) ? ' active' : '' ?>">Color</a>
        <a title="Clear Filter by Color" data-link-clear-filter
           href="<?= App::$app->router()->UrlTo('shop/filter') ?>"
          <?= !empty($filter[$prm]) ? '' : 'disabled' ?>
           class="shop__sidebar-link-filter-clear">
          <i class="fa fa-filter"></i>
        </a>
      </li>
      <?php $prm = "a.priceyard"; ?>
      <li class="shop__sidebar-item" data-filter-prm="<?= $prm; ?>">
        <a data-waitloader data-index="4" title="Filter by Price"
           href="<?= App::$app->router()->UrlTo('prices/view', null, 'price') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 5)) ? ' active' : '' ?>">Price</a>
        <a title="Clear Filter by Price" data-link-clear-filter
           href="<?= App::$app->router()->UrlTo('shop/filter') ?>"
          <?= !empty($filter[$prm]) ? '' : 'disabled' ?>
           class="shop__sidebar-link-filter-clear">
          <i class="fa fa-filter"></i>
        </a>
      </li>
    </ul>
    <ul class="shop__sidebar-list">
      <li class="shop__sidebar-item shop__sidebar-buttons">
        <a data-waitloader title="Apply Filter" data-filter-apply
           href="<?= App::$app->router()->UrlTo('shop') ?>"
           class="shop__sidebar-link shop__sidebar-filter-apply"
          <?= empty($filter['active_filter']) ? 'disabled' : '' ?>>
          Apply
        </a>
        <a title="Reset Filter" data-filter-reset
           href="<?= App::$app->router()->UrlTo('shop/filter') ?>"
           class="shop__sidebar-link shop__sidebar-filter-reset"
          <?= empty($filter['active_filter']) ? 'disabled' : '' ?>>
          Reset
        </a>
      </li>
    </ul>
  </nav>
</div>
<!-- filter end -->

