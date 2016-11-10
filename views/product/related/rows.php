<?php if(count($rows) > 0): ?>
  <?php foreach($rows as $row): ?>
    <div class="product-item" data-pid="<?= $row['pid'];?>">
      <div class="product-inner">
        <figure class="product-image-box" style="background-image:url(<?= $row['filename']; ?>)">
          <input type="hidden" name="related[]" value="<?= $row['pid'];?>" />
        </figure>
        <span class="product-category related-cat"><?= $row['pname']; ?><span class="opa"></span></span>
        <a data-related_delete href="delete" class="remove-related-product">&times;</a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
