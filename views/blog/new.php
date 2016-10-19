<script src="<?= _A_::$app->router()->UrlTo('tinymce/tinymce.min.js')?>"></script>
<link rel='stylesheet' id='just-style-css' href='<?= _A_::$app->router()->UrlTo('views/css/style.css')?>' type='text/css' media='all'/>
<link rel="stylesheet" type="text/css" href="<?= _A_::$app->router()->UrlTo('upload/styles.css')?>">


<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="row afterhead-row">
                <div class="col-xs-12 col-sm-2 back_button_container">
                    <div class="row">
                      <a href="<?= $back_url; ?>" class="button back_button">Back</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 text-center">
                    <div class="row">
                        <h3 class="page-title"><?= $form_title ?></h3>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8 col-md-offset-2">
            <div class="woocommerce"><div id="blog_post_form"><?php include('views/blog/new_form.php'); ?></div></div>
        </div>
    </div>
</div>


<input type="hidden" id="external_filemanager_path" value="<?= _A_::$app->router()->UrlTo('filemanager/')?>">
<input type="hidden" id="ajax_ret_act" value="<?= _A_::$app->router()->UrlTo('blog/new_upload_img')?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/blog/new.js'); ?>' type="text/javascript"></script>