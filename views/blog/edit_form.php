
<section class="toko-posts-grid">
    <div class="toko-post-row row">
        <div class="toko-post col-xs-12" id="blog-page">
            <h1 id="editable_title" class="page-title"><?= $post_title; ?></h1>

            <?php if (isset($post_img)) { ?>
                <div id="post_img" class="toko-post-image"
                     style="background-image: url('<?= $post_img; ?>');">
                </div>
            <?php } ?>
            <div class="toko-post-detail">
                <div
                    class="toko-divider text-center line-yes icon-hide">
                    <div class="divider-inner"
                         style="background-color: #fff">
                        <span class="post-date"><?= $post_date;?></span>
                    </div>
                </div>
                <div id="editable_content"><?= $post_content;?></div>
            </div>

        </div>
    </div>
</section>

<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable" tabindex="-1" role="dialog" data-id="blog_post_form_dialog" aria-describedby="blog_post_form_dialog" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 100px; left: 261px; display: none; z-index: 102;"><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix ui-draggable-handle"><span id="ui-id-1" class="ui-dialog-title">Saving Article.</span><button id="close" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Close"><span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">Close</span></button></div><div id="blog_post_form_dialog" style="width: auto; min-height: 84px; max-height: none; height: auto;" class="ui-dialog-content ui-widget-content">
            <form method="POST" id="blog_post" action="<?= $action_url; ?>" class="enquiry-form ">
                <input type="hidden" name="title" value="">
                <input type="hidden" name="content" value="">
                <input id="img" type="hidden" name="img" value="<?= $file_img;?>"/>
                <input type="hidden" name="date" value="<?= $post_date;?>">

                <p id="alert" class="form-row">
                    <?php
                        if (isset($warning)) {
                            echo '<div class="col-xs-12 alert-success danger" style="display: none;">';
                            foreach ($warning as $msg) {
                                echo $msg . "<br>";
                            }
                            echo '</div>';
                        }

                        if (isset($error)) {
                            echo '<div class="col-xs-12 alert-danger danger" style="display: none;">';
                            foreach ($error as $msg) {
                                echo $msg . "<br>";
                            }
                            echo '</div>';
                        }
                    ?>
                </p>

                <p class="form-row">
                    <label class="required_field"><strong>Post Categories:</strong></label>
                    <select multiple="" name="categories[]" style="height:85px;"><?= $post_categories;?></select>
                </p>
                <small><strong>NOTE</strong>: Hold Ctrl to select multiple categories.</small>

                <hr/>

                <p class="form-row">
                    <label class="required_field" for="ed_f_desc"><strong>Description:</strong></label>
                    <textarea class="input-text" id="ed_f_desc" cols="5" rows="2"
                      name="description"><?= $post_description; ?></textarea>
                </p>

                <p class="form-row">
                    <label class="required_field" for="ed_f_keyw"><strong>Keywords:</strong></label>
                    <input type="text" name="keywords" id="ed_f_keyw" value="<?= $post_keywords; ?>" class="input-text">
                </p>

                <hr/>

                <p class="form-row">
                    <label><strong>Publish:</strong></label>
                    <?= (isset($post_status) && ($post_status == "publish")) ? '<input type="checkbox" checked="checked" name="status" value="publish" class="input-checkbox">' : '<input type="checkbox" name="status" value="publish" class="input-checkbox">'; ?>
                </p>

                <div class="col-xs-12">
                    <center>
                        <br/>
                        <input id="save" type="button" value="Save" class="button" style="width: 150px;">
                        <br/>
                    </center>
                </div>

            </form>
    </div>
</div>
<div data-id="blog_post_form_dialog" class="ui-widget-overlay ui-front" style="display:none; z-index: 100;"></div>

<div class="col-xs-12">
    <center>
        <br/>
        <input id="pre_save" type="button" value="Save" class="button" style="width: 150px;">
        <br/>
    </center>
</div>


<script type="text/javascript">

    (function ($) {

        new AjaxUpload($('#post_img'), {
            action: function(){
                return '<?php _A_::$app->router()->UrlTo('blog/edit_upload_img')?>'
            },
            name: 'uploadfile',
            onComplete: function (file, response) {
                try{
                    var imgs = JSON.parse(response);
                    $("#post_img").css('background-image', 'url("'+imgs.img+'")');
                    $("#img").val(imgs.f_img);
                } catch(e){

                }
                $('input[name=uploadfile]').trigger('mouseleave');
            }
        });

        $("#save").on('click',
            function(event){
                event.preventDefault();
                $('#blog_post').trigger('submit');
            }
        );

        $("#close").on('click',
            function(event){
                $('[data-id=blog_post_form_dialog]').each(
                    function(){
                        $(this).css('display','none');
                    }
                );
            }
        );
    })(jQuery);
</script>