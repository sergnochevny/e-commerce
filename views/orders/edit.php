<body
  class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">
<link rel="stylesheet" href="<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.css'); ?>">
<script src="<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.js'); ?>"></script>
<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div class="container">
      <div id="content" class="main-content-inner" role="main">
        <a href="<?= $back_url ?>"><input type="button" value="Back" class="button"></a>

        <div class="col-xs-12">

          <div class="row">
            <div class="col-xs-12 alert-success success" style="display: none; margin-bottom:0;"></div>
            <div class="col-xs-12 alert-danger danger" style="display: none; margin-bottom:0;"></div>
          </div>

          <br>

          <div class="row">
            <form action="<?= _A_::$app->router()->UrlTo('orders/edit'); ?>" id="edit_orders_info"
                  method="post">
              <div class="col-xs-4">
                <div class="row">
                  <input type="text" id="track_code" style="width: 100%"
                         value="<?= ($order['track_code'] ? $order['track_code'] : null) ?>" name="track_code"
                         class="col-lg-12" placeholder="Add track code">
                </div>
              </div>
              <div class="col-xs-4">

                <select id="status_select" style="width: 100%; margin: 0; padding: 6px 10px" size="1" name="status">
                  <option value="0">In process</option>
                  <option value="1">Completed</option>
                </select>

              </div>
              <div class="col-xs-3" style="padding-left: 0">

                <input type="text" style="width: 100%; padding-left: 15px; padding-right: 15px"
                       name="end_date" id="dateFrom"
                       value="<?= !is_null($order['end_date']) ? $order['end_date'] : '' ?>" placeholder="Chose end date"
                       class="input-text ">

              </div>
              <div class="col-xs-1 text-right" style="padding: 0 !important;">
                <input type="hidden" name="order_id" value="<?= $order['oid']; ?>">
                <button title="Search" style="height: 34px;" class="btn small" type="submit"
                        id="edit_order_info" name="edit_order_info">
                  <b>Save</b>
                </button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>
  </div>