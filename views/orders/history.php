<div class="container">
  <div id="content" class="main-content-inner" role="main">

    <div class="col-lg-12">
      <div class="row">
        <form action="orders_history" method="get">

          <div class="col-xs-11" style="padding-right: 0;">
            <div class="row">
              <input type="text" style="width: 100%"
                     value="<?= (!is_null(_A_::$app->get('orders_search_query')) ? _A_::$app->get('orders_search_query') : null) ?>"
                     name="orders_search_query" class="col-lg-12" placeholder="Search...">
            </div>
          </div>
          <div class="col-xs-1 text-right" style="padding-right: 0 !important;">
            <a title="Search" style="height: 34px" class="btn small" type="submit" name="find">
              <iclass
              ="fa fa-search"></i>
            </a>
          </div>
        </form>
        <br>
      </div>
    </div>

    <table class="table table-striped table-bordered">
      <thead>
      <tr>
        <th style="max-width: 360px;">Transaction id</th>
        <th class="text-center">User</th>
        <th>Order date</th>
        <th class="text-center">Delivery date</th>
        <th>Track code</th>
        <th class="text-center">Status</th>
        <th class="text-center">Total</th>
        <th></th>

      </tr>
      </thead>
      <tbody>
      <?= isset($admin_orders_list) ? $admin_orders_list : ''; ?>
      </tbody>
    </table>
  </div>

  <nav role="navigation" class="paging-navigation">
    <h4 class="sr-only">Navigation</h4>
    <ul class='pagination'>
      <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
  </nav>

</div>