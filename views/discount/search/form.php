<div class="col-xs-12 panel panel-default search-panel">
  <h4 class="panel-heading search-container-title"><b>Search</b><b class="sr-ds"><i class="fa fa-chevron-right"></i></b></h4>
  <form action="<?= $action ?>" id="search" class="panel-body hidden">
    <div class="form-row">
      <div class="row">

        <div class="col-xs-4">
          <div class="row">
            <div class="col-xs-12">
              Coupon Code:
            </div>
            <div class="col-xs-12">
              <input type="text" class="input-text" placeholder="Name like" name="search[coupon_code]" value="">
            </div>
          </div>
        </div>

        <div class="col-xs-4">
          <div class="row">
            <div class="col-xs-12">
              Date:
            </div>
            <div class="col-xs-6">
              <input type="text" class="input-text" placeholder="Starts at" name="search[date_start]">
            </div>
            <div class="col-xs-6">
              <input type="text" class="input-text" placeholder="Ends at" name="search[date_end]">
            </div>
          </div>
        </div>

        <div class="col-xs-2">
          <div class="row">
            <div class="col-xs-12">
              <label for="">
                Enabled:
                <input type="checkbox" class="input-checkbox" name="search[enabled]">
              </label>
            </div>
          </div>
        </div>

        <div class="col-xs-2">
          <div class="row">
            <div class="col-xs-12">
              <label for="">
                Multiple:
                <input type="checkbox" class="input-checkbox" name="search[allow_multiple]">
              </label>
            </div>
          </div>
        </div>

      </div>
    </div>
  </form>
  <div class="panel-footer hidden">
    <button type="reset" class="btn">Reset</button>
    <button type="button" class="btn pull-right">Search</button>
  </div>
</div>