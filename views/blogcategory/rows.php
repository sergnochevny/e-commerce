<table class="table table-striped table-bordered">
  <thead>
  <tr>
    <th class="text-left">Name</th>
    <th></th>
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
      <td data-group="<?= $row[0] ?>" class="colour-name-container text-left">
        <span class="c-name"><?= $row[1] ?></span>
      </td>
      <td class="text-center">
        <span class="amount">
        <?php if($row[2] > 0) { ?>
          <a href="<?= _A_::$app->router()->UrlTo('blog', ['cat' => $row['group_id']]); ?>"
             class="" rel="nofollow"> <?= $row['amount']; ?> <i class="fa fa-chevron-circle-right"></i>
                </a>
        <?php } else { ?>
          <?= $row[2]; ?>
        <?php } ?></span>
      </td>
      <td width="45" class="text-center">
        <a class="update"
           data-modify href="<?= _A_::$app->router()->UrlTo('blogcategory/edit', $prms); ?>">
          <i class="fa fa-pencil"></i>
        </a>
        <a class="text-danger <?= $row[2] > 0 ? 'disabled' : 'delete'; ?>"
           data-delete href="<?= _A_::$app->router()->UrlTo('blogcategory/delete', $prms); ?>">
          <i class="fa fa-trash"></i>
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
