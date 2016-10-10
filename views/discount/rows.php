<table class="table table-striped table-bordered">
  <thead>
  <tr>
    <th>Details</th>
    <th>Enabled</th>
    <th>Multiple</th>
    <th class="text-center">Coupon</th>
    <th class="text-center">Start Date</th>
    <th class="text-center">End Date</th>
    <th>
      <div class="text-center">Actions</div>
    </th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($rows as $row): ?>
    <?php
    $prms['sid'] = $row['sid'];
    if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
    $row['date_start'] = gmdate("M j, Y, g:i a", $row['date_start']);
    $row['date_end'] = gmdate("M j, Y, g:i a", $row['date_end']);
    $row['enabled'] = $row['enabled'] == "1" ? "YES" : "NO";
    $row['allow_multiple'] = $row['allow_multiple'] == "1" ? "YES" : "NO";
    ?>
    <tr>
      <td><span class="cut-text-in-one-line"><b><?= $row['discount_amount']; ?>
            % off </b><?= $row['discount_comment1']; ?></span>
      </td>
      <td>
        <div class="text-center"><?= $row['enabled']; ?></div>
      </td>
      <td>
        <div class="text-center"><?= $row['allow_multiple']; ?></div>
      </td>
      <td style="width: 120px">
        <div class="text-center"><?= !empty($row['coupon_code']) ? $row['coupon_code'] : 'N/A'; ?></div>
      </td>
      <td style="width: 185px" class="text-center"><?= $row['date_start']; ?></td>
      <td style="width: 185px">
        <div class="text-center"><?= $row['date_end']; ?></div>
      </td>
      <?php if(!isset($hide_action)) : ?>
        <td>
          <div class="text-center">
            <a data-waitloader rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/edit', $prms); ?>">
              <i class="fa fa-pencil"></i>
            </a>
            <a data-delete rel="nofollow" href="<?= _A_::$app->router()->UrlTo('discount/del', $prms); ?>">
              <i class=" fa fa-trash-o"></i>
            </a>
            <a data-waitloader class="text-success" rel="nofollow"
               href="<?= _A_::$app->router()->UrlTo('discount/usage', $prms); ?>">
              <i class="fa fa-check-circle"></i>
            </a>
          </div>
        </td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
