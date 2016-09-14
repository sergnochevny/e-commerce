<script type="text/javascript">
    function sendComment(address, id){
        var title = jQuery("#comment_title").attr("value");
        var data = jQuery("#comment_data").attr("value");
        var messageBlock = jQuery("#comment-message-error");
        var commentPublic = jQuery("#comment_public");
        var pub = commentPublic.attr("checked");

        pub = (pub != 'checked') ? 0 : 1;

        jQuery.post(
            address,
            {comment_data : data, comment_title : title, ID : id, publish : pub},
            function(data){
                if(data.length > 0){
                    messageBlock.html(data);
                        if(messageBlock.attr('display') != 'none') {
                            messageBlock.stop().slideDown(400);
                        }
                    messageBlock.delay(5000);
                    messageBlock.stop().slideUp(400);
                }
            }
        );
    }
</script>
<form class="form-horizontal comment-form container-fluid" method="post">
    <fieldset>
        <legend>Edit comment</legend>

        <div id="comment-message-error" class="comment-message-error"></div>
        <div class="form-group row" id="comment-form-head">
            <label class="col-md-3 control-label" for="comment_title">Title</label>
            <div class="col-md-8">
                <input id="comment_title" name="comment_title" class="form-control input-md" type="text" value="<?= isset($title) ? $title : '' ?>">
            </div>
        </div>
        <div class="form-group row" id="comment-form-data">
            <label class="col-md-3 control-label" for="comment_data">Comment text</label>
            <div class="col-md-8">
                <textarea class="form-control" id="comment_data" name="comment_data"><?= isset($data) ? $data : "" ?></textarea>
                <div class="row col-md-4">
                    <input type="checkbox" id="comment_public" name="comment_public" class="" <?php if($moderated == 1) echo "checked"; ?> >
                    <label for="comment_public" class="">Public comment</label>
                </div>
            </div>
        </div>
        <div class="form-group row" id="comment-form-save">
            <label class="col-md-3 control-label" for="add-form-send"></label>
            <div class="col-md-8">
                <a id="add-form-send" name="comment-send-button" class="comment-button btn" onclick='sendComment("<?= _A_::$app->router()->UrlTo('comment_update_save', ['ID' => $_GET['ID']]);?>")'>Save</a>
            </div>
        </div>

    </fieldset>
</form>

