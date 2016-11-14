<?php if(sizeof($rows) > 0): ?>
  <?php
  if(!is_null(_A_::$app->get('page'))) $order['page'] = _A_::$app->get('page');
  ?>
  <div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
      <div class="col-sm-1 col">
        <?php
          if(isset($sort['aid'])) {
            $order['sort'] = 'aid';
            $order['order'] = ($sort['aid'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'aid';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Id
          <?php if(isset($sort['aid'])) : ?>
            <small>
              <i class="fa <?= ($sort['aid'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <div class="col-sm-4 col">
        <?php
          if(isset($sort['email'])) {
            $order['sort'] = 'email';
            $order['order'] = ($sort['email'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'email';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Email
          <?php if(isset($sort['email'])) : ?>
            <small>
              <i class="fa <?= ($sort['email'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <div class="col-sm-3 col">
        <?php
          if(isset($sort['full_name'])) {
            $order['sort'] = 'full_name';
            $order['order'] = ($sort['full_name'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'full_name';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Name
          <?php if(isset($sort['full_name'])): ?>
            <small>
              <i class="fa <?= ($sort['full_name'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
      <div class="col-sm-2 col">
        <?php
          if(isset($sort['date_registered'])) {
            $order['sort'] = 'date_registered';
            $order['order'] = ($sort['date_registered'] == 'desc' ? 'asc' : 'desc');
          } else {
            $order['sort'] = 'date_registered';
            $order['order'] = 'desc';
          }
          $sort_url = _A_::$app->router()->UrlTo('users', $order);
        ?>
        <a data-sort href="<?= $sort_url ?>">
          Registered
          <?php if(isset($sort['date_registered'])) : ?>
            <small>
              <i class="fa <?= ($sort['date_registered'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
            </small>
          <?php endif; ?>
        </a>
      </div>
    </div>
    <form data-sort>
      <input type="hidden" name="sort" value="<?=array_keys($sort)[0]?>">
      <input type="hidden" name="order" value="<?=array_values($sort)[0]?>">
    </form>
  </div>
  <?php foreach($rows as $row): ?><?php $prms['aid'] = $row['aid'];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
    <div class="col-xs-12 table-list-row">
      <div class="row">
        <div class="col-xs-12 col-sm-1 table-list-row-item">
          <div class="col-xs-4 visible-xs">
            <div class="row">Id</div>
          </div>
          <div class="col-xs-8 col-sm-12">
            <div class="row cut-text-in-one-line"><?= $row['aid']; ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 table-list-row-item">
          <div class="col-xs-4 visible-xs">
            <div class="row">Email</div>
          </div>
          <div class="col-xs-8 col-sm-12 xs-text-left">
            <div class="row"><?= $row['email'] ?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-3 table-list-row-item">
          <div class="col-xs-4 visible-xs">
            <div class="row">Name</div>
          </div>
          <div class="col-xs-8 col-sm-12 xs-text-left">
            <div class="row"><?= $row['full_name']?></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-2 table-list-row-item">
          <div class="col-xs-4 visible-xs">
            <div class="row">Date Registered</div>
          </div>
          <div class="col-xs-8 col-sm-12 xs-text-left">
            <div class="row"><?= date("m/j/Y", strtotime($row['date_registered']));?></div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-2 text-right action-buttons">
          <a data-waitloader data-modify href="<?= _A_::$app->router()->UrlTo('users/edit', $prms) ?>">
            <i class="fa fa-2x fa-2x fa-pencil"></i>
          </a>
          <a data-delete class="text-danger" href="<?= _A_::$app->router()->UrlTo('users/delete', $prms) ?>">
            <i class=" fa fa-2x fa-2x fa-trash-o"></i>
          </a>
          <a data-waitloader class="text-success" href="<?= _A_::$app->router()->UrlTo('orders', array_merge($prms,['back'=>'users'])) ?>"><i
              class="fa fa-2x fa-2x fa-eye"></i></a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-sm-12 offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>

