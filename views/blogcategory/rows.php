<?php if(sizeof($rows) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-11 col">
          <?php
            if(isset($sort['a.name'])) {
              $order['sort'] = 'a.name';
              $order['order'] = ($sort['a.name'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'a.name';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('blogcategory', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Name
            <small>
              <i class="fa <?= ($sort['a.name'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
            </small>
          </a>
        </div>
      </div>

      <form data-sort>
        <input type="hidden" name="sort" value="<?= array_keys($sort)[0] ?>">
        <input type="hidden" name="order" value="<?= array_values($sort)[0] ?>">
      </form>

    </div>
    <?php foreach($rows as $row): ?>
      <?php $prms = ['id' => $row['id']]; ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-11 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Name</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row[1] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
            <a class="update"
               data-modify href="<?= _A_::$app->router()->UrlTo('blogcategory/edit', $prms); ?>">
              <i class="fa fa-2x fa-pencil"></i>
            </a>
            <a class="text-danger <?= $row[2] > 0 ? 'disabled' : 'delete'; ?>"
               data-delete href="<?= _A_::$app->router()->UrlTo('blogcategory/delete', $prms); ?>">
              <i class="fa fa-2x fa-trash"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="col-xs-12 text-center offset-top">
    <h2 class="offset-top">No results found</h2>
  </div>
<?php endif; ?>
