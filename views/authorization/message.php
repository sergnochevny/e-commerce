<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <a href="<?= _A_::$app->router()->UrlTo('/'); ?>" class="back_button"><input type="button" value="Back" class="button"></a>

                <div style="padding-top: 20px; margin: auto; width: 70%;">
                    <div id="message">
                        <p>
                            <span>
                                <?= isset($message) ? $message : ''; ?>
                            </span>
                        <p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
