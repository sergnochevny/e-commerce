<?php include(APP_PATH . '/views/index/main_gallery.php'); ?>
<div id="content" class="container inner-offset-top half-outer-offset-bottom">
  <div class="col-xs-12 box">
    <?php $back_url = _A_::$app->router()->UrlTo('shop'); ?>

    <div class="col-xs-12 col-sm-2 back_button_container">
      <div class="row">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          To Shop
        </a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-8 text-center">
      <h1 class="page-title">Customer Service</h1>
    </div>

    <div class="col-xs-12">
      <div class="row">
        <div class="row">
          <div class="col-xs-12">
            <h3 class="service__cont-title">
              Shipping
            </h3>
            <p>We ship Worldwide.</p>
            <p>
              Products are generally shipped within 24 to 72 hours of receipt of the full payment. Some fabrics take
              longer to ship. This is clearly mentioned in the fabric description should this be the case.
            </p>
            <p>
              Please always examine your package immediately upon receipt so as to ensure the integrity of the
              packaging and its contents. Our contact information appears just below. Many times when we package
              fabrics we put layers of tissue paper around the fabric before the plastic sleeve, which is sometimes
              mistaken for the fabric that was ordered. Please OPEN your package to see your fabric to verify its
              contents and integrity.
            </p>
            <p>
              Phone at: <a href="tel:9155870200">(915) 587-0200</a><br>
              Email: <a
                href="mailto:<?= _A_::$app->keyStorage()->system_info_email; ?>"><?= _A_::$app->keyStorage()->system_info_email; ?></a><br>
              Address: <a href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router->host; ?></a> (Division
              of Fabric Love LLC)<br>
              211 Teramar Way<br>
              El Paso, Texas, 79922<br>
              United States<br>
            </p>
          </div>
          <div class="col-xs-12">
            <h3 class="service__cont-title">
              Sales Terms
            </h3>
            <p>
              All Sales are final. Please purchase a sample (we offer samples at very reasonable prices) if you are
              not entirely confident in your fabric purchase, as there are no returns or refunds. You can purchase a
              Sample of most of our products. It is initiated from the Fabric Details page. </p>
            <p>
              Also, we cannot guarantee your fabric when purchased will be from the same dye lot as your sample, if
              your fabric purchase is initiated more than 2 weeks beyond the purchase of your sample. Dye lots are
              normally close but each dye lot is different. Please check with us if you are not sure of your dates
              before you make your fabric purchase.
            </p>
            <p>
              We are confident you'll find our products to be of the highest quality. If however your are not
              completely satisfied with a product, please contact us by phone and email. The email must clearly
              delineate the issue and be accompanied by pictures. We will endeavor to rectify the problem if both
              possible, and deemed appropriate.
            </p>
            <p>
              It is up to the sole discretion of <a
                href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router()->host; ?></a> / Fabric Love
              LLC. to decide whether your purchase
              qualifies for any sort of remedy. Should <a
                href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router()->host; ?></a> / Fabric Love
              LLC. accept a return (at
              <a href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router()->host; ?>’s</a> sole
              discretion), we will generate and provide you with a Return Authorization
              Number. No fabric return will be accepted by our warehouse without a Return Authorization Number marked
              and clearly visible on the outside of the return package. Any fabric returned without such a number will
              not be accepted and will be returned to the sender at the sender’s expense.
            </p>
            <p>
              If a return is authorized by <a
                href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router()->host; ?></a> / Fabric Love
              LLC., all return shipping costs and
              customs duties or taxes, if any, are to be paid in their entirety by the purchaser, unless otherwise
              agreed to in advance of the return by <a
                href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router()->host; ?></a> / Fabric Love
              LLC. Depending on the nature of
              the issue, <a href="<?= _A_::$app->router()->base_url; ?>"><?= _A_::$app->router->host; ?></a> / Fabric
              Love LLC. may be unable to provide any sort of rectification.
              However, as we do want to keep our customers happy, we always endeavor to find a mutually agreeable
              solution to the problem which may, in certain cases, allow for the return of a fabric, usually
              accompanied by a modest restocking fee. In these cases we generally provide the customer with a website
              credit for the purchase of another fabric of their choice. Our website credits are usable for one year
              from the date of your original fabric purchase.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="service__cont-title">
              Privacy Policy
            </h3>
            <p class="service__cont-desc">
              Your personal information is never under any circumstances shared with any other individuals or
              organizations. For a complete understanding of our Privacy Policy, please click the following link:
              <a href="<?= _A_::$app->router()->UrlTo('privacy'); ?>">privacy policy.</a>
            </p>
          </div>
          <div class="col-sm-6">
            <h3 class="service__cont-title">
              Security Information
            </h3>
            <p class="service__cont-desc">
              All purchase transactions made on our site are fully and completely secure.
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('js/static/static.min.js'); ?>' type="text/javascript"></script>