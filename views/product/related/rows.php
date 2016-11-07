<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="product-item">
      <div class="product-inner">
        <?php
          $url_prms['pid'] = $row['pid'];
          $href = _A_::$app->router()->UrlTo('related/delete', $url_prms);
        ?>
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <input type="hidden" name="related[]" value="<?= $row['pid'];?>" />
        </figure>
        <span class="product-category"><?= $row['pname']; ?></span>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
