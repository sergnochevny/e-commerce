<tr>
  <td><?= $row[0] ?></td>
  <td><?= $row[1] ?></td>
  <td width="65" class="text-center">
    <a href="<?= _A_::$app->router()->UrlTo('colours/view', $options); ?>"><i class="fa fa-eye"></i></a>
    <a href="<?= _A_::$app->router()->UrlTo('colours/update', $options); ?>"><i class="fa fa-pencil"></i></a>
    <a href="<?= _A_::$app->router()->UrlTo('colours/delete', $options); ?>"><i class="fa fa-trash"></i></a>
  </td>
</tr>