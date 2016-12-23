<?php if(count($data) > 0): ?>
  <?php foreach($data as $row): ?>
    <img id="product_img_holder"
         data-id="<?= $row['pid']; ?>"
         data-detail_url="<?= _A_::$app->router()->UrlTo('shop/product', ['pid' => $row['pid'], 'back' => 'matches'], $row['pname'], ['cat', 'mnf', 'ptrn', 'clr', 'prc']); ?>"
         data-delete_url="<?= _A_::$app->router()->UrlTo('matches/delete', ['pid' => $row['pid']]); ?>"
         src="<?= $row['img']; ?>"
         style="width: 200px; top: <?= $row['top'] ?>%; left: <?= $row['left'] ?>%;"/>
  <?php endforeach; ?>
<?php endif; ?>