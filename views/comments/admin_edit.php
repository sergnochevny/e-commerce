<script src='<?= _A_::$app->router()->UrlTo('views/js/comments/admin_edit.js'); ?>' type ="text/javascript"></script>
<form class="form-horizontal comment-form container-fluid" method="post">
    <fieldset>
        <legend>Edit comment</legend>
        <div id="comment-message-error" class="comment-message-error"></div>
        <div class="form-row" id="comment-form-head">
            <div class="col-md-12">
                <label for="comment_title"><b>Title</b></label>
                <input id="comment_title" name="comment_title" class="form-control input-md" type="text" value="<?= isset($title) ? $title : '' ?>">
            </div>
        </div>
        <div class="form-row" id="comment-form-data">
            <div class="col-md-12">
                <label for="comment_data"><b>Comment text</b></label>
                <textarea class="form-control" id="comment_data" name="comment_data"><?= isset($data) ? $data : "" ?></textarea>
            </div>
        </div>
        <div class="form-row" id="comment-form-data">
            <div class="col-md-12">
                <label for="comment_public" class="">
                    <input type="checkbox" id="comment_public" name="comment_public" class="" <?php if($moderated == 1) echo "checked"; ?> >
                    <b>Public comment</b>
                </label>
            </div>
        </div>
        <div class="form-row" id="comment-form-save">
            <div class="col-md-12">
                <a id="add-form-send"
                   name="comment-send-button"
                   class="comment-button btn"
                   onclick='sendComment("<?= _A_::$app->router()->UrlTo('edit', [
                       'ID' => _A_::$app->get('ID')
                   ]);?>")'>
                    <b>Save</b>
                </a>
            </div>
        </div>

    </fieldset>
</form>

