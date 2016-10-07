<table class="table table-striped table-bordered">
  <thead>
  <tr>
    <th class="text-left">Manufacturer</th>
    <th class="text-center">Products</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($rows as $row): ?>
    <?php
    $prms = ['id' => $row[0]];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    ?>
    <tr>
      <td data-group="<?= $row[0] ?>" class="name-container text-left">
        <span class="name"><?= $row[1] ?></span>
      </td>
      <td class="text-center">
        <span class="amount"><?= $row[2] ?></span>
      </td>
      <td width="45" class="text-center">
        <a class="update"
           data-modify href="<?= _A_::$app->router()->UrlTo('manufacturers/edit', $prms); ?>">
          <i class="fa fa-pencil"></i>
        </a>
        <a class="text-danger <?= $row[2] > 0 ? 'disabled' : 'delete'; ?>"
           data-delete href="<?= _A_::$app->router()->UrlTo('manufacturers/delete', $prms); ?>">
          <i class="fa fa-trash"></i>
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
