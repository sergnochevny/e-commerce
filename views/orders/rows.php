<div>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th class="text-left">Order</th>
        <?php if(Controller_Admin::is_logged()): ?>
          <th class="text-center">Customer</th>
        <?php endif; ?>
        <th class="text-center">Date</th>
        <th class="text-center">Status</th>
        <th class="text-center">Shipping</th>
        <th class="text-center">Discount</th>
        <th class="text-center">Total</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($rows as $row): ?>
        <?php
        $prms['oid'] = $row[0];
        if(!is_null(_A_::$app->get('page'))) $prms['page'] = _A_::$app->get('page');
        $edit_url = _A_::$app->router()->UrlTo('orders/edit', $prms);
        $view_url = _A_::$app->router()->UrlTo('orders/view', $prms);
        ?>
        <tr>
          <td class="text-left" style="max-width: 300px;"><span class="cut-text-in-one-line"><?= $row['trid'] ?></span>
          </td>
          <?php if(!isset($user_id)): ?>
            <td class="text-center"><?= $row['username'] ?></td>
          <?php endif; ?>
          <td class="text-center"><?= date("F m, Y", $row['order_date']) ?></td>
          <td class="text-center">
            <?= $row['status'] == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>' ?>
          </td>
          <td class="text-center"><?= '$' . number_format($row['shipping_cost'], 2); ?></td>
          <td class="text-center"><?= '$' . number_format($row['total_discount'], 2); ?></td>
          <td class="text-center"><?= '$' . number_format($row['total'], 2); ?></td>
          <td width="50px">
            <?php if(Controller_Admin::is_logged()): ?>
              <a class="update" data-modify href="<?= $edit_url ?>"><i class="fa fa-pencil"></i></a>
            <?php endif; ?>
            <a href="<?= $view_url ?>"><i class="fa fa-eye"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
