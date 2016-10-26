<?php
  if(!empty(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
  if((!empty(_A_::$app->get('cat')))) $prms['cat'] = _A_::$app->get('cat');

  if(count($rows) > 0): ?>
    <?php foreach($rows as $row): ?>
      <?php
      $prms = ['id' => $row[0]];
      $post_href = _A_::$app->router()->UrlTo('blog/view', $prms, $row['post_title']);
      ?>
      <div class="just-post col-xs-12 col-sm-6 col-md-4">
        <div class="just-post-image" style="background-image: url('<?= isset($row['img']) ? $row['img'] : ''; ?>');"><a
            class="hover-button" href="<?= $post_href ?>"></a></div>
        <div class="just-post-detail">
          <h3 class="post-title"><a
              href="<?= $post_href ?>"><?= isset($row['post_title']) ? $row['post_title'] : ''; ?></a>
          </h3>
          <div class="just-divider text-center line-yes icon-hide">
            <div class="divider-inner" style="background-color: #fff"><span
                class="post-date"><?= $row['post_date']; ?></span>
            </div>
          </div>
          <p><span class="opa"></span><?= $row['description']; ?></p>
          <a href="<?= $post_href; ?>" rel="bookmark" class="more-link">
            <i class="fa fa-arrow-circle-right"></i> Read more
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="col-sm-12 text-center offset-top">
      <h2 class="offset-top">No results found</h2>
    </div>
  <?php endif; ?>