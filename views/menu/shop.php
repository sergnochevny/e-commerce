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
<div class="shop__sidebar bar_filter">
  <nav>
    <ul class="shop__sidebar-list">
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="0" title="Filter by Manufacturer"
           href="<?= App::$app->router()->UrlTo('manufacturers/view', null, 'manufacturer') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 1)) ? ' active' : '' ?>">Manufacturer</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="1" title="Filter by Type/Category"
           href="<?= App::$app->router()->UrlTo('categories/view', null, 'type') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 2)) ? ' active' : '' ?>">Type</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="2" title="Filter by Pattern"
           href="<?= App::$app->router()->UrlTo('patterns/view', null, 'pattern') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 3)) ? ' active' : '' ?>">Pattern</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="3" title="Filter by Color"
           href="<?= App::$app->router()->UrlTo('colors/view', null, 'color') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 4)) ? ' active' : '' ?>">Color</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="4" title="Filter by Price"
           href="<?= App::$app->router()->UrlTo('prices/view', null, 'price') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 5)) ? ' active' : '' ?>">Price</a>
      </li>
    </ul>
  </nav>
</div>
<!-- filter end -->

