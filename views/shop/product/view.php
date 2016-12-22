<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/owlcarousel/owl.carousel.css'); ?>">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/owlcarousel/owl.theme.default.min.css'); ?>">
<script type='text/javascript'
        src='<?= _A_::$app->router()->UrlTo('views/js/owlcarousel/owl.carousel.min.js'); ?>'></script>
<?php
  $pid = $rows['pid'];
  $ahref = 'mailto:'._A_::$app->keyStorage()->system_info_email.'?subject=' . rawurlencode($rows['sdesc'] . ' ' . $rows['pnumber']);
  $mhref = _A_::$app->router()->UrlTo('matches/add', ['pid' => $pid]);
  $href_related = _A_::$app->router()->UrlTo('related/view', ['pid' => $pid]);
?>

<div id="content" class="container product_view">
  <div class="col-xs-12">
    <div class="row">

      <div class="col-xs-12">
        <div class="row afterhead-row">

          <div class="col-sm-2 back_button_container">
            <div class="row">
              <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                Back
              </a>
            </div>
          </div>
          <div class="col-sm-8 text-center">
            <h3 style="margin-bottom: 30px"
                class="product_title product_title_style entry-title"><?= $rows['pname']; ?></h3>
          </div>
          <div class="col-sm-2"></div>

        </div>
      </div>

      <div class="col-xs-12">
        <div class="row">

          <div class="col-xs-12 col-md-6">
            <div class="row">
              <a <?= isset($rows['filename1']) ? 'href="' . $rows['filename1'] . '"' : ''; ?>
                itemprop="image" class="product-main-image zoom" title="Product Main Image"
                <?= isset($rows['filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                <?= isset($rows['filename1']) ? 'data-img = "' . $rows['filename1'] . '"' : '' ?>>
                <img width="100%"
                     src="<?= isset($rows['filename1']) ? $rows['filename1'] : $rows['filename']; ?>"
                     class="attachment-shop_single size-shop_single wp-post-image" alt="" />
              </a>
              <div class="thumbnails col-sm-12">
                <div class="row">
                  <?php
                    if(!empty($rows['image2']) || !empty($rows['image3']) ||
                      !empty($rows['image4']) || !empty($rows['image5'])
                    ) {
                      ?>
                      <p class="more-images">MORE IMAGES OF THIS FABRIC</p>
                      <div class="row">
                        <?php

                          if(!empty($rows['image2'])) { ?>
                            <a <?= isset($rows['img2_filename1']) ? 'href="' . $rows['img2_filename1'] . '"' : ''; ?>
                              class="col-xs-6 zoom"
                              <?= isset($rows['img2_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                              <?= isset($rows['img2_filename1']) ? 'data-img = "' . $rows['img2_filename1'] . '"' : '' ?>>
                              <img width="100%" src="<?= $rows['img2_filename']; ?>"
                                   class="attachment-shop_thumbnail size-shop_thumbnail" alt="" />
                            </a>
                            <?php
                          }

                          if(!empty($rows['image3'])) { ?>
                            <a <?= isset($rows['img3_filename1']) ? 'href="' . $rows['img3_filename1'] . '"' : ''; ?>
                              class="col-xs-6 zoom"
                              <?= isset($rows['img3_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                              <?= isset($rows['img3_filename1']) ? 'data-img = "' . $rows['img3_filename1'] . '"' : '' ?>>
                              <img width="100%" src="<?= $rows['img3_filename']; ?>"
                                   class="attachment-shop_thumbnail size-shop_thumbnail" alt="" />
                            </a>
                            <?php
                          }
                          if(!empty($rows['image4'])) { ?>
                            <a <?= isset($rows['img4_filename1']) ? 'href="' . $rows['img4_filename1'] . '"' : ''; ?>
                              class="zoom col-xs-6"
                              <?= isset($rows['img4_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                              <?= isset($rows['img4_filename1']) ? 'data-img = "' . $rows['img4_filename1'] . '"' : '' ?>>
                              <img width="100%" src="<?= $rows['img4_filename']; ?>"
                                   class="attachment-shop_thumbnail size-shop_thumbnail" alt="" />
                            </a>
                            <?php
                          }
                          if(!empty($rows['image5'])) { ?>
                            <a <?= isset($rows['img5_filename1']) ? 'href="' . $rows['img5_filename1'] . '"' : ''; ?>
                              class="zoom col-xs-6"
                              <?= isset($rows['img5_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                              <?= isset($rows['img5_filename1']) ? 'data-img = "' . $rows['img5_filename1'] . '"' : '' ?>>
                              <img width="100%" src="<?= $rows['img5_filename']; ?>"
                                   class="attachment-shop_thumbnail size-shop_thumbnail" alt="" />
                            </a>
                            <?php
                          }
                        ?>
                      </div>
                    <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-md-6 summary entry-summary">
            <div class="row">

              <div class="panel panel-default panel-body">
                <div class="col-xs-12">
                  <div class="row">
                    <p class="text-justify"><?= $rows['ldesc']; ?></p>
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="row">
                    <hr>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <?php if($rows['sys_hide_price'] == 0 && $rows['hideprice'] == 0) { ?>
                      <p class="price h4">Price:
                        <ins>
                        <span class="amount">
                          <?= $rows['format_price']; ?>
                        </span>
                        </ins>
                      </p>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="col-xs-12">
                <div class="row"
                     data-load="<?= _A_::$app->router()->UrlTo('info/view', ['method' => 'product']) ?>"></div>
                <script type='text/javascript'
                        src='<?= _A_::$app->router()->UrlTo('views/js/load.min.js'); ?>'></script>
              </div>

              <div class="col-xs-12">
                <div class="row">
                  <table class="table table-bordered table-striped red">
                    <tbody>
                    <?= isset($discount_info) ? $discount_info : '' ?>
                    </tbody>
                  </table>
                  <div class="quantity"></div>
                </div>
              </div>

              <div class="col-xs-12">
                <div class="row">
                  <div class="product-detail-view-actions" aria-label="...">

                    <div class="row button-group-product">
                      <?php if($rows['inventory'] > 0) { ?>
                        <div class="button-small-width">
                          <a class="button col-xs-12" id="add_cart"
                             href="<?= _A_::$app->router()->UrlTo('cart/add', ['pid' => $pid]) ?>" <?= (isset($rows['in_cart']) && $rows['in_cart']) ? 'style="display: none;"' : ''; ?>>
                            Add to Cart
                          </a>
                          <a class="button col-xs-12" id="view_cart"
                             href="<?= _A_::$app->router()->UrlTo('cart') ?>" <?= (isset($rows['in_cart']) && $rows['in_cart']) ? '' : 'style="display: none;"'; ?>>
                            Cart
                          </a>
                        </div>
                      <?php } ?>
                      <?php if($rows['inventory'] > 0 && $allowed_samples) { ?>
                        <div class="button-small-width">
                          <a id="add_samples_cart" class="button col-xs-12"
                             href="<?= _A_::$app->router()->UrlTo('cart/add_samples', ['pid' => $pid]) ?>" <?= (isset($rows['in_samples_cart']) && $rows['in_samples_cart']) ? 'style="display: none;"' : ''; ?>>
                            Add Samples
                          </a>
                        </div>
                      <?php } ?>

                      <div class="button-small-width">
                        <a class="button col-xs-12" id="view_favorites"
                           style="<?= (isset($in_favorites) && $in_favorites) ? '' : 'display:none'; ?>"
                           data-pid="<?= $rows['pid'] ?>"
                           href="<?= _A_::$app->router()->UrlTo('favorites'); ?>">

                          My Favorites
                        </a>

                        <a class="button col-xs-12" id="add_favorites"
                           style="<?= (isset($in_favorites) && $in_favorites) ? 'display:none' : ''; ?>"
                           data-pid="<?= $rows['pid'] ?>"
                           href="<?= _A_::$app->router()->UrlTo('favorites/add'); ?>">

                          Add to Favorites
                        </a>
                        <?php if($rows['img1_exists']) { ?>
                      </div>

                      <div class="button-small-width">
                        <a class="button col-xs-12" id="add_matches"
                           href="<?= $mhref; ?>" <?= (isset($rows['in_matches']) && $rows['in_matches']) ? 'style="display: none;"' : ''; ?>>

                          Add to Matches
                        </a>

                        <a class="button col-xs-12" id="view_matches"
                           href="<?= _A_::$app->router()->UrlTo('matches'); ?>" <?= (isset($rows['in_matches']) && $rows['in_matches']) ? '' : 'style="display: none;"'; ?>>

                          Matches
                        </a>
                        <?php } ?>
                      </div>

                      <div class="button-small-width">
                        <a class="button col-xs-12" href="<?= $ahref; ?>">
                          Ask a Question
                        </a>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="product_meta product_details">
                <h3>DETAILS</h3>
                <table class="table table-bordered table-striped">
                  <tbody>
                  <tr>
                    <td class="row_title"><b>Name</b>:</td>
                    <td><?= $rows['pname']; ?></td>
                  </tr>
                  <tr>
                    <td class="row_title"><b>Product #</b>:</td>
                    <td><?= $rows['pnumber']; ?></td>
                  </tr>
                  <?php if(($rows['piece'] == 1) && ($rows['inventory'] > 0)) { ?>
                    <tr>
                      <td class="row_title"><b>Dimensions</b>:</td>
                      <td><?= $rows['dimensions']; ?></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td class="row_title"><b>Width</b>:</td>
                      <td><?= $rows['width']; ?></td>
                    </tr>
                    <tr style="<?= ($rows['inventory'] > 0) ? '' : 'color: red;'; ?>">
                      <td class="row_title"><b>Avail. yardage</b>:</td>
                      <td><?= $rows['inventory'];
                        ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row related" data-related>
        <input data-href_related type="hidden" value="<?= $href_related; ?>"/>
      </div>
    </div>

  </div>
</div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/shop/product.min.js'); ?>' type="text/javascript"></script>
