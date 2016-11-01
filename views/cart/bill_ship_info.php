<div class="col-xs-12 table-list-header">
  <div class="row">
    <div class="col-xs-6 col">Bill To:</div>
    <div class="col-xs-6 col">Ship To:</div>
  </div>
</div>


<div class="col-xs-12 table-list-row">
  <div class="row">
    <div class="col-xs-6 table-list-row-item">
      <?php if (isset($bill_firstname) && strlen($bill_firstname) > 0): ?>
      <div class="col-xs-12"><div class="row"><?= $bill_firstname ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_lastname) && strlen($bill_lastname) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_lastname ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_organization) && strlen($bill_organization) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_organization ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_address1) && strlen($bill_address1) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_address1 ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_address2) && strlen($bill_address2) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_address2 ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_city) && strlen($bill_city) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_city ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_province) && strlen($bill_province) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_province ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_postal) && strlen($bill_postal) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_postal ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_country) && strlen($bill_country) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_country ?></div></div>
      <?php endif; ?>
      <?php if (isset($bill_phone) && strlen($bill_phone) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $bill_phone ?></div></div>
      <?php endif; ?>
    </div>
    <div class="col-xs-6 table-list-row-item">
      <?php if (isset($ship_firstname) && strlen($ship_firstname) > 0): ?>
      <div class="col-xs-12"><div class="row"><?= $ship_firstname ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_lastname) && strlen($ship_lastname) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_lastname ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_organization) && strlen($ship_organization) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_organization ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_address1) && strlen($ship_address1) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_address1 ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_address2) && strlen($ship_address2) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_address2 ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_city) && strlen($ship_city) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_city ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_province) && strlen($ship_province) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_province ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_postal) && strlen($ship_postal) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_postal ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_country) && strlen($ship_country) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_country ?></div></div>
      <?php endif; ?>
      <?php if (isset($ship_phone) && strlen($ship_phone) > 0): ?>
        <div class="col-xs-12"><div class="row"><?= $ship_phone ?></div></div>
      <?php endif; ?>
    </div>
  </div>
</div>
