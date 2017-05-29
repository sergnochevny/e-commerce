<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="row">

    <div class="col-xs-12 col-sm-12 text-center">
      <label>To enable all features of iluvfabrix.com please register</label>
    </div>

    <div class="col-xs-12 col-md-8 col-md-offset-2 panel-default-vertical-sizing">
      <div class="col-xs-12 panel panel-default">
        <div class="row">
          <div class="col-xs-12 text-center">
            <h4>Register with iluvfabrix:</h4>
          </div>
          <div class="col-xs-12" data-role="form_content">
            <div data-load="<?= _A_::$app->router()->UrlTo('user/registration', ['method' => 'short']) ?>">
              <script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/load.min.js'); ?>'></script>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>


