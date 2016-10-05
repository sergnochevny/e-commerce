<?php if(isset($user_id)): ?>
  <div class="col-md-12 text-center">
    <span><b class="h4"><?= $is_admin ? $rows[0]['username'] : 'My' ?> Orders</b></span>
  </div>
<?php endif; ?>
<div>
  <table class="table table-striped table-bordered">
    <thead>
    <tr>
      <?php if($is_admin): ?>
        <th class="text-left">Order</th>
        <?php if(!isset($user_id)): ?>
          <th class="text-center">Customer</th>
        <?php endif; ?>
        <th class="text-center">Date</th>
        <th class="text-center">Status</th>
        <th class="text-center">Shipping</th>
        <th class="text-center">Discount</th>
        <th class="text-center">Total</th>
        <th></th>
      <?php else: ?>
        <th class="text-left">Order</th>
        <th class="text-center">Date</th>
        <th class="text-center">Status</th>
        <th class="text-center">Shipping</th>
        <th class="text-center">Discount</th>
        <th class="text-center">Total</th>
        <th></th>
      <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach($rows as $row): ?>
      <?php
      $prms['oid'] = $row[0];
      $detail_url = _A_::$app->router()->UrlTo('orders/info', $prms);
      ?>
      <?php if($is_admin): ?>
        <?php
        $prms['oid'] = $row[0];
        $edit_url = _A_::$app->router()->UrlTo('orders/edit', $prms);
        ?>
        <tr>
          <td class="text-left" style="max-width: 360px;"><span class="cut-text-in-one-line"><?= $row['trid'] ?></span>
          </td>
          <?php if(!isset($user_id)): ?>
            <td class="text-center"><?= $row['username'] ?></td>
          <?php endif; ?>
          <td class="text-center"><?= date("F m, Y", $row['order_date']) ?></td>
          <td class="text-center">
            <?= $row['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
          </td>
          <td class="text-center"><?= '$' . number_format($row['shipping_cost'],2); ?></td>
          <td class="text-center"><?= '$' . number_format($row['total_discount'],2); ?></td>
          <td class="text-center"><?= '$' . number_format($row['total'],2);?></td>
          <td width="50px">
            <a href="<?= $edit_url; ?>" title="Detail info" class="fa fa-pencil"></a>
            <a href="<?= $detail_url; ?>" title="Detail info" class="fa fa-eye"></a>
          </td>
        </tr>
      <?php else: ?>
        <tr>
          <td class="text-left" style="max-width: 360px;"><span class="cut-text-in-one-line"><?= $row['trid'] ?></span>
          </td>
          <td><?= date("F m, Y", $row['order_date']) ?></td>
          <td class="text-center">
            <?= $row['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
          </td>
          <td><?= '$' . number_format($row['shipping_cost']); ?></td>
          <td><?= '$' . number_format($row['total_discount']); ?></td>
          <td class="text-center"><?= $row['total'] ?></td>
          <td>
            <a href="<?= $detail_url; ?>" title="Detail info" class="fa fa-eye"></a>
          </td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
