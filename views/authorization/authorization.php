<body
    class="page page-template-default woocommerce-account woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">
<div class="site-container">
<?php include "views/header.php"; ?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <article class="page type-page status-publish entry">
                    <br>
                    <br>
                    <h1 class="entry-title">Account</h1>
                    <div class="entry-content">
                        <div class="woocommerce">
                            <h2>Login</h2>

                            <form method="POST" id="authorization" action="<?= _A_::$app->router()->UrlTo('authorization'); ?>"
                                  class="login">
                                <input type="hidden" name="redirect" value="<?= isset($redirect)?$redirect:_A_::$app->router()->UrlTo('/'); ?>"/>

                                <p class="form-row form-row-wide">
                                    <label for="username">Email Address/Username <span class="required">*</span></label>
                                    <input type="text" class="input-text" name="login" id="username" value=""/>
                                </p>

                                <p class="form-row form-row-wide">
                                    <label for="password">Password <span class="required">*</span></label>
                                    <input class="input-text" type="password" name="pass" id="password"/>
                                </p>

                                <p class="form-row">
                                    <input type="hidden" id="_wpnonce" name="_wpnonce" value="c0312ae7bb"/>
                                    <input type="hidden" name="_wp_http_referer" value="#"/>
                                    <input id="blogin" type="button" class="button" name="login" data-action="<?= _A_::$app->router()->UrlTo('authorization'); ?>" value="Login"/>
                                    <label for="rememberme" class="inline">
                                        <input name="rememberme" value="1" type="checkbox" id="rememberme"/>
                                        Remember me
                                    </label>
                                </p>

                                <p class="lost_password">
                                    <a id="lost_password" href="<?= $lostpassword_url?>">Lost your password?</a>
                                    <a id="register_user" href="<?= $registration_url?>" style="float: right;">Registration</a>
                                </p>

                                <div class="text-center">
                                    <div class="results" style="color: red;"></div>
                                </div>
                            </form>
                        </div>
                    </div>

                </article>
            </div>
        </div>
    </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/authorization/authorization.js'); ?>' type="text/javascript"></script>