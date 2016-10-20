    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row afterhead-row">
                    <div class="col-xs-12 back_button_container">
                        <a href="<?= $back_url; ?>" class="button back_button">Back</a>
                    </div>
                    <div class="col-xs-12 text-center">
                        <div class="row">
                            <h3 class="page-title"><?= $form_title ?></h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-md-offset-2">
                <div class="woocommerce"><div id="blog_post_form"><?php include('views/blog/edit_form.php'); ?></div></div>
            </div>
        </div>
    </div>
