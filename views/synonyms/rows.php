<?php if(sizeof($data) > 0): ?>
  <div class="data-view">
    <div class="col-xs-12 table-list-header hidden-xs">
      <div class="row">
        <div class="col-sm-4 col">
          <?php
            if(isset($sort['keywords'])) {
              $order['sort'] = 'keywords';
              $order['order'] = ($sort['keywords'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'keywords';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('synonyms', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Keywords
            <?php if(isset($sort['keywords'])) : ?>
              <small>
                <i class="fa <?= ($sort['keywords'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
        <div class="col-sm-7 col">
          <?php
            if(isset($sort['synonyms'])) {
              $order['sort'] = 'synonyms';
              $order['order'] = ($sort['synonyms'] == 'desc' ? 'asc' : 'desc');
            } else {
              $order['sort'] = 'synonyms';
              $order['order'] = 'desc';
            }
            $sort_url = _A_::$app->router()->UrlTo('synonyms', $order);
          ?>
          <a data-sort href="<?= $sort_url ?>">
            Synonyms
            <?php if(isset($sort['synonyms'])) : ?>
              <small>
                <i class="fa <?= ($sort['synonyms'] == 'desc') ? 'fa-chevron-down' : 'fa-chevron-up' ?>"></i>
              </small>
            <?php endif; ?>
          </a>
        </div>
      </div>

      <form data-sort>
        <input type="hidden" name="sort" value="<?= array_keys($sort)[0] ?>">
        <input type="hidden" name="order" value="<?= array_values($sort)[0] ?>">
      </form>

    </div>
    <?php foreach($data as $row): ?>
      <?php $prms['id'] = $row['id']; ?>
      <div class="col-xs-12 table-list-row">
        <div class="row">
          <div class="col-xs-12 col-sm-4 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Keywords</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row['keywords'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-7 table-list-row-item">
            <div class="col-xs-4 visible-xs">
              <div class="row">Synonyms</div>
            </div>
            <div class="col-xs-8 col-sm-12">
              <div class="row"><?= $row['synonyms'] ?></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
            <a data-modify href="<?= _A_::$app->router()->UrlTo('synonyms/edit', $prms) ?>">
              <i class="fa fa-2x fa-pencil"></i>
            </a>
            <a href="<?= _A_::$app->router()->UrlTo('synonyms/delete', $prms) ?>" data-delete rel="nofollow"
               class="text-danger">
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

