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


<section class="just-posts-grid">
  <div class="just-post-row row">
    <div class="just-post col-xs-6" id="blog-page">
      <h3 id="editable_title" class="page-title">
        <span class="hang-punct">&laquo;</span><?= $data['post_title']; ?><span class="punct">&raquo;</span>
      </h3>
    </div>
    <div class="col-xs-6">
      <?php if(isset($data['img'])) { ?>
        <div id="post_img" class="just-post-image"
             style="background-image: url('<?= $data['img']; ?>');">
        </div>
        <input type="file" id="uploadfile" name="uploadfile" style="position: absolute; margin: -5px 0px 0px -175px; padding: 0px; width: 220px; height: 30px; font-size: 14px; opacity: 0; cursor: pointer; display: none; z-index: 2147483583; top: 401px; left: 759px;">
      <?php } ?>
    </div>
    <div class="col-xs-12">
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
  </div>
</section>

<!--<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable" tabindex="-1" role="dialog"-->
<!--     data-id="blog_post_form_dialog" aria-describedby="blog_post_form_dialog" aria-labelledby="ui-id-1"-->
<!--     style="height: auto; width: 600px; top: 100px; left: 261px; display: none; z-index: 102;">-->
<!--  <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle">-->
<!--    <span id="ui-id-1" class="ui-dialog-title">Saving Article.</span>-->
<!--    <button id="close"-->
<!--            type="button"-->
<!--            class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close"-->
<!--            role="button"-->
<!--            title="Close">-->
<!--      <span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>-->
<!--      <span class="ui-button-text">Close</span>-->
<!--    </button>-->
<!--  </div>-->
<div id="dialog" style="width: auto; display: none;">
  <form method="POST" id="edit_form" action="<?= $action; ?>" class="enquiry-form ">
    <input type="hidden" name="post_title" value="">
    <input type="hidden" name="post_content" value="">
    <input id="img" type="hidden" name="img" value="<?= $data['file_img']; ?>"/>
    <input type="hidden" name="date" value="<?= $data['post_date']; ?>">
    <div class="col-md-12 col-xs-12">
      <div id="alert" class="form-row">
        <?php
          if(isset($warning)) {
            echo '<div class="col-xs-12 alert-success danger" style="display: none;">';
            foreach($warning as $msg) {
              echo $msg . "<br>";
            }
            echo '</div>';
          }

          if(isset($error)) {
            echo '<div class="col-xs-12 alert-danger danger" style="display: none;">';
            foreach($error as $msg) {
              echo $msg . "<br>";
            }
            echo '</div>';
          }
        ?>
      </div>

      <div class="form-row">
        <label class="required_field"><strong>Post Categories:</strong></label>
        <div>
          <?= $data['categories']; ?>
        </div>
      </div>
      <hr/>

      <div class="form-row">
        <label class="required_field" for="ed_f_desc"><strong>Description:</strong></label>
        <textarea class="input-text" id="ed_f_desc" cols="5" rows="2"
                  name="description"><?= $data['description']; ?></textarea>
      </div>

      <div class="form-row">
        <label class="required_field" for="ed_f_keyw"><strong>Keywords:</strong></label>
        <input type="text" name="keywords" id="ed_f_keyw" value="<?= $data['keywords']; ?>" class="input-text">
      </div>

      <hr/>

      <div class="form-row">
        <label><strong>Publish:</strong></label>
        <?= (isset($data['post_status']) && ($data['post_status'] == "publish")) ? '<input type="checkbox" checked="checked" name="status" value="publish" class="input-checkbox">' : '<input type="checkbox" name="status" value="publish" class="input-checkbox">'; ?>
      </div>

      <div class="col-xs-12">
        <div class="text-center">
          <br/>
          <input id="save" type="button" value="Save" class="button" style="width: 150px;">
          <br/>
        </div>
      </div>
    </div>
  </form>
</div>
<!--</div>-->
<!--<div data-id="blog_post_form_dialog" class="ui-widget-overlay ui-front" style="display:none; z-index: 100;"></div>-->
<form id="categories">
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

<div class="col-xs-12">
  <div class="text-center">
    <br/>
    <input id="pre_save" type="button" value="Save" class="button" style="width: 150px;">
    <br/>
  </div>
</div>

<script src='<?= _A_::$app->router()->UrlTo('views/js/inputmask/jquery.inputmask.bundle.min.js'); ?>'
        type="text/javascript"></script>
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/form.js'); ?>' type="text/javascript"></script>
