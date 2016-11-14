<?php if(sizeof($rows) > 0): ?>
  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-8 col">
        <?php
          if (isset($sort['a.cname'])) {
            $order['sort'] = 'a.cname';
            $order['order'] = ($sort['a.cname'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'a.cname';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('categories', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Name
          <?php if(isset($sort['a.cname'])) : ?>
            <small>
              <i class="fa <?= ($sort['a.cname'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <div class="col-sm-3 col">
        <?php
          if (isset($sort['a.displayorder'])) {
            $order['sort'] = 'a.displayorder';
            $order['order'] = ($sort['a.displayorder'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'a.displayorder';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('categories', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Display Order
          <?php if(isset($sort['a.displayorder'])) : ?>
            <small>
              <i class="fa <?= ($sort['a.displayorder'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
    </div>
  </div>
  <?php foreach($rows as $row): ?>
    <?php $prms['cid'] = $row['cid']; if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
    <div class="col-xs-12 table-list-row">
      <div class="row">
        <div class="col-xs-12 col-sm-8 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Name</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row['cname'] ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Display Order</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row['displayorder'] ?></div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
          <a data-modify href="<?= _A_::$app->router()->UrlTo('categories/edit', $prms) ?>">
            <i class="fa fa-2x fa-pencil"></i>
          </a>
          <a href="<?= _A_::$app->router()->UrlTo('categories/delete', $prms) ?>" data-delete rel="nofollow"
             class="text-danger <?= ($row['amount']>0)?'disabled':''?>">
            <i class="fa fa-2x fa-trash-o"></i>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 text-center offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>

