<div class="row">
  <div class="col-md-12 col-list_categories">
    <p class="woocommerce-result-count">
      CATEGORIES
    </p>
    <div class="list_categories">
      <?php foreach($items as $item): ?>
        <?php $href = _A_::$app->router()->UrlTo('shop', ['cat' => $item['cid']], $item['cname']); ?>
        <div class="list_category_item">
          <a title="<?= $name; ?>" class="shop_category" href="<?= $href; ?>"><?= $item['cname']; ?></a>
        </div>
      <? endforeach; ?>
    </div>
  </div>
</div>
