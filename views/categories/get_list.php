<?php
  $opt['category_id'] = $row[0];
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
        <a href="<?= _A_::$app->router()->UrlTo('categories/edit', $opt) ?>" class=""><i class="fa fa-pencil"></i></a>
        <a href="<?= _A_::$app->router()->UrlTo('categories/del', $opt) ?>" id="del_category" rel="nofollow"
           class="text-danger">
          <i class=" fa fa-trash-o"></i>
        </a>
      </figcaption>
    </div>
  </td>
</tr>
