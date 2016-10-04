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

        <div class="col-xs-12 notification danger hidden">123</div>

        <div id="confirm-dialog" class="overlay"></div>
        <div class="popup">
          <div class="fcheck"></div>
          <a class="close" title="close">&times;</a>
          <div class="b_cap_cod_main">
            <p style="color: black;" class="text-center"><b>Do you confirm removal?</b></p>
            <br/>
            <div class="text-center" style="width: 100%">
              <input type="button" value="Yes I do" class="button confirm"/>
              <input type="button" value="Cancel" class="button dismiss"/>
            </div>
          </div>
        </div>

        <div id="modal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="modal-title" class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <div id="modal_content">

                </div>
              </div>
              <div class="modal-footer">
                <button href="filter" type="button" class="btn-primary save-data" data-dismiss="modal">
                  Save
                </button>
                <button type="button" class="btn-default" data-dismiss="modal">
                  Cancel
                </button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="text-center">
          <a data-href="<?= _A_::$app->router()->UrlTo('colours/create');?>"
             class="button colour-create">
            ADD NEW COLOR
          </a><br><br><br>
        </div>
        <div>
          <table class="table table-striped table-bordered">
            <thead>
            <tr>
              <th class="text-left">Name</th>
              <th class="text-center">Products</th>
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
<script src='<?= _A_::$app->router()->UrlTo('views/js/colours/crud.js'); ?>' type="text/javascript"></script>