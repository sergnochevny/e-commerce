<article class="page type-page status-publish entry">
    <h1 class="entry-title">Lost Password?</h1>

    <div class="entry-content" style="padding-bottom: 0;">
        <ul>
            <li>
                Identity your Email Addrress(Login).
            </li>
            <li>
                Click on the button "Send".
            </li>
            <li>
                It will be sent an email with a link inside to a form that will help you to change your password.
            </li>
            <li>
                Receive a email and click to the link.
            </li>
            <li>
                Сhange your password using the form.
            </li>
        </ul>
        <span style="color: red;">Be careful, the link is relevant only one hour.</span>
    </div>

    <?php
    if (isset($warning) || isset($error)) {
        ?>
        <div class="entry-content danger"  style="padding-bottom: 20px;">
            <?php
            if (isset($warning)) {
                ?>
                <div class="col-xs-12 entry-content alert-success danger">
                    <?php
                    foreach ($warning as $msg) {
                        echo '<span>' . $msg . '</span>';
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if (isset($error)) {
                ?>
                <div class="col-xs-12 alert-danger danger">
                    <?php
                    foreach ($error as $msg) {
                        echo '<span>' . $msg . '</span><br/>';
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>

    <div class="entry-content">
        <div class="woocommerce">
            <form method="POST" id="lost_password_form" action="<?= $action; ?>"
                  class="login">

                <p class="form-row form-row-wide">
                    <label for="username">Email Address <span class="required">*</span></label>
                    <input type="text" class="input-text" name="login" id="username" value=""/>
                </p>

                <p class="form-row">
                    <input id="blost" type="button" class="button" name="login" value="Send"/>
                </p>

                <center>
                    <div class="results" style="color: red;"></div>
                </center>
            </form>
        </div>
    </div>

</article>
<script src='<?= _A_::$app->router()->UrlTo('views/authorization/lost_password_form.js'); ?>' type="text/javascript"></script>