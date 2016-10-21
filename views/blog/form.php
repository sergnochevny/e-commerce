<?php
  if(isset($warning)) {
    ?>
    <div class="col-xs-12 alert-success danger" style="display: none;">
      <?php
        foreach($warning as $msg) {
          echo '<span>' . $msg . '</span><br>';
        }
      ?>
    </div>
    <?php
  }
?>
<?php
  if(isset($error)) {
    ?>
    <div class="col-xs-12 alert-danger danger" style="display: none;">
      <?php
        foreach($error as $msg) {
          echo $msg . '<br>';
        }
      ?>
    </div>
    <?php
  }
?>


<form method="POST" id="edit_form" action="<?= $action; ?>" class="enquiry-form ">
  <section class="just-posts-grid blog-post-edit-in">
    <div class="just-post-row">
      <div class="just-post col-sm-12 col-md-10 col-md-offset-1" id="blog-page">
        <h3 id="editable_title">
          <b><span class="hang-punct">&laquo;</span><?= $data['post_title']; ?><span class="punct">&raquo;</span></b>
        </h3>
      </div>
      <div id="image" class="col-sm-12 col-md-10 col-md-offset-1">
        <?=$image;?>
      </div>
      <div class="col-xs-12 col-md-10 col-md-offset-1">
        <div class="just-post-detail">
          <div
            class="just-divider text-center line-yes icon-hide">
            <div class="divider-inner"
                 style="background-color: #fff">
              <span class="post-date"><?= $data['post_date']; ?></span>
            </div>
          </div>
          <div id="editable_content" class="text-justify"><?= $data['post_content']; ?></div>
        </div>
      </div>
      <div class="col-xs-12">
        <div class="text-center">
          <br/>
          <a id="pre_save" class="button" style="width: 150px;">Save</a>
        </div>
      </div>
    </div>
  </section>

  <div id="dialog" class="col-md-10 col-md-offset-1 hidden">
    <input type="hidden" name="post_title" value="">
    <input type="hidden" name="post_content" value="">
    <input type="hidden" name="post_author" value="<?= $data['post_author']; ?>">
    <input type="hidden" name="post_date" value="<?= $data['post_date']; ?>">
    <div class="col-md-12 col-xs-12">
      <div class="row">
        <div class="form-row">
          <label class="required_field"><strong>Post Categories:</strong></label>
          <div>
            <?= $data['categories']; ?>
          </div>
        </div>
        <div class="form-row">
          <label class="required_field" for="ed_f_desc"><strong>Description:</strong></label>
          <textarea class="input-text" id="ed_f_desc" cols="5" rows="2"
                    name="description"><?= $data['description']; ?></textarea>
        </div>
        <div class="form-row">
          <label class="required_field" for="ed_f_keyw"><strong>Keywords:</strong></label>
          <input type="text" name="keywords" id="ed_f_keyw" value="<?= $data['keywords']; ?>" class="input-text">
        </div>
        <div class="form-row">
          <label><strong>Publish:</strong></label>
          <input type="checkbox" <?= (isset($data['post_status']) && ($data['post_status'] == "publish")) ? 'checked' : ''; ?> name="post_status" value="publish" class="input-checkbox">
        </div>
        <div class="col-xs-12">
          <div class="text-center">
            <br/>
            <a id="save" data-modify class="button" style="width: 150px;">Save</a>
            <a id="cancel" data-modify class="button" style="width: 150px;">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 id="modal-title" class="modal-title text-center"></h4>
        </div>
        <div class="modal-body" style="padding: 0;">
          <div id="modal_content">
          </div>
        </div>
        <div class="modal-footer">
          <a id="build_filter" href="filter" class="btn btn-primary" data-dismiss="modal">Ok</a>
          <a class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</form>

<script src='<?= _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>'
        type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/form.js'); ?>' type="text/javascript"></script>
