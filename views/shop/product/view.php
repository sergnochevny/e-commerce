<?php
  $pid = $data['pid'];
  $ahref = 'mailto:info@iluvfabrix.com?subject=' . rawurlencode($data['sdesc'] . ' ' . $data['pnumber']);
  $mhref = _A_::$app->router()->UrlTo('matches/add', ['pid' => $pid]);
  $href_related = _A_::$app->router()->UrlTo('related/view', ['pid' => $pid]);
?>

<div id="content" class="container">
  <div class="col-md-12">

    <div class="row">
      <div class="col-xs-12">
        <div class="row afterhead-row">

          <div class="col-sm-2 back_button_container">
            <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">Back</a>
          </div>
          <div class="col-sm-8 text-center">
            <h3 style="margin-bottom: 30px"
                class="product_title product_title_style entry-title"><?= $data['pname']; ?></h3>
          </div>
          <div class="col-sm-2"></div>

        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-6 images">
        <a <?= isset($data['filename1']) ? 'href="' . $data['filename1'] . '"' : ''; ?>
          itemprop="image" class="product-main-image zoom" title=""
          <?= isset($data['filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
          <?= isset($data['filename1']) ? 'data-img = "' . $data['filename1'] . '"' : '' ?>>
          <img width="100%"
               src="<?= isset($data['filename1']) ? $data['filename1'] : $data['filename']; ?>"
               class="attachment-shop_single size-shop_single wp-post-image" alt="" title=""/>
        </a>
        <div class="thumbnails col-sm-12">
          <div class="row">
            <?php
              if (!empty($data['image2']) || !empty($data['image3']) ||
                !empty($data['image4']) || !empty($data['image5'])
              ) {
                ?>
                <p class="more-images">MORE IMAGES OF THIS FABRIC</p>
                <div class="row">
                  <?php

                    if (!empty($data['image2'])) { ?>
                      <a <?= isset($data['img2_filename1']) ? 'href="' . $data['img2_filename1'] . '"' : ''; ?>
                        class="col-xs-6 zoom"
                        title=""
                        <?= isset($data['img2_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img2_filename1']) ? 'data-img = "' . $data['img2_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img2_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                      </a>
                      <?php
                    }

                    if (!empty($data['image3'])) { ?>
                      <a <?= isset($data['img3_filename1']) ? 'href="' . $data['img3_filename1'] . '"' : ''; ?>
                        class="col-xs-6 zoom"
                        title=""
                        <?= isset($data['img3_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img3_filename1']) ? 'data-img = "' . $data['img3_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img3_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                      </a>
                      <?php
                    }
                    if (!empty($data['image4'])) { ?>
                      <a <?= isset($data['img4_filename1']) ? 'href="' . $data['img4_filename1'] . '"' : ''; ?>
                        class="zoom col-xs-6"
                        title=""
                        <?= isset($data['img4_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img4_filename1']) ? 'data-img = "' . $data['img4_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img4_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                      </a>
                      <?php
                    }
                    if (!empty($data['image5'])) { ?>
                      <a <?= isset($data['img5_filename1']) ? 'href="' . $data['img5_filename1'] . '"' : ''; ?>
                        class="zoom col-xs-6"
                        title=""
                        <?= isset($data['img5_filename1']) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                        <?= isset($data['img5_filename1']) ? 'data-img = "' . $data['img5_filename1'] . '"' : '' ?>>
                        <img width="100%" src="<?= $data['img5_filename']; ?>"
                             class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                      </a>
                      <?php
                    }
                  ?>
                </div>
              <?php } ?>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-6 summary entry-summary">
        <div class="col-xs-12">

          <div class="row">
            <div class="panel panel-default panel-body" style="box-shadow: none">
              <div class="row">
                <div class="col-sm-12">
                  <p class="text-justify"><?= $data['ldesc']; ?></p>
                </div>
              </div>
              <?php if ($data['sys_hide_price'] == 0 && $data['hideprice'] == 0) { ?>
                <div class="col-sm-12">
                  <div class="row">
                    <hr>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="btn-group product-actions">
                      <a class="btn button" id="add_favorites" title="Add to favorites" data-pid="<?= $data['pid'] ?>"
                         href="<?= _A_::$app->router()->UrlTo('favorites/add'); ?>">
                        <i class="fa fa-heart"></i>
                      </a>
                      <?php if ($data['img1_exists']) { ?>
                        <a class="btn button" title="Add to Matches" id="add_matches"
                           href="<?= $mhref; ?>" <?= (isset($data['in_matches']) && $data['in_matches']) ? 'style="display: none;"' : ''; ?>>
                          <i class="fa fa-exchange"></i>
                        </a>
                        <a class="btn button" title="Go to Matches" id="view_matches"
                           href="<?= _A_::$app->router()->UrlTo('matches'); ?>" <?= (isset($data['in_matches']) && $data['in_matches']) ? '' : 'style="display: none;"'; ?>>
                          <i class="fa fa-bookmark"></i>
                        </a>
                      <?php } ?>
                      <a class="btn button" title="Ask a question" href="<?= $ahref; ?>">?</a>

                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <p class="price h4 text-right">Price:
                      <ins>
                        <span class="amount">
                          <?= $data['format_price']; ?>
                        </span>
                      </ins>
                    </p>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>

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

              <div class="row">
                <div class="col-sm-6 no-offset-right">
                  <?php if ($data['inventory'] > 0) { ?>
                    <a class="btn button col-xs-12" id="add_cart"
                       href="<?= _A_::$app->router()->UrlTo('cart/add', ['pid' => $pid]) ?>" <?= (isset($data['in_cart']) && $data['in_cart']) ? 'style="display: none;"' : ''; ?>>
                      Add to cart
                    </a>
                    <a class="btn button col-xs-12" id="view_cart"
                       href="<?= _A_::$app->router()->UrlTo('cart') ?>" <?= (isset($data['in_cart']) && $data['in_cart']) ? '' : 'style="display: none;"'; ?>>
                      Basket
                    </a>
                  <?php } ?>
                </div>
                <div class="col-sm-6 no-offset-left">
                  <?php if ($data['inventory'] > 0 && $allowed_samples) { ?>
                    <a id="add_samples_cart" class="btn button col-xs-12"
                       href="<?= _A_::$app->router()->UrlTo('cart/add_samples', ['pid' => $pid]) ?>" <?= (isset($data['in_samples_cart']) && $data['in_samples_cart']) ? 'style="display: none;"' : ''; ?>>
                      Add Samples
                    </a>
                  <?php } ?>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="row">
            <div class="product_meta">
              <h3>DETAILS</h3>
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
                <?php if (($data['piece'] == 1) && ($data['inventory'] > 0)) { ?>
                  <tr>
                    <td class="row_title"><b>Dimensions</b>:</td>
                    <td><?= $data['dimensions']; ?></td>
                  </tr>
                <?php } else { ?>
                  <tr>
                    <td class="row_title"><b>Width</b>:</td>
                    <td><?= $data['width']; ?></td>
                  </tr>
                  <tr style="<?= ($data['inventory'] > 0) ? '' : 'color: red;'; ?>">
                    <td class="row_title"><b>Avail. yardage</b>:</td>
                    <td><?= $data['inventory'];
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

    <div class="row" data-related><input data-href_related type="hidden" value="<?= $href_related; ?>"/></div>

  </div>
</div>
<link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/owl.carousel.css'); ?>' type='text/css'
      media='all'/>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/owl.carousel.min.js'); ?>'></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/shop/product.js'); ?>' type="text/javascript"></script>





