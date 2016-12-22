<?php if(isset($rows['img'])) :?>
  <div id="post_img" data-post_img class="just-post-image"
       style="background-image: url('<?= $rows['img']; ?>');">
  </div>
  <input type="file" id="uploadfile" name="uploadfile"
         style="position: absolute; margin: -5px 0px 0px -175px; padding: 0px; width: 220px; height: 30px; font-size: 14px; opacity: 0; cursor: pointer; display: none; z-index: 2147483583; top: 401px; left: 759px;">
  <input type="hidden" name="img" value="<?= $rows['file_img']; ?>"/>
  <div id="status" class="col-sm-12 col-md-12 text-center red">
    <?= isset($rows['error']) ? $rows['error'] : '' ?>
  </div>
<?php endif; ?>
