<tr>
  <td data-group="<?= $row[0] ?>" class="colour-name-container text-left">
    <span class="c-name"><?= $row[1] ?></span>
  </td>
  <td class="text-center">
    <span class="amount"><?= $row[2] ?></span>
  </td>
  <td width="45" class="text-center">
    <a class="colour-update"
       data-id="<?= $row[0] ?>"
       data-name="<?= $row[1] ?>"
       data-href="<?= _A_::$app->router()->UrlTo('colours/update' ); ?>">
      <i class="fa fa-pencil"></i>
    </a>
    <a class=" text-danger <?= $row[2] > 0 ? 'colour-delete-disabled' : 'colour-delete'; ?>"
       data-id="<?= $row[0] ?>"
       data-href="<?= _A_::$app->router()->UrlTo('colours/delete', $options); ?>">
      <i class="fa fa-trash"></i>
    </a>
  </td>
</tr>