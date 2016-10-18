<?php include('views/index/main_gallery.php'); ?>
  <div id="static">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <article class="page type-page status-publish entry">
            <div class="entry-content">
              <div class="vc_row wpb_row vc_row-fluid vc_custom_1439733758005">
                <div class="wpb_column vc_column_container vc_col-sm-12">
                  <div class="wpb_wrapper">
                    <div class="just-divider text-left line-no icon-hide">
                      <div class="divider-inner" style="background-color: #fff">
                        <h3 class="just-section-title">Contact</h3>

                        <p class="paragraf">Please feel free to contact us with your questions
                          or comments. Simply fill out the form below and one of our
                          representatives will contact you shortly. </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="contact-form">
                <h2>Leave a message</h2>

                <form action="" id="contact-form" method="post">
                  <fieldset class="forms">
                    <div class="left-column">
                      <p class="field-contact-name">
                        <label>Your Name</label>
                        <input type="text" name="contact-name" id="contact-name" value=""
                               class="txt requiredField">
                      </p>

                      <p class="field-contact-address1">
                        <label>Your Address 1</label>
                        <input type="text" name="contact-address1" id="contact-address1"
                               value="" class="txt requiredField address1">
                      </p>

                      <p class="field-contact-address2">
                        <label>Your Address 2</label>
                        <input type="text" name="contact-address2" id="contact-address2"
                               value="" class="txt requiredField address2">
                      </p>

                      <p class="field-contact-phone">
                        <label>Phone</label>
                        <input type="text" name="contact-phone" id="contact-phone" value=""
                               class="txt requiredField phone">
                      </p>

                      <p class="field-contact-fax">
                        <label>Fax</label>
                        <input type="text" name="contact-fax" id="contact-fax" value=""
                               class="txt requiredField fax">
                      </p>

                      <p class="field-contact-email">
                        <label>Your Email</label>
                        <input type="text" name="contact-email" id="contact-email" value=""
                               class="txt requiredField email">
                      </p>

                      <p class="field-contact-type-of-fabric">
                        <style>
                          #fabricType {
                            border: 2px solid #222222;
                            border-radius: 0;
                            font-size: 12px;
                            height: 36px;
                            padding: 0 10px;
                            width: 100%;
                            color: #aaa;
                          }
                        </style>
                        <label>Select type of fabric</label>
                        <select name="fabricType" size="1" id="fabricType">
                          <option value="select type of fabric">Select type of fabric</option>
                          <option value="Designer Fabrics">Designer Fabrics</option>
                          <option value="Florals, Leaves, Prints">Florals, Leaves, Prints
                          </option>
                          <option value="Under $22.00">Under $22.00</option>
                          <option value="Mohair Velvets">Mohair Velvets</option>
                          <option value="Rich Tapestry Fabric">Rich Tapestry Fabric</option>
                          <option value="Leather/Faux Fur">Leather/Faux Fur</option>
                          <option value="Fortuny Style">Fortuny Style</option>
                          <option value="Spectacular Silks">Spectacular Silks</option>
                          <option value="Scalamandre/LeeJofa">Scalamandre/LeeJofa</option>
                          <option value="Fur Throws &amp; Pillows">Fur Throws &amp; Pillows
                          </option>
                          <option value="Brunschwig &amp; Fils">Brunschwig &amp; Fils</option>
                          <option value="Damasks &amp; Jacquards">Damasks &amp; Jacquards
                          </option>
                          <option value="British Designers">British Designers</option>
                          <option value="Just Arrived">Just Arrived</option>
                          <option value="Stripe/Strie/Ribbed">Stripe/Strie/Ribbed</option>
                          <option value="Clarence House/OWW">Clarence House/OWW</option>
                          <option value="Luxurious Chenilles">Luxurious Chenilles</option>
                          <option value="Geometric Shapes">Geometric Shapes</option>
                          <option value="Elegant Velvets">Elegant Velvets</option>
                          <option value="Modern/Contemporary">Modern/Contemporary</option>
                          <option value="Antique, Vintage">Antique, Vintage</option>
                          <option value="Remnant Fabrics">Remnant Fabrics</option>
                          <option value="Designer Trims">Designer Trims</option>
                          <option value="Donghia Fabrics">Donghia Fabrics</option>
                        </select>
                      </p>
                    </div>
                    <div class="right-column">
                      <p class="field-contact-questions-or-comments">
                        <label>Questions or comments</label>
                        <textarea name="contact-questions-or-comments"
                                  id="contact-questions-or-comments" rows="10" cols="30"
                                  class="textarea requiredField"></textarea>
                      </p>
                    </div>
                    <div class="block-column">
                      <p class="screen-reader-text"><label for="checking"
                                                           class="screen-reader-text">If you want
                          to submit this form, do not enter anything in this
                          field</label><input type="text" name="checking" id="checking"
                                              class="screen-reader-text" value=""></p>

                      <p class="buttons"><input type="submit" id="contactSubmit"
                                                class="btn button" value="Submit"></p>
                    </div>
                  </fieldset>
                </form>
              </div>
              <br/><br/>

              <div class="vc_row-full-width"></div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>
  <script src='<?= _A_::$app->router()->UrlTo('views/js/static/static.js'); ?>' type="text/javascript"></script>
<?php include('views/index/block_footer.php'); ?>