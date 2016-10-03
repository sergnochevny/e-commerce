<tr>
  <td data-group="<?= $row[0] ?>" class="colour-id"><?= $row[0] ?></td>
  <td data-group="<?= $row[0] ?>" class="colour-name"><?= $row[1] ?></td>
  <td width="45" class="text-center">
    <a class="colour-update"
       data-id="<?= $row[0] ?>"
       data-name="<?= $row[1] ?>"
       data-href="<?= _A_::$app->router()->UrlTo('colours/update', $options); ?>">
      <i class="fa fa-pencil"></i>
    </a>
    <a class="colour-delete text-danger"
       data-id="<?= $row[0] ?>"
       data-href="<?= _A_::$app->router()->UrlTo('colours/delete', $options); ?>">
      <i class="fa fa-trash"></i>
    </a>
  </td>
</tr>