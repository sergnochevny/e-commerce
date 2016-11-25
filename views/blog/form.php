<?php include_once 'views/messages/alert-boxes.php'; ?>
<form method="POST" id="edit_form" action="<?= $action; ?>" class="enquiry-form ">
  <section class="just-posts-grid blog-post-edit-in">
    <div class="just-post-row">
      <div class="col-sm-12 col-md-10 col-md-offset-1 text-center">
        <h3 id="editable_title">
          <b><?= $data['post_title']; ?></b>
        </h3>
      </div>
      <div id="image" class="col-sm-12 col-md-10 col-md-offset-1">
        <?= $image; ?>
        <span class="upd-img-line"><i data-post_img class="fa fa-2x fa-edit"></i></span>
      </div>
      <div class="col-xs-12 col-md-10 col-md-offset-1">
        <div class="just-post-detail">
          <div class="just-divider text-center line-yes icon-hide">
            <div class="divider-inner">
              <span class="post-date"><?= $data['post_date'] ?></span>
            </div>
          </div>
          <div id="editable_content" class="text-justify empty-post-area">
            <?= !empty($data['post_content']) ? $data['post_content'] : ''; ?>
          </div>
        </div>
      </div>
      <div class="col-xs-12">
        <div class="text-center">
          <br/>
          <input id="pre_save" class="button" type="button" style="width: 150px;" value="Save"/>
        </div>
      </div>
    </div>
  </section>

  <div id="dialog" class="col-md-10 col-md-offset-1 hidden">
    <input type="hidden" name="post_title" value="">
    <input type="hidden" name="post_content" value="">
    <input type="hidden" name="post_author" value="<?= $data['post_author']; ?>">
    <input type="hidden" name="post_date" value="<?= $data['post_date']; ?>">
    <div class="col-xs-12">
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
          <input
            type="checkbox" <?= (isset($data['post_status']) && ($data['post_status'] == "publish")) ? 'checked' : ''; ?>
            name="post_status" value="publish" class="input-checkbox">
        </div>
        <div class="col-xs-12">
          <div class="text-center">
            <br/>
            <a id="save"  href="save" data-modify class="button" style="width: 150px;">Save</a>
            <a id="cancel"  href="cancel" data-modify class="button" style="width: 150px;">Cancel</a>
          </div>
        </div>
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
        <div class="modal-body" style="padding: 0;">
          <div id="modal_content">
          </div>
        </div>
        <div class="modal-footer">
          <button id="build_filter" href="filter" class="button" data-dismiss="modal">Ok</button>
          <button class="button" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/form.js'); ?>' type="text/javascript"></script>
