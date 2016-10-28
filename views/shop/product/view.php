<div class="container">
  <div class="col-md-12">

    <div class="row">
      <div class="col-xs-12">
        <div class="row afterhead-row">

          <div class="col-sm-2 back_button_container">
            <div class="row">
              <a id="back_url" href="<?= $back_url; ?>"
                 class="<?= isset($search) ? 'a_search' : '' ?> button back_button">Back</a>
            </div>
          </div>
          <div class="col-sm-8 text-center">
            <div class="row">
              <h3 style="margin-bottom: 30px"
                  class="product_title product_title_style entry-title"><?= $data['pname']; ?></h3>
            </div>
          </div>
          <div class="col-sm-2"></div>

        </div>
      </div>
    </div>

    <div class="row">
      <div
        class="col-xs-12 product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">
        <div class="row">

          <div class="col-md-6 images">
            <div class="row">
              <?php
                $img1_exists = true;
                $filename = 'upload/upload/' . $data['image1'];
                $filename1 = 'upload/upload/' . 'v_' . $data['image1'];
                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                  $filename = "upload/upload/not_image.jpg";
                  $filename1 = null;
                  $img1_exists = false;
                }
                $filename = _A_::$app->router()->UrlTo($filename);
                $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
              ?>
              <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                itemprop="image" class="product-main-image zoom" title=""
                <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                <img width="499" height="499"
                     src="<?= isset($filename1) ? $filename1 : $filename; ?>"
                     class="attachment-shop_single size-shop_single wp-post-image" alt="" title=""/>
              </a>

              <div class="thumbnails col-xs-12">
                <div class="row">
                  <?php
                    if (!empty($data['image2']) || !empty($data['image3']) ||
                    !empty($data['image4']) || !empty($data['image5'])
                      ) {
                  ?>
                  <p class="more-images">MORE IMAGES OF THIS FABRIC</p>
                  <div class="row">
                    <?php

                      if (!empty($data['image2'])) {
                        $filename = 'upload/upload/' . $data['image2'];
                        $filename1 = 'upload/upload/' . 'v_' . $data['image2'];
                        if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                          $filename = "upload/upload/not_image.jpg";
                          $filename1 = null;
                        }
                        $filename = _A_::$app->router()->UrlTo($filename);
                        $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
                        ?>
                        <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                          class="col-xs-6 zoom"
                          title=""
                          <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                          <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                          <img width="100%" src="<?= $filename; ?>"
                               class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                        </a>
                        <?php
                      }

                      if (!empty($data['image3'])) {
                        $filename = 'upload/upload/' . $data['image3'];
                        $filename1 = 'upload/upload/' . 'v_' . $data['image3'];
                        if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                          $filename = "upload/upload/not_image.jpg";
                          $filename1 = null;
                        }
                        $filename = _A_::$app->router()->UrlTo($filename);
                        $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
                        ?>
                        <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                          class="col-xs-6 zoom"
                          title=""
                          <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                          <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                          <img width="100%" src="<?= $filename; ?>"
                               class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                        </a>
                        <?php
                      }
                      if (!empty($data['image4'])) {
                        $filename = 'upload/upload/' . $data['image4'];
                        $filename1 = 'upload/upload/' . 'v_' . $data['image4'];
                        if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                          $filename = "upload/upload/not_image.jpg";
                          $filename1 = null;
                        }
                        $filename = _A_::$app->router()->UrlTo($filename);
                        $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
                        ?>
                        <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                          class="zoom col-xs-6"
                          title=""
                          <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                          <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                          <img width="100%" src="<?= $filename; ?>"
                               class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                        </a>
                        <?php
                      }
                      if (!empty($data['image5'])) {
                        $filename = 'upload/upload/' . $data['image5'];
                        $filename1 = 'upload/upload/' . 'v_' . $data['image5'];
                        if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                          $filename = "upload/upload/not_image.jpg";
                          $filename1 = null;
                        }
                        $filename = _A_::$app->router()->UrlTo($filename);
                        $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
                        ?>
                        <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                          class="zoom col-xs-6"
                          title=""
                          <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                          <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                          <img width="100%" src="<?= $filename; ?>"
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
          </div>

          <div class="col-md-6 summary entry-summary">
            <div class="row">

              <div class="col-sm-12">
                <div class="row">
                  <div class="product_title_desc">
                    <p class="text-justify"><?= $data['ldesc']; ?></p>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <div class="product_title_price">
                    <?php if ($sys_hide_price == 0 && $data['hideprice'] == 0) { ?>
                      <p class="price">Price:
                        <ins>
                          <span class="amount">
                          <?= $data['format_price']; ?>
                          </span>
                        </ins>
                      </p>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <table class="table table-bordered table-striped red">
                    <tbody>
                    <?= isset($discount_info) ? $discount_info : '' ?>
                    </tbody>
                  </table>
                  <div class="quantity"></div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <div class="row">

                    <div class="btn-group product-detail-view-actions" role="group" aria-label="...">
                      <?php
                        $pid = _A_::$app->get('pid');
                        if ($data['inventory'] > 0) {
                          ?>
                          <a class="button" id="add_cart"
                             href="<?= _A_::$app->router()->UrlTo('cart/add', ['pid' => $pid]) ?>" <?= !isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                            Add to cart
                          </a>
                          <a class="button" id="view_cart"
                             href="<?= _A_::$app->router()->UrlTo('cart') ?>" <?= isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                            Basket
                          </a>
                        <?php } ?>
                        <?php if ($data['inventory'] > 0 && $allowed_samples) { ?>
                          <a id="add_samples_cart" class="button"
                             href="<?= _A_::$app->router()->UrlTo('cart/add_samples', ['pid' => $pid]) ?>" <?= !isset($in_samples_cart) ? '' : 'style="display: none;"'; ?>>
                            Add Samples
                          </a>
                        <?php } ?>
                      <?php
                        $ahref = 'mailto:info@iluvfabrix.com?subject=' . rawurlencode($data['sdesc'] . ' ' . $data['pnumber']);
                        $mhref = _A_::$app->router()->UrlTo('matches/add', ['pid' => $pid]);
                      ?>
                      <a class="button" href="<?= $ahref; ?>">Ask a Question</a>
                      <?php if ($img1_exists) { ?>
                        <a class="button" id="add_matches"
                           href="<?= $mhref; ?>" <?= !isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                          Added to Matches
                        </a>
                        <a class="button" id="view_matches"
                           href="<?= _A_::$app->router()->UrlTo('matches'); ?>" <?= isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                          View Matches
                        </a>
                      <?php } ?>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <span id="b_in_product" style="0font-weight: 600;">

                  </span>
                </div>
              </div>

              <div class="col-sm-12">
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

        </div>
      </div>
    </div>

  </div>
  <input type="hidden" id="back_url" value="<?= $back_url; ?>">
  <script src='<?= _A_::$app->router()->UrlTo('views/js/shop/product.js'); ?>' type="text/javascript"></script>





