<div class="container inner-offset-top half-outer-offset-bottom">
  <div class="box col-xs-12">
    <div class="row">
      <div class="col-xs-12 col-sm-2 back_button_container">
        <a data-waitloader id="back_url" href="<?= $back_url; ?>" class="button back_button">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
          Back
        </a>
      </div>
      <div class="col-xs-12 col-sm-8 text-center">
        <div class="row">
          <h1 class="page-title">Discount usage details</h1>
        </div>
      </div>
      <div class="col-sm-2 text-center"></div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?= $discount; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?= $orders; ?>
      </div>
    </div>
  </div>
</div>
