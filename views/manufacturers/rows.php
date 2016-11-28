<?php if(sizeof($rows) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-8 col">
          <?php
            if(isset($sort['a.manufacturer'])) {
              $order['sort'] = 'a.manufacturer';
              $order['order'] = ($sort['a.manufacturer'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'a.manufacturer';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('manufacturers', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Manufacturer
            <?php if(isset($sort['a.manufacturer'])) : ?>
              <small>
                <i class="fa <?= ($sort['a.manufacturer'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-3 col">
          <?php
            if(isset($sort['amount'])) {
              $order['sort'] = 'amount';
              $order['order'] = ($sort['amount'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'amount';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('manufacturers', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Products
            <?php if(isset($sort['amount'])) : ?>
              <small>
                <i class="fa <?= ($sort['amount'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
      </div>
    </div>
    <?php foreach($rows as $row): ?>
      <?php $prms['id'] = $row['id'];
      if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-8 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Manufacturer</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row['manufacturer'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Products</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row['amount'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
            <a data-modify href="<?= _A_::$app->router()->UrlTo('manufacturers/edit', $prms) ?>">
              <i class="fa fa-2x fa-pencil"></i>
            </a>
            <a href="<?= _A_::$app->router()->UrlTo('manufacturers/delete', $prms) ?>" data-delete rel="nofollow"
               class="text-danger <?= ($row['amount'] > 0) ? 'disabled' : '' ?>">
              <i class=" fa fa-2x fa-trash-o"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top page-title">No results found</h2>
  </div>
<?php endif; ?>

