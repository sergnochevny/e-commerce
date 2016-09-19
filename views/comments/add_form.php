<script src='<?= _A_::$app->router()->UrlTo('views/js/comments/add_form.js'); ?>' type="text/javascript"></script>
<body class="archive">
    <div class="site-container">
        <?php include "views/header.php"; ?>
        <div class="main-content main-content-shop">
            <div class="container">
                <div id="content" class="main-content-inner" role="main">
                    
                    <form class="form-horizontal comment-form" method="post">
                        <fieldset>
                            <legend>Add comment</legend>
                            
                            <div id="comment-message-error"></div>
                            <div class="form-group" id="comment-form-head">
                                <label class="col-md-3 control-label" for="comment_title">Title</label>
                                <div class="col-md-8">
                                    <input id="comment_title" name="comment_title" class="form-control input-md" type="text">
                                </div>
                            </div>

                            <div class="form-group" id="comment-form-data">
                                <label class="col-md-3 control-label" for="comment_data">Comment text</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="comment_data" name="comment_data"></textarea>
                                </div>
                            </div>

                            <div class="form-group" id="comment-form-save">
                                <label class="col-md-3 control-label" for="add-form-send"></label>
                                <div class="col-md-8">
                                    <a id="add-form-send" name="comment-send-button" class="add-button btn comment-button" onclick='sendComment("<?= (BASE_URL . '/comment_save'); ?>")'>Send comment</a>
                                </div>
                            </div>

                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

