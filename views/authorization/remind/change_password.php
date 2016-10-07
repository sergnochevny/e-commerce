<body
    class="page page-template-default woocommerce-account woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="<?= $back_url; ?>" class="button back_button">Back</a>
                    <article id="chng_pass" class="page type-page status-publish entry">
                            <?php include('views/remind/change_password_form.php')?>
                    </article>
                </div>
            </div>
        </div>
    </div>
