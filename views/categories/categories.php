<div class="container inner-offset-top half-outer-offset-bottom">
  <div id="content" class="col-xs-12 main-content-inner box" role="main">
    <?= $list ?>
  </div>
</div>

<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
  <div class="fcheck"></div>
  <a class="close" href="javascript:void(0)" title="close"><i class="fa fa-times" aria-hidden="true"></i></a>
  <div class="b_cap_cod_main">
    <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
    <br/>
    <div class="text-center" style="width: 100%">
      <input id="confirm_action" type="button" value="Yes confirm" class="button"/>
      <input id="confirm_no" type="button" value="No" class="button"/>
    </div>
  </div>
</div>
<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 id="modal-title" class="modal-title text-center"></h4>
      </div>
      <div class="modal-body clearfix">
        <div id="modal_content">

        </div>
      </div>
      <div class="modal-footer">
        <input type="button" class="button save-data" data-dismiss="modal" value="Save"/>
        <input type="button" class="button" data-dismiss="modal" value="Cancel"/>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src='<?= _A_::$app->router()->UrlTo('views/js/simple/simples.min.js'); ?>' type="text/javascript"></script>