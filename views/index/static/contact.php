<?php include('views/index/main_gallery.php'); ?>
  <div id="static">
    <div class="container">

      <div class="row">
        <div class="col-xs-12">
          <div class="row">

            <div class="col-xs-12 text-center afterhead-row">
              <h2 class="page-title half-inner-offset-bottom" style="margin-bottom: 15px">Contact</h2>
            </div>

            <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-center">
              <hr>
            </div>


            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
              <div class="row">
                <div class="col-xs-12">
                  <h4><p class="text-center">Leave us a message</p>
                    <br>
                    <small style="text-shadow: none">
                      Please feel free to contact us with your questions
                      or comments. Simply fill out the form below and one of our
                      representatives will contact you shortly.
                    </small>
                  </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <div class="form-row">
                    <label for="contact-name">Your Name</label>
                    <input type="text" name="contact-name" id="contact-name" class="input-text">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-row">
                    <label for="contact-phone">Phone</label>
                    <input type="text" name="contact-phone" id="contact-phone" class="input-text">
                  </div>
                </div>

                <div class="col-xs-6">
                  <div class="form-row">
                    <label for="contact-email">Your Email</label>
                    <input type="text" name="contact-email" id="contact-email" class="input-text">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <div class="form-row">
                    <label for="fabricType">Select type of fabric</label>
                    <select name="fabricType" id="fabricType">
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
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <div class="form-row">
                    <label>Questions or comments</label>
                    <textarea name="contact-questions-or-comments" id="contact-questions-or-comments" rows="10" cols="30" class="input-text"></textarea>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 text-center">
                  <br>
                </div>
              </div>


              <div class="row">
                <div class="col-xs-12 text-center">
                  <div class="form-row">
                    <a href="#" id="contact-submit" class="btn button">Send a letter</a>
                  </div>
                </div>
              </div>

            </div>



          </div>
        </div>
      </div>

    </div>
  </div>

  <script src='<?= _A_::$app->router()->UrlTo('views/js/static/static.js'); ?>' type="text/javascript"></script>
<?php include('views/index/block_footer.php'); ?>