<div class="container">
  <div id="content" class="main-content-inner" role="main">
    <a href="<?= _A_::$app->router()->UrlTo('discount') ?>"><input type="submit" value="Back" class="button"></a>

    <h1 class="page-title">DISCOUNTS USAGE</h1>

    <div>
      <table class="table table-striped table-bordered">
        <tr>
          <td>Details</td>
          <td class="text-center">Enabled</td>
          <td class="text-center">Multiple</td>
          <td class="text-center">Coupon</td>
          <td class="text-center">Start Date</td>
          <td class="text-center">End Date</td>
        </tr>
        <?= $list; ?>
      </table>
    </div>
    <hr>
    <div class="text-center">
      Discount Usage
    </div>
    <hr/>
    <div>
      <table class="table table-striped table-bordered">
        <tr>
          <td></td>
          <td style="width:220px;" class="text-center">Order Date</td>
          <td class="text-center">Name</td>
          <td class="text-center">Email</td>
          <td style="width:230px;" class="text-center">Start Date</td>
          <td style="width:230px;" class="text-center">End Date</td>
          <td></td>
        </tr>
        <?= $discounts_usage; ?>
      </table>
    </div>
    <br/><br/>
  </div>
</div>