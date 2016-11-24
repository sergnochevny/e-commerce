<?php include('views/index/main_gallery.php'); ?>
<div id="static">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <article class="page type-page status-publish entry">
          <div class="entry-content">
            <div class="vc_row wpb_row vc_row-fluid vc_custom_1439733758005">
              <div class="wpb_column vc_column_container vc_col-sm-12">
                <div class="wpb_wrapper">
                  <div class="just-divider text-left line-no icon-hide">
                    <div class="divider-inner">
                      <h3 class="just-section-title">Newsletter</h3>

                      <p class="paragraph">DESIGNER UPHOLSTERY/ DRAPERY FABRIC SUPERSALE</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <p><a href="index">Fabrics start at $10.00 <sup>per yard</sup>. PLUS FREE SHIPPING.* Click to shop.</a>
            </p>

            <p>*(Free Ground Shipping in the Contiguous United States Only. Faster Shipping available at
              moderate rates, Worldwide, if necessary)</p><br/><br/>

            <div class="vc_row-full-width"></div>
          </div>
        </article>

        <?php if(!Controller_User::is_logged()): ?>
          <div class="newsletter__form">
            <div class="newsletter__form-title">
              <h4>Register for our newsletter to benefit from:</h4>
              <ul>
                <li>exclusive offers only given to members</li>
                <li> first to know of any limited time fabric discounts</li>
                <li>new features & website tools</li>
              </ul>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                  <div class="row">
                    <div class="col-xs-12" data-role="form_content"
                         data-load="<?= _A_::$app->router()->UrlTo('user/registration', ['method' => 'short']) ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include('views/index/block_footer.php'); ?>

<script src='<?= _A_::$app->router()->UrlTo('views/js/static/static.js'); ?>' type="text/javascript"></script>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/load.js'); ?>'></script>

