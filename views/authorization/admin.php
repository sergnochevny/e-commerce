<!--<script src="views/js/jquery.min.js" type="text/javascript"></script>-->
<body
    class="page page-template-default woocommerce-account woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">
<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="page type-page status-publish entry">
                        <h1 class="entry-title">Admin Account</h1>

                        <div class="entry-content">
                            <div class="woocommerce">
                                <h2>Login</h2>

                                <form method="POST" id="formx" action="<?php echo $base_url; ?>/admin"
                                      class="login">
                                    <input type="hidden" name="redirect" value="<?php echo isset($redirect)?$redirect:$base_url; ?>"/>
                                    <p class="form-row form-row-wide">
                                        <label for="username">Username <span class="required">*</span></label>
                                        <input type="text" class="input-text" name="login" id="username" value=""/>
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <label for="password">Password <span class="required">*</span></label>
                                        <input class="input-text" type="password" name="pass" id="password"/>
                                    </p>

                                    <p class="form-row">
                                        <input type="hidden" id="_wpnonce" name="_wpnonce" value="c0312ae7bb"/>
                                        <input type="hidden" name="_wp_http_referer" value="#"/>
                                        <input type="submit" class="button" name="login" value="Login"/>
                                        <label for="rememberme" class="inline">
                                            <input name="rememberme" value="1" type="checkbox" id="rememberme"/>
                                            Remember me
                                        </label>
                                    </p>

                                    <p class="lost_password">
                                        <a href="#">Lost your password?</a>
                                    </p>
                                    <center>
                                        <div class="results" style="color: red;"></div>
                                    </center>
                                </form>
                            </div>
                        </div>

                    </article>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        (function ($) {
            $('#formx').on('submit',
                function(event){
                    event.preventDefault();
                    var msg = $(this).serialize();
                    var url = $(this).attr['action'];
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: msg,
                        success: function (data) {
                            $('.results').html(data);
                        },
                        error: function (xhr, str) {
                            alert('Error: ' + xhr.responseCode);
                        }
                    });
                }
            );
        })(jQuery);
    </script>