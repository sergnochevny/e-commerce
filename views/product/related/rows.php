<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="product-item product-related" data-pid="<?= $row['pid'];?>">
      <div class="product-inner">
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <input type="hidden" name="related[]" value="<?= $row['pid'];?>" />
        </figure>
        <div class="product-description">
          <div class="product-name"><?= $row['pname']; ?></div>
        </div>
        <a data-related_delete href="delete" class="remove-related-product"><i class="fa fa-times" aria-hidden="true"></i></a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
