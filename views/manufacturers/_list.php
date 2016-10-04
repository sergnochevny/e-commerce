<tr>
  <td data-group="<?= $row[0] ?>" class="manufacturers-name-container text-center">
    <span class="c-name"><?= $row[1] ?></span>
  </td>
  <td class="text-center">
    <span class="amount"><?= $row[2] ?></span>
  </td>
  <td width="45" class="text-center">
    <a class="manufacturers-update"
       data-id="<?= $row[0] ?>"
       data-name="<?= $row[1] ?>"
       data-href="<?= _A_::$app->router()->UrlTo('manufacturers/update' ); ?>">
      <i class="fa fa-pencil"></i>
    </a>
    <a class=" text-danger <?= $row[2] > 0 ? 'manufacturers-delete-disabled' : 'manufacturers-delete'; ?>"
       data-id="<?= $row[0] ?>"
       data-href="<?= _A_::$app->router()->UrlTo('manufacturers/delete', $options); ?>">
      <i class="fa fa-trash"></i>
    </a>
  </td>
</tr>