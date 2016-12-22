<?php include('views/index/main_gallery.php'); ?>
  <div id="content" class="container">
    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 text-center afterhead-row">
          <div class="row">
            <h1 class="page-title" style="margin-bottom: 35px!important;">Customer service</h1>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="row">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <h3 class="service__cont-title">
                  Shipping
                </h3>
                <p>We ship Worldwide.</p>
                <p>
                  Products are generally shipped within 24 to 72 hours from the time of approved payment received.
                </p>
              </div>
              <div class="col-xs-12 col-sm-6">
                <h3 class="service__cont-title">
                  Sales Terms
                </h3>
                <p>Please purchase a sample (we offer samples at very reasonable prices) if you are not entirely
                  confident in your fabric purchase, as there are no returns or refunds.</p>
                <p>We cannot guarantee dye lot if a sample is purchased more than 2 weeks prior to the purchase of your
                  order. Dye lots are normally close but each dye lot is different.
                </p>
              </div>
            </div>
          </div>
        </div>


        <div class="col-xs-12">
          <div class="row">
            <h3 class="service__cont-title">
              All Sales are Final
            </h3>
            <p>All special orders are final sale. No refunds. No cancellations. No returns.</p>
            <p>Please <a href="<?= _A_::$app->router()->UrlTo('contact'); ?>">contact</a> us for information on fabric
              sample purchases.</p>
            <p>We are confident you'll find our products to be of the highest quality. If however your are not
              completely satisfied with a product, please contact us by email or phone and we will endeavor to rectify
              the problem.</p>
            <p>Should ILuvFabrix.com accept a return (at ILuvFabrix's sole discretion), it must be accompanied by a
              return authorization number. No fabric is to be returned without a Return Authorization Number. Any
              fabric returned without such a number will not be accepted. If a return is authorized by iluvfabrix or
              Michelle’s Fabrics, all return shipping costs and any customs duties or taxes are to be paid in their
              entirety by the purchaser, unless otherwise agreed to in advance of the return by iluvfabrix or
              Michelle’s Fabrics. Please examine your package immediately upon receipt so as to ensure the integrity
              of its contents. Please contact us by email at:
              <a
                href="mailto:<?= _A_::$app->keyStorage()->system_info_email; ?>"><?= _A_::$app->keyStorage()->system_info_email; ?></a>
              or phone at: <a href="tel:9155870200">(915) 587-0200</a></p>
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
                  organizations.
                  <a href="<?= _A_::$app->router()->UrlTo('privacy'); ?>">privacy policy.</a>
                </p>
              </div>
              <div class="col-sm-6">
                <h3 class="service__cont-title">
                  Security Information
                </h3>
                <p class="service__cont-desc">
                  All purchase transactions made on our site are fully and completely secured.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="row">
            <h3 class="service__cont-title">
              Contact Information
            </h3>
            <div class="service__cont-desc">
              <div class="row">
                <div class="col-sm-4">
                  <p>iluvfabrix (Division of Fabric Love LLC)</p>
                  <p>211 Teramar Way</p>
                  <p>El Paso, Texas, 79922</p>
                  <p>United States</p>
                </div>
                <div class="col-sm-4">
                  <p>Email:<a
                      href="mailto:<?= _A_::$app->keyStorage()->system_info_email; ?>"><?= _A_::$app->keyStorage()->system_info_email; ?></a>
                  </p>
                  <p>Tel: <a href="tel:9155870200">(915) 587-0200</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src='<?= _A_::$app->router()->UrlTo('views/js/static/static.min.js'); ?>' type="text/javascript"></script>
<?php include('views/index/block_footer.php'); ?>