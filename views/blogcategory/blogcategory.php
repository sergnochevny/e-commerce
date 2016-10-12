<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?= $list ?>
            </div>
        </div>

        <div id="confirm_dialog" class="overlay"></div>

        <div class="popup">
            <div class="fcheck"></div>
            <a class="close" title="close">&times;</a>

            <div class="b_cap_cod_main">
                <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
                <br/>
                <div class="text-center" style="width: 100%">
                    <a id="confirm_action"><input type="button" value="Yes confirm" class="button"/></a>
                    <a id="confirm_no"><input type="button" value="No" class="button"/></a>
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
                        <a class="btn btn-primary save-data" data-dismiss="modal">Save</a>
                        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script src='<?= _A_::$app->router()->UrlTo('views/js/simple/simples.js'); ?>' type="text/javascript"></script>
