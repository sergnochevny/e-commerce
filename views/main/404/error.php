<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <div style="padding-top: 20px; margin: auto; width: 600px;">
                    <div class="error404" id="message404">
                        <p>
                            <span class="title404">
                                Sorry, the page not found.
                            </span>
                        <p>
                        <p>
                            <span class="msg404">
                                The link you followed probably broken, <br> or the page has been removed.<br><br>
                                Return to <a href="<?= _A_::$app->router()->UrlTo('/');?>">homepage.</>
                            </span>
                        <p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
