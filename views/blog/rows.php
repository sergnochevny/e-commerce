<?php if(sizeof($rows) > 0): ?>
  <section class="just-posts-grid">
    <div class="just-post-row row">
      <?php foreach($rows as $row): ?>
        <?php $prms['id'] = $row['id'];
        if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>

        <div class="just-post col-xs-12 col-sm-6 col-md-4">
          <div class="just-post-image just-post-image-admin">
            <figure>
              <img src="<?= $row['img']; ?>" alt="">
              <figcaption>
                <a data-delete href="<?= _A_::$app->router()->UrlTo('blog/delete', $prms); ?>"
                   rel="nofollow"
                   class="button icon-delete add_to_cart_button   product_type_simple"></a>
                <a data-modify href="<?= _A_::$app->router()->UrlTo('blog/edit', $prms); ?>"
                   class="button product-button icon-modify">
                </a>
              </figcaption>
            </figure>
          </div>
          <div class="just-post-detail">
            <h3 class="post-title"><a
                href="<?= _A_::$app->router()->UrlTo('blog/edit', $prms); ?>"><?= isset($row['post_title']) ? $row['post_title'] : ''; ?></a>
            </h3>

            <div class="just-divider text-center line-yes icon-hide">
              <div style="background-color: #fff" class="divider-inner">
                <span class="post-date"><?= $row['post_date']; ?></span>
              </div>
            </div>
            <p class="text-justify"><span class="opa"></span><?= $row['description']; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="clear"></div>
    </div>
  </section>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>