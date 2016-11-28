<div class="col-xs-12 title hidden-sm hidden-xs">
  <div class="row">
    <b>Organize Fabrics by:</b>
  </div>
</div>
<div class="shop__sidebar">
  <nav>
    <ul class="shop__sidebar-list">
      <li class="shop__sidebar-item">
        <a data-waitloader data-index title="All Fabrics"
           href="<?= _A_::$app->router()->UrlTo('shop') ?>"
           class="shop__sidebar-link<?= (!isset($idx)) ? ' active' : '' ?>">All Fabrics</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="0" title="Manufacturer"
           href="<?= _A_::$app->router()->UrlTo('manufacturers/view', ['idx' => 0], 'manufacturer') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 0)) ? ' active' : '' ?>">Manufacturer</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="1" title="Type"
           href="<?= _A_::$app->router()->UrlTo('categories/view', ['idx' => 1], 'type') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 1)) ? ' active' : '' ?>">Type</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="2" title="Pattern"
           href="<?= _A_::$app->router()->UrlTo('patterns/view', ['idx' => 2], 'pattern') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 2)) ? ' active' : '' ?>">Pattern</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="3" title="Colour"
           href="<?= _A_::$app->router()->UrlTo('colours/view', ['idx' => 3], 'colour') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 3)) ? ' active' : '' ?>">Colour</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="4" title="Price"
           href="<?= _A_::$app->router()->UrlTo('prices/view', ['idx' => 4], 'price') ?>"
           class="shop__sidebar-link<?= (isset($idx) && ($idx == 4)) ? ' active' : '' ?>">Price</a>
      </li>
      <li class="shop__sidebar-item">
        <a data-waitloader data-index="5" title="Specials"
           href="<?= _A_::$app->router()->UrlTo('shop/specials', ['idx' => 5], 'specials') ?>"
           class="shop__sidebar-link">Specials</a>
      </li>
    </ul>
  </nav>
</div>

