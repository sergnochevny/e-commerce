<div class="shop__sidebar">
  <nav>
    <ul class="shop__sidebar-list">
      <li class="shop__sidebar-item"><a href="<?= _A_::$app->router()->UrlTo('manufacturers/view', [], 'manufacturer')?>" class="shop__sidebar-link">Manufacturer</a></li>
      <li class="shop__sidebar-item"><a href="<?= _A_::$app->router()->UrlTo('categories/view', [], 'type')?>" class="shop__sidebar-link">Type</a></li>
      <li class="shop__sidebar-item"><a href="<?= _A_::$app->router()->UrlTo('patterns/view', [], 'pattern')?>" class="shop__sidebar-link">Pattern</a></li>
      <li class="shop__sidebar-item"><a href="<?= _A_::$app->router()->UrlTo('colours/view', [], 'colour')?>" class="shop__sidebar-link">Colour</a></li>
      <li class="shop__sidebar-item"><a href="#" class="shop__sidebar-link">Price</a></li>
      <li class="shop__sidebar-item"><a href="#" class="shop__sidebar-link">Specially</a></li>
    </ul>
  </nav>
</div>
