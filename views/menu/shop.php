<div class="col-xs-12 title hidden-sm hidden-xs">
  <div class="row no-offset-right outer-offset-bottom">
    <b>Organize Fabrics by</b>
  </div>
</div>
<div class="shop__sidebar">
  <nav>
    <ul class="shop__sidebar-list">
      <li class="shop__sidebar-item">
        <a data-waitloader data-index title="All Fabrics"
           href="<?= _A_::$app->router()->UrlTo('shop') ?>"
           class="shop__sidebar-link<?= (!isset($idx) || ($idx == 0)) ? ' active' : '' ?>">All Fabrics</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="0" title="Filter by Manufacturer"
           href="<?= _A_::$app->router()->UrlTo('manufacturers/view', null, 'manufacturer') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 1)) ? ' active' : '' ?>">Manufacturer</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="1" title="Filter by Type/Category"
           href="<?= _A_::$app->router()->UrlTo('categories/view', null, 'type') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 2)) ? ' active' : '' ?>">Type</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="2" title="Filter by Pattern"
           href="<?= _A_::$app->router()->UrlTo('patterns/view', null, 'pattern') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 3)) ? ' active' : '' ?>">Pattern</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="3" title="Filter by Color"
           href="<?= _A_::$app->router()->UrlTo('colors/view', null, 'color') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 4)) ? ' active' : '' ?>">Color</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="4" title="Filter by Price"
           href="<?= _A_::$app->router()->UrlTo('prices/view', null, 'price') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 5)) ? ' active' : '' ?>">Price</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="5" title="Specials Fabrics"
           href="<?= _A_::$app->router()->UrlTo('shop/specials', null, 'specials') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 6)) ? ' active' : '' ?>">Specials</a>
      </li>
    </ul>
  </nav>
</div>

