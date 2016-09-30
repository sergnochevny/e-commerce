<body class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<div class="site-container">
  <?php include "views/header.php"; ?>
  <div class="main-content main-content-shop">
    <div class="container">
      <div id="content" class="main-content-inner" role="main">

        <?php if(isset($warning)){ ?>
          <div class="danger">
            <?php
              foreach($warning as $msg){
                echo $msg."\r\n";
              }
            ?>
          </div>
        <?php } ?>

        <div class="text-center">
          <a href="<?= _A_::$app->router()->UrlTo('categories/add');?>">
            <input type="submit" value="ADD NEW COLOR" class="button"/>
          </a><br><br><br>
        </div>
        <div>
          <table class="table table-striped table-bordered">
            <thead>
            <tr>
              <th class="text-left">id</th>
              <th class="text-center">Name</th>
              <th></th>
            </tr>
            </thead>
            <tbody><?= $list; ?></tbody>
          </table>
        </div>
        <br/>
        <nav class="paging-navigation" role="navigation">
          <h4 class="sr-only">Post navigation</h4>
          <ul class="pagination">
            <?= isset($paginator) ? $paginator : ''; ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>