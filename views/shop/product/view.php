<?php

use app\core\App;
use controllers\ControllerInfo;
use controllers\ControllerRelated;

$pid = $data['pid'];
$ahref = 'mailto:' . App::$app->keyStorage()->system_info_email . '?subject=' . rawurlencode($data['sdesc'] . ' ' . $data['pnumber']);
$mhref = App::$app->router()->UrlTo('matches/add', ['pid' => $pid]);

$controller_related = new ControllerRelated($this->controller->get_main());
$related_view = $controller_related->view(false, false, $pid);
$controller_info = new ControllerInfo($this->controller->get_main());
$controller_info->scenario('product');
$info_view = $controller_info->view(false, false, true);
?>

<?php $this->registerCSSFile(App::$app->router()->UrlTo('css/shop_common.min.css')); ?>

<div id="content" class="container product_view inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-sm-2 back_button_container">
          <div class="row">
            <a data-waitloader id="back_url" title="Back to Products' List" href="<?= $back_url; ?>"
               class="button back_button">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
              Back
            </a>
          </div>
          <div class="row prev_next_buttons visible-xs">
            <?php if(!empty($prev_next['prev'])): ?>
              <a data-waitloader href="<?= $prev_next['prev']['url']; ?>"
                 title="<?= $prev_next['prev']['title']; ?>"
                 class="button prev_button">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                Prev.
              </a>
            <?php endif; ?>
            <?php if(!empty($prev_next['next'])): ?>
              <a data-waitloader href="<?= $prev_next['next']['url']; ?>"
                 title="<?= $prev_next['next']['title']; ?>"
                 class="button next_button">
                Next
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-xs-12 col-sm-7 text-center">
          <h3 style="margin-bottom: 30px"
              class="product_title product_title_style entry-title"><?= $data['pname']; ?></h3>
        </div>
        <div class="visible-sm visible-md visible-lg col-sm-3 back_button_container">
          <div class="row text-right">
            <?php if(!empty($prev_next['prev'])): ?>
              <a data-waitloader href="<?= $prev_next['prev']['url']; ?>"
                 title="<?= $prev_next['prev']['title']; ?>"
                 class="button prev_button">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                Prev.
              </a>
            <?php endif; ?>
            <?php if(!empty($prev_next['next'])): ?>
              <a data-waitloader href="<?= $prev_next['next']['url']; ?>"
                 title="<?= $prev_next['next']['title']; ?>"
                 class="button next_button">
                Next
                <i class="fa fa-angle-right" aria-hidden="true"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row">

        <div class="col-xs-12 col-md-6">
          <div class="row">
            <a <?= isset($data['filename1']) ? 'href="' . $data['filename1'] . '"' : ''; ?>
              itemprop="image" class="product-main-image zoom" title="Product Main Image"
              <?= isset($data['filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
              <?= isset($data['filename1']) ? 'data-img = "' . $data['filename1'] . '"' : '' ?>>
              <img width="100%"
                   src="<?= isset($data['filename1']) ? $data['filename1'] : $data['filename']; ?>"
                   class="attachment-shop_single size-shop_single wp-post-image" alt=""/>
            </a>
            <div class="thumbnails col-sm-12">
              <div class="row">
                <?php if(!empty($data['image2']) || !empty($data['image3']) || !empty($data['image4']) || !empty($data['image5'])) : ?>
                  <p class="more-images">MORE IMAGES OF THIS FABRIC</p>
                  <div class="row">
                    <?php if(!empty($data['image2'])) : ?>
                      <a <?= isset($data['img2_filename1']) ? 'href="' . $data['img2_filename1'] . '"' : ''; ?>
                        class="col-xs-6 zoom"
                        <?= isset($data['img2_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img2_filename1']) ? 'data-img = "' . $data['img2_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img2_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt=""/>
                      </a>
                    <?php endif;
                    if(!empty($data['image3'])) : ?>
                      <a <?= isset($data['img3_filename1']) ? 'href="' . $data['img3_filename1'] . '"' : ''; ?>
                        class="col-xs-6 zoom"
                        <?= isset($data['img3_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img3_filename1']) ? 'data-img = "' . $data['img3_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img3_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt=""/>
                      </a>
                    <?php endif;
                    if(!empty($data['image4'])) : ?>
                      <a <?= isset($data['img4_filename1']) ? 'href="' . $data['img4_filename1'] . '"' : ''; ?>
                        class="zoom col-xs-6"
                        <?= isset($data['img4_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img4_filename1']) ? 'data-img = "' . $data['img4_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img4_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt=""/>
                      </a>
                    <?php endif;
                    if(!empty($data['image5'])) : ?>
                      <a <?= isset($data['img5_filename1']) ? 'href="' . $data['img5_filename1'] . '"' : ''; ?>
                        class="zoom col-xs-6"
                        <?= isset($data['img5_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img5_filename1']) ? 'data-img = "' . $data['img5_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img5_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt=""/>
                      </a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-6 summary entry-summary">
          <div class="row">
            <div class="product_meta product_details sm-half-xs-full">
              <span class="h3">Details</span>
              <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                  <td class="row_title"><b>Name</b>:</td>
                  <td><?= $data['pname']; ?></td>
                </tr>
                <tr>
                  <td class="row_title"><b>Product #</b>:</td>
                  <td><?= $data['pnumber']; ?></td>
                </tr>
                <?php if(($data['piece'] == 1) && ($data['inventory'] > 0)) : ?>
                  <tr>
                    <td class="row_title"><b>Dimensions</b>:</td>
                    <td><?= $data['dimensions']; ?></td>
                  </tr>
                <?php else : ?>
                  <tr>
                    <td class="row_title"><b>Width</b>:</td>
                    <td><?= $data['width']; ?></td>
                  </tr>
                  <tr style="<?= ($data['inventory'] > 0) ? '' : 'color: red;'; ?>">
                    <td class="row_title"><b>Avail. yardage</b>:</td>
                    <td><?= $data['inventory']; ?></td>
                  </tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <?php if(!empty($discount_info)): ?>
              <div class="col-xs-12 product_details_discount">
                <div class="row">
                  <table class="table table-bordered table-striped red">
                    <tbody>
                    <?= $discount_info; ?>
                    </tbody>
                  </table>
                  <div class="quantity"></div>
                </div>
              </div>
            <?php endif; ?>
            <div class="col-xs-12">
              <div class="row">
                <div class="product-detail-view-actions" aria-label="...">
                  <div class="row button-group-product">
                    <?php if($data['inventory'] > 0) : ?>
                      <div class="button-small-width">
                        <a class="button col-xs-12" id="add_cart"
                           href="<?= App::$app->router()->UrlTo('cart/add', ['pid' => $pid]) ?>"
                          <?= (isset($data['in_cart']) && $data['in_cart']) ? 'style="display: none;"' : ''; ?>>
                          Add to Cart
                        </a>
                        <a data-waitloader class="button col-xs-12" id="view_cart"
                           href="<?= App::$app->router()->UrlTo('cart') ?>"
                          <?= (isset($data['in_cart']) && $data['in_cart']) ? '' : 'style="display: none;"'; ?>>
                          Cart
                        </a>
                      </div>
                    <?php endif; ?>
                    <?php if($data['inventory'] > 0 && $allowed_samples) : ?>
                      <div class="button-small-width">
                        <a id="add_samples_cart" class="button col-xs-12"
                           href="<?= App::$app->router()->UrlTo('cart/add_samples', ['pid' => $pid]) ?>"
                          <?= (isset($data['in_samples_cart']) && $data['in_samples_cart']) ? 'style="display: none;"' : ''; ?>>
                          Order a Sample
                        </a>
                      </div>
                    <?php endif; ?>

                    <div class="button-small-width">
                      <a data-waitloader class="button col-xs-12" id="view_favorites"
                         style="<?= (isset($in_favorites) && $in_favorites) ? '' : 'display:none'; ?>"
                         data-pid="<?= $data['pid'] ?>"
                         href="<?= App::$app->router()->UrlTo('favorites'); ?>">
                        My Favorites
                      </a>

                      <a class="button col-xs-12" id="add_favorites"
                         style="<?= (isset($in_favorites) && $in_favorites) ? 'display:none' : ''; ?>"
                         data-pid="<?= $data['pid'] ?>"
                         href="<?= App::$app->router()->UrlTo('favorites/add'); ?>">
                        Add to Favorites
                      </a>
                    </div>

                    <?php if($data['img1_exists']) : ?>
                      <div class="button-small-width">
                        <a class="button col-xs-12" id="add_matches"
                           href="<?= $mhref; ?>" <?= (isset($data['in_matches']) && $data['in_matches']) ? 'style="display: none;"' : ''; ?>>
                          Add to Matches
                        </a>
                        <a data-waitloader class="button col-xs-12" id="view_matches"
                           href="<?= App::$app->router()->UrlTo('matches'); ?>"
                          <?= (isset($data['in_matches']) && $data['in_matches']) ? '' : 'style="display: none;"'; ?>>
                          Matches
                        </a>
                      </div>
                    <?php endif; ?>

                    <div class="button-small-width">
                      <a class="button col-xs-12" href="<?= $ahref; ?>">
                        Ask a Question
                      </a>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 inner-offset-vertical-top">
              <div class="row">
                <div class="panel panel-default panel-body">
                  <div class="col-xs-12">
                    <div class="row">
                      <p class="text-justify"><?= $data['ldesc']; ?></p>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="row">
                      <hr>
                    </div>
                  </div>
                  <?php if(($data['sys_hide_price'] == 0 && $data['hideprice'] == 0) || empty($discount_info)): ?>
                    <div class="col-xs-12">
                      <div class="row">
                        <p class="price">Price:
                          <ins>
                            <span class="amount"> <?= $data['format_price']; ?></span>
                          </ins>
                        </p>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <?php if(!empty($related_view)): ?>
      <div class="col-xs-12">
        <div class="row related" data-related>
          <?= $related_view; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if(!empty($info_view)): ?>
      <div class="col-xs-12">
        <div class="row">
          <div>
            <?= $info_view; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/shop/product.min.js'), 4); ?>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/load.min.js'), 4); ?>
