
<?php foreach($rows as $row): $prms['cid'] = $row[0]; if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page'); ?>
  <div class="col-xs-12 col-sm-6 data-list-view-item-container">
    <div class="row">
        <div class="col-xs-7 col-sm-6 xs-text-center">
            <small class="data-hint">Category name</small><br>
            <?= $row[1] ?>
          </div>
          <div class="col-xs-5 col-sm-5 xs-text-center">
            <small class="data-hint">Display order</small><br>
            <?= $row[2] ?>
          </div>
          <div class="col-xs-12 col-sm-1 xs-text-center xs-buttons-container buttons-container text-right">
            <a data-modify href="<?= _A_::$app->router()->UrlTo('categories/edit', $prms) ?>">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="<?= _A_::$app->router()->UrlTo('categories/delete', $prms) ?>" data-delete rel="nofollow"
               class="text-danger <?= ($row[2]>0)?'disabled':''?>">
              <i class=" fa fa-trash-o"></i>
            </a>
          </div>
    </div>
  </div>
<?php endforeach; ?>

<!---->
<!--<table class="table table-striped table-bordered">-->
<!--  <thead>-->
<!--  <tr>-->
<!--    <th class="text-center">Name</th>-->
<!--    <th class="text-center">Display Order</th>-->
<!--    <th></th>-->
<!--  </tr>-->
<!--  </thead>-->
<!--  <tbody>-->
<!--  --><?php //foreach($rows as $row): ?>
<!--    --><?php
//    $prms['cid'] = $row[0];
//    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
//    ?>
<!--    <tr>-->
<!--      <td>-->
<!--        <div class="text-center"></div>-->
<!--      </td>-->
<!--      <td>-->
<!--        <div class="text-center"></div>-->
<!--      </td>-->
<!--      <td>-->
<!--        <div class="text-center">-->
<!--          <figcaption>-->
<!--            <a data-modify href="--><?// _A_::$app->router()->UrlTo('categories/edit', $prms) ?><!--">-->
<!--              <i class="fa fa-pencil"></i>-->
<!--            </a>-->
<!--            <a href="--><?// _A_::$app->router()->UrlTo('categories/delete', $prms) ?><!--" data-delete rel="nofollow"-->
<!--               class="text-danger --><?// ($row[2]>0)?'disabled':''?><!--">-->
<!--              <i class=" fa fa-trash-o"></i>-->
<!--            </a>-->
<!--          </figcaption>-->
<!--        </div>-->
<!--      </td>-->
<!--    </tr>-->
<!--  --><?php //endforeach; ?>
<!--  </tbody>-->
<!--</table>-->

