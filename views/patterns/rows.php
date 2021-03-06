<?php

use app\core\App;

?>
<?php if(sizeof($rows) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-8 col">
          <?php
            if(isset($sort['a.pattern'])) {
              $order['sort'] = 'a.pattern';
              $order['order'] = ($sort['a.pattern'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'a.pattern';
              $order['order'] = 'desc';
            }
            $sort_url = App::$app->router()->UrlTo('patterns', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Name
            <?php if(isset($sort['a.pattern'])) : ?>
              <small>
                <i class="fa <?= ($sort['a.pattern'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
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
            $sort_url = App::$app->router()->UrlTo('patterns', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Products
            <?php if(isset($sort['amount'])) : ?>
              <small>
                <i class="fa <?= ($sort['amount'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
      </div>
      <form data-sort title="Click to sort by this column">
        <input type="hidden" name="sort" value="<?= array_keys($sort)[0] ?>">
        <input type="hidden" name="order" value="<?= array_values($sort)[0] ?>">
      </form>
    </div>
    <?php foreach($rows as $row): ?>
      <?php $prms['id'] = $row['id']; ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-8 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Name</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row[1] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Products</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row[2] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
            <a data-modify href="<?= App::$app->router()->UrlTo('patterns/edit', $prms) ?>">
              <i class="fa fa-2x fa-pencil"></i>
            </a>
            <a href="<?= App::$app->router()->UrlTo('patterns/delete', $prms) ?>" data-delete rel="nofollow"
               class="text-danger <?= ($row[2] > 0) ? 'disabled' : '' ?>">
              <i class=" fa fa-2x fa-trash-o"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center inner-offset-vertical">
    <span class="h3">No results found</span>
  </div>
<?php endif; ?>

