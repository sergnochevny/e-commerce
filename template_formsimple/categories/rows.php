<table class="table table-striped table-bordered">
  <thead>
  <tr>
    <th class="text-center">Name</th>
    <th class="text-center">Display Order</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($rows as $row): ?>
    <?php
    $prms['cid'] = $row[0];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    ?>
    <tr>
      <td>
        <div class="text-center"><?= $row[1] ?></div>
      </td>
      <td>
        <div class="text-center"><?= $row[2] ?></div>
      </td>
      <td>
        <div class="text-center">
          <figcaption>
            <a href="<?= _A_::$app->router()->UrlTo('categories/edit', $prms) ?>" class="">
              <iclass="fa fa-pencil"></i>
            </a>
            <a href="<?= _A_::$app->router()->UrlTo('categories/delete', $prms) ?>" data-delete rel="nofollow"
               class="text-danger <?= ($row[2]>0)?'disabled':''?>">
              <i class=" fa fa-trash-o"></i>
            </a>
          </figcaption>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

