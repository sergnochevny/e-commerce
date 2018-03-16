<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-xs-6 col">Bill To:</div>
    <div class="col-xs-6 col">Ship To:</div>
  </div>
</div>

<div class="col-xs-12 table-list-row sm-half-xs-full">
  <div class="row">

    <div class="col-xs-12 col-sm-6">
      <div class="row">
        <div class="col-xs-12 table-list-row-item">
          <div class="row table-list-header text-center visible-xs">
            <b>Bill To:</b>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <?= (!empty($bill_firstname) ? $bill_firstname : '') . (!empty($bill_lastname) ? ' ' . $bill_lastname : '') ?>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="row"><?= $bill_organization ?></div>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <?= (!empty($bill_address1) ? $bill_address1 : '') . (!empty($bill_address2) ? ' ' . $bill_address2 : '') ?>
              <?= (!empty($bill_address1) || !empty($bill_address2)) ? '<br>' : '' ?>
              <?= (!empty($bill_city) ? $bill_city : '') . (!empty($bill_province) ? ', ' .
                $bill_province : '') . (!empty($bill_postal) ? ' ' . $bill_postal : '') . (!empty($bill_city) ? ' ' . $bill_city : '') ?>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="row"><?= $bill_country ?></div>
          </div>
          <div class="col-xs-12">
            <div class="row"><?= $bill_phone ?></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6">
      <div class="row">
        <div class="col-xs-12 table-list-row-item">
          <div class="row table-list-header text-center visible-xs">
            <b>Ship To:</b>
          </div>
          <div class="col-xs-12">
            <div
              class="row"><?= (!empty($ship_firstname) ? $ship_firstname : '') . (!empty($ship_lastname) ? ' ' . $ship_lastname : '') ?></div>
          </div>
          <div class="col-xs-12">
            <div class="row"><?= $ship_organization ?></div>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <?= (!empty($ship_address1) ? $ship_address1 : '') . (!empty($ship_address2) ? ' ' . $ship_address2 : '') ?>
              <?= (!empty($ship_address1) || !empty($ship_address2)) ? '<br>' : '' ?>
              <?= (!empty($ship_city) ? $ship_city : '') . (!empty($ship_province) ? ' ' . $ship_province : '') . (!empty($ship_postal) ? ' ' . $ship_postal : '') . (!empty($ship_city) ? ' ' . $ship_city : '') ?>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="row"><?= $ship_country ?></div>
          </div>
          <div class="col-xs-12">
            <div class="row"><?= $ship_phone ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
