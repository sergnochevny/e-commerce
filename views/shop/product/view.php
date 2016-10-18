<div class="container">
  <form id="f_search_1" role="search" method="post" class="woocommerce-product-search"
        action="#">
    <input id="search" type="hidden" value="<?= isset($search) ? $search : '' ?>" name="s"/>
  </form>

  <a id="back_url" href="<?= $back_url; ?>" class="<?= isset($search) ? 'a_search' : '' ?> button back_button">Back</a>

  <div id="content" class="main-content-inner" role="main">
    <div
      class="product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">

      <div class="images">
        <?php
          $img1_exists = true;
          $filename = 'upload/upload/' . $data['image1'];
          $filename1 = 'upload/upload/' . 'v_' . $data['image1'];
          if(!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
            $filename = "upload/upload/not_image.jpg";
            $filename1 = null;
            $img1_exists = false;
          }
          $filename = _A_::$app->router()->UrlTo($filename);
          $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
        ?>
        <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
          itemprop="image"
          class="woocommerce-main-image zoom"
          title=""
          <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
          <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
          <img width="499" height="499"
               src="<?= isset($filename1) ? $filename1 : $filename; ?>"
               class="attachment-shop_single size-shop_single wp-post-image" alt="" title=""/>
        </a>

        <div class="thumbnails columns-4">
          <?php
            if(!empty($data['image2']) || !empty($data['image3']) ||
              !empty($data['image4']) || !empty($data['image5'])
            ) {
              ?>
              <p><b>MORE IMAGES OF THIS FABRIC</b></p>
              <?php
            }
            if(!empty($data['image2'])) {
              $filename = 'upload/upload/' . $data['image2'];
              $filename1 = 'upload/upload/' . 'v_' . $data['image2'];
              if(!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                $filename = "upload/upload/not_image.jpg";
                $filename1 = null;
              }
              $filename = _A_::$app->router()->UrlTo($filename);
              $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
              ?>
              <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                class="zoom"
                title=""
                <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                <img width="110" height="110" src="<?= $filename; ?>"
                     class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
              </a>
              <?php
            }

            if(!empty($data['image3'])) {
              $filename = 'upload/upload/' . $data['image3'];
              $filename1 = 'upload/upload/' . 'v_' . $data['image3'];
              if(!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                $filename = "upload/upload/not_image.jpg";
                $filename1 = null;
              }
              $filename = _A_::$app->router()->UrlTo($filename);
              $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
              ?>
              <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                class="zoom"
                title=""
                <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                <img width="110" height="110" src="<?= $filename; ?>"
                     class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
              </a>
              <?php
            }
            if(!empty($data['image4'])) {
              $filename = 'upload/upload/' . $data['image4'];
              $filename1 = 'upload/upload/' . 'v_' . $data['image4'];
              if(!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                $filename = "upload/upload/not_image.jpg";
                $filename1 = null;
              }
              $filename = _A_::$app->router()->UrlTo($filename);
              $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
              ?>
              <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                class="zoom"
                title=""
                <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                <img width="110" height="110" src="<?= $filename; ?>"
                     class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
              </a>
              <?php
            }
            if(!empty($data['image5'])) {
              $filename = 'upload/upload/' . $data['image5'];
              $filename1 = 'upload/upload/' . 'v_' . $data['image5'];
              if(!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                $filename = "upload/upload/not_image.jpg";
                $filename1 = null;
              }
              $filename = _A_::$app->router()->UrlTo($filename);
              $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1) : null;
              ?>
              <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                class="zoom"
                title=""
                <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                <img width="110" height="110" src="<?= $filename; ?>"
                     class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
              </a>
              <?php
            }
          ?>

        </div>
      </div>

      <div class="summary entry-summary">
        <h1 class="product_title product_title_style entry-title"><?= $data['pname']; ?></h1>

        <div class="product_title_desc">
          <p><?= $data['ldesc']; ?></p>
        </div>
        <div class="product_title_price">
          <?php if($sys_hide_price == 0 && $hide_price == 0) { ?>
            <p class="price">Price:
              <ins>
                                    <span class="amount">
                                    <?= $format_price; ?>
                                    </span>
              </ins>
            </p>
          <?php } ?>
        </div>
        <table class="table table-bordered table-striped red">
          <tbody>
          <?= isset($discount_info) ? $discount_info : '' ?>
          </tbody>
        </table>
        <div class="quantity"></div>

        <span id="b_in_product" style="font-weight: 600;">
                            <?php
                              $pid = _A_::$app->get('p_id');
                              if($data['inventory'] > 0) {
                                ?>
                                <a id="add_cart"
                                   href="<?= _A_::$app->router()->UrlTo('cart/add', ['p_id' => $pid]) ?>" <?= !isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add to cart
                                    </button>
                                </a>
                                <a id="view_cart"
                                   href="<?= _A_::$app->router()->UrlTo('cart') ?>" <?= isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Basket
                                    </button>
                                </a>
                              <?php } ?>
                        </span>

        <span id="b_in_product" style="font-weight: 600;">
                            <?php
                              if($data['inventory'] > 0 && $allowed_samples) {
                                ?>
                                <a id="add_samples_cart"
                                   href="<?= _A_::$app->router()->UrlTo('cart/add_samples', ['p_id' => $pid]) ?>" <?= !isset($in_samples_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add Samples
                                    </button>
                                </a>
                              <?php } ?>
                        </span>

        <span id="b_in_product" style="font-weight: 600;">
                            <?php
                              $ahref = 'mailto:info@iluvfabrix.com?subject=' . rawurlencode($data['sdesc'] . ' ' . $data['pnumber']);
                              $mhref = _A_::$app->router()->UrlTo('matches/add', ['p_id' => $pid]);
                            ?>
          <a href="<?= $ahref; ?>">
                                <button type="button" class="single_add_to_cart_button button alt">Ask a Question
                                </button>
                            </a>
                        </span>
        <span id="b_in_product" style="font-weight: 600;">
                            <?php if($img1_exists) { ?>
                              <a id="add_matches"
                                 href="<?= $mhref; ?>" <?= !isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Added to Matches
                                    </button>
                                </a>
                              <a id="view_matches"
                                 href="<?= _A_::$app->router()->UrlTo('matches'); ?>" <?= isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">View Matches
                                    </button>
                                </a>
                            <?php } ?>
                        </span>

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
            <?php if(($data['piece'] == 1) && ($data['inventory'] > 0)) { ?>
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
<input type="hidden" id="back_url" value="<?= $back_url; ?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/shop/product.js'); ?>' type="text/javascript"></script>





