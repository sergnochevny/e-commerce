<?php

use app\core\App;

?>
<?php if(sizeof($rows) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-3 col">
          <?php
            if(isset($sort['email'])) {
              $order['sort'] = 'email';
              $order['order'] = ($sort['email'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'email';
              $order['order'] = 'desc';
            }
            $sort_url = App::$app->router()->UrlTo('comments', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Email
            <?php if(isset($sort['email'])) : ?>
              <small>
                <i class="fa <?= ($order['order'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-3 col">
          <?php
            if(isset($sort['title'])) {
              $order['sort'] = 'title';
              $order['order'] = ($sort['title'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'title';
              $order['order'] = 'desc';
            }
            $sort_url = App::$app->router()->UrlTo('comments', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Title
            <?php if(isset($sort['title'])) : ?>
              <small>
                <i class="fa <?= ($order['order'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-2 col">
          <?php
            if(isset($sort['dt'])) {
              $order['sort'] = 'dt';
              $order['order'] = ($sort['dt'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'dt';
              $order['order'] = 'desc';
            }
            $sort_url = App::$app->router()->UrlTo('comments', $order);
          ?>
          <a data-sort title="Click to sort by this column" href="<?= $sort_url ?>">
            Date
            <?php if(isset($sort['dt'])) : ?>
              <small>
                <i class="fa <?= ($order['order'] == 'desc') ? 'fa-sort-amount-desc' : 'fa-sort-amount-asc' ?>"></i>
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
      <?php
      $prms['id'] = (int)$row['id'];
      $prms['action'] = $row['moderated'] == '1' ? '0' : '1';
      ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Email</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row cut-text-in-one-line"><?= $row['email']; ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Title</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= $row['title'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Date</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row"><?= date("m/d/Y", strtotime($row['dt'])) ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Visibility</div>
            </div>
            <div class="col-xs-8 col-sm-12 xs-text-left">
              <div class="row">
                <a class="comment-moderated-action <?= $row['moderated'] == '0' ? '' : 'text-danger'; ?>"
                   data-status="<?= $row['moderated'] == '1' ? '0' : '1' ?>"
                   data-id="<?= $row['id'] ?>"
                   href="<?= App::$app->router()->UrlTo('comments/moderate', $prms) ?>">
                  <?= $row['moderated'] == '0' ? 'Publish' : 'Hide'; ?>
                </a>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1 text-right action-buttons">
            <a data-modify
               href="<?= App::$app->router()->UrlTo('comments/edit', $prms) ?>"
               title="Edit comment"><i class="fa fa-2x fa-pencil"></i>
            </a>
            <a data-view class="text-success view-comment"
               href="<?= App::$app->router()->UrlTo('comments/view', $prms) ?>"
               title="View comment"><i class="fa fa-2x fa-eye"></i>
            </a>
            <a data-delete class="text-danger del_user"
               href="<?= App::$app->router()->UrlTo('comments/delete', $prms); ?>"
               title="Delete comment"><i class=" fa fa-2x fa-trash-o"></i>
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
