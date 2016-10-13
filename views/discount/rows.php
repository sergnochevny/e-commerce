<!--<table class="table table-striped table-bordered">-->
<!--  <thead>-->
<!--  <tr>-->
<!--    <th>Details</th>-->
<!--    <th>Enabled</th>-->
<!--    <th>Multiple</th>-->
<!--    <th class="text-center">Coupon</th>-->
<!--    <th class="text-center">Start Date</th>-->
<!--    <th class="text-center">End Date</th>-->
<!--    <th>-->
<!--      <div class="text-center">Actions</div>-->
<!--    </th>-->
<!--  </tr>-->
<!--  </thead>-->
<!--  <tbody>-->
<!--  --><?php //foreach($rows as $row): ?>
<!--    --><?php
//    $prms['sid'] = $row['sid'];
//    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
//    $row['date_start'] = gmdate("M j, Y, g:i a", $row['date_start']);
//    $row['date_end'] = gmdate("M j, Y, g:i a", $row['date_end']);
//    $row['enabled'] = $row['enabled'] == "1" ? "YES" : "NO";
//    $row['allow_multiple'] = $row['allow_multiple'] == "1" ? "YES" : "NO";
//    ?>
<!--    <tr>-->
<!--      <td><span class="cut-text-in-one-line"><b>--><? // $row['discount_amount']; ?>
<!--            % off </b>--><? // $row['discount_comment1']; ?><!--</span>-->
<!--      </td>-->
<!--      <td>-->
<!--        <div class="text-center">--><? // $row['enabled']; ?><!--</div>-->
<!--      </td>-->
<!--      <td>-->
<!--        <div class="text-center">--><? // $row['allow_multiple']; ?><!--</div>-->
<!--      </td>-->
<!--      <td style="width: 120px">-->
<!--        <div class="text-center">--><? // !empty($row['coupon_code']) ? $row['coupon_code'] : 'N/A'; ?><!--</div>-->
<!--      </td>-->
<!--      <td style="width: 185px" class="text-center">--><? // $row['date_start']; ?><!--</td>-->
<!--      <td style="width: 185px">-->
<!--        <div class="text-center">--><? // $row['date_end']; ?><!--</div>-->
<!--      </td>-->
<!--      --><?php //if(!isset($hide_action)) : ?>
<!--        <td>-->
<!--          <div class="text-center">-->
<!--            <a data-waitloader rel="nofollow" href="--><?//= _A_::$app->router()->UrlTo('discount/edit', $prms); ?><!--">-->
<!--              <i class="fa fa-pencil"></i>-->
<!--            </a>-->
<!--            <a data-delete rel="nofollow" href="--><?//= _A_::$app->router()->UrlTo('discount/del', $prms); ?><!--">-->
<!--              <i class=" fa fa-trash-o"></i>-->
<!--            </a>-->
<!--            <a data-waitloader class="text-success" rel="nofollow"-->
<!--               href="--><?//= _A_::$app->router()->UrlTo('discount/usage', $prms); ?><!--">-->
<!--              <i class="fa fa-check-circle"></i>-->
<!--            </a>-->
<!--          </div>-->
<!--        </td>-->
<!--      --><?php //endif; ?>
<!--    </tr>-->
<!--  --><?php //endforeach; ?>
<!--  </tbody>-->
<!--</table>-->


<div class="col-xs-12 table-list-header hidden-xs">
  <div class="row">
    <div class="col-sm-2 col">
      Details <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-1 col">
      On
    </div>
    <div class="col-sm-2 col">
      Multiple
    </div>
    <div class="col-sm-2 col">
      Coupon <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-2 col">
      Starts <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
    <div class="col-sm-2 col">
      Ends <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
    </div>
  </div>
</div>
<?php foreach($rows as $row): ?>
  <?php
  $prms['sid'] = $row['sid'];
  if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
  $row['date_start'] = gmdate("m/j/y, g:i a", $row['date_start']);
  $row['date_end'] = gmdate("m/j/y, g:i a", $row['date_end']);
  $row['enabled'] = $row['enabled'] == "1" ? "YES" : "NO";
  $row['allow_multiple'] = $row['allow_multiple'] == "1" ? "YES" : "NO";
  ?>
  <div class="col-xs-12 table-list-row">
    <div class="row">
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Details</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row cut-text-in-one-line"><?= $row['discount_amount']; ?>% off </b><?= $row['discount_comment1']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-1 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">On</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row['enabled'] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Multiple</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row['allow_multiple'] ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Coupon</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= !empty($row['coupon_code']) ? $row['coupon_code'] : 'N/A'; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Starts</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row['date_start']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 table-list-row-item">
        <div class="col-xs-4 visible-xs helper-row">
          <div class="row">Starts</div>
        </div>
        <div class="col-xs-8 col-sm-12">
          <div class="row"><?= $row['date_end']; ?></div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-1 col-md-1 text-right action-buttons">
        <a data-waitloader rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/edit', $prms); ?>">
          <i class="fa fa-pencil"></i>
        </a>
        <a data-waitloader class="text-success" rel="nofollow"
           href="<?= _A_::$app->router()->UrlTo('discount/usage', $prms); ?>">
          <i class="fa fa-check-circle"></i>
        </a>
        <a data-delete class="text-danger" rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/del', $prms); ?>">
          <i class=" fa fa-trash-o"></i>
        </a>
      </div>
    </div>
  </div>
<?php endforeach; ?>

