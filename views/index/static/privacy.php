<?php include('views/index/main_gallery.php'); ?>

  <div id="content" class="container inner-offset-top half-outer-offset-bottom">
    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 text-center">
          <div class="row">
            <h2 class="page-title">Privacy Policy</h2>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="row">

            <p class="paragraph">We are committed to providing our visitors with a
              web site that respects their privacy. This page summarizes the
              privacy policy and practices on iluvfabrix.com.</p>

            <ol>
              <li class="copyProducts">We do not automatically gather
                any personal information from you, such as your name,
                phone number, e-mail or address. This information is only
                obtained if you supply it voluntarily, usually through
                contacting us via e-mail, or registering in a secure portion
                of the site.
              </li>
              <li class="copyProducts">Any personal information you do
                provide is protected under the federal Privacy Act of
                Canada. This means that, at the point of collection, you
                will be informed that your personal information is being
                collected, the purpose for which it is being collected
                and that you have a right of access to the information.
              </li>
              <li class="copyProducts">We use software that receives and
                records the Internet Protocol (IP) address of the computer
                that has contacted our Web site. We make no attempt to
                link these addresses with the identity of individuals
                visiting our site. <br>
              </li>
              <li class="copyProducts">We do not regularly use "cookies"
                to track how our visitors use the site. Whenever we enable
                "cookies" to facilitate your transactions, we
                will first inform you.
              </li>
              <li class="copyProducts">Visitor information is not disclosed
                to anyone except iluvfabrix.com
                personnel who need the information, e.g., to respond to
                a request.
              </li>
              <li class="copyProducts">If you join a iluvfabrix.com
                online discussion group, we may ask you to volunteer personal
                information such as your name and email address for the
                purposes of effective administration of the discussion
                group. In some cases, our groups are limited to member
                only discussions and as such can not be accessed by the
                general public. We will notify you as to whether you are
                joining a closed (limited) or open (public) discussion.
              </li>
            </ol>
            <p>For questions or comments regarding
              this policy please contact us by <a
                  href="mailto:<?= _A_::$app->keyStorage()->system_info_email; ?>"><?= _A_::$app->keyStorage()->system_info_email; ?></a>.
            </p>

            <p>Additional information about <a target="_blank" href="http://www.privcom.gc.ca">Canada's
                Privacy Act</a> can be found here.</p>

          </div>
        </div>
        <div class="col-xs-12">
          <div class="row">
            <h4>Security</h4>
            <p>
              Our site is fully secure for online credit card payements.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script src='<?= _A_::$app->router()->UrlTo('views/js/static/static.min.js'); ?>' type="text/javascript"></script>