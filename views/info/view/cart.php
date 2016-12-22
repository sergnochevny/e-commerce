<div id="modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 id="modal-title" class="modal-title text-center"><?=$rows['title'];?></h4>
      </div>
      <div class="modal-body">
        <div id="modal_content">
          <?= $rows['message']; ?>
        </div>
      </div>
      <div class="modal-footer">
        <input type="button" data-dismiss="modal" aria-hidden="true" value="Close" class="button"/>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<input type="hidden" data-timeout="<?=$rows['f2'];?>">