<tr>
  <td><?= $row[0] ?></td>
  <td><?= $row[1] ?></td>
  <td width="45" class="text-center">
    <a href="<?= _A_::$app->router()->UrlTo('colours/update', $options); ?>"><i class="fa fa-pencil"></i></a>
    <a href="<?= _A_::$app->router()->UrlTo('colours/delete', $options); ?>" class="text-danger"><i class="fa fa-trash"></i></a>
  </td>
</tr>