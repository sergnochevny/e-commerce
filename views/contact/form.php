<?php

use app\core\App;

?>
<?php include(APP_PATH . '/views/messages/alert-boxes.php'); ?>
<form method="POST" id="edit_form" action="<?= $action; ?>" class="contact-form">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-row">
                <label class="required_field">Your Name</label>
                <input type="text" name="name" class="input-text"
                       value="<?= isset($data['name']) ? $data['name'] : '' ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-row">
                <label>Phone</label>
                <input type="text" name="phone" class="input-text"
                       value="<?= isset($data['phone']) ? $data['phone'] : '' ?>">
            </div>
        </div>

        <div class="col-xs-6">
            <div class="form-row">
                <label class="required_field">Your Email</label>
                <input type="email" name="email" class="input-text"
                       value="<?= isset($data['email']) ? $data['email'] : '' ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-row">
                <label class="required_field">Subject</label>
                <input type="text" name="subject" class="input-text"
                       value="<?= isset($data['subject']) ? $data['subject'] : '' ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-row">
                <label class="required_field">Questions or comments</label>
                <textarea name="comments" rows="10" cols="30"
                          class="input-text"><?= isset($data['comments']) ? $data['comments'] : '' ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-row">
            <div class="col-xs-6 col-sm-6">
                <img height="45" id="captcha_img" src="<?= App::$app->router()->UrlTo('captcha') ?>">
                <a class="pull-right half-inner-offset-top" tabindex="-1" title="Refresh" id="captcha_refresh"
                   href="javascript:void(0);">
                    <i class="fa fa-2x fa-refresh" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-xs-6 col-sm-6">
                <input type="text" name="captcha" class="input-text" placeholder="Enter Text from Image">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="form-row">
                <input type="submit" class="btn button" value="Send a letter"/>
            </div>
        </div>
    </div>
</form>
<script type='text/javascript' src='<?= App::$app->router()->UrlTo('js/captcha/captcha.min.js'); ?>'></script>
<script src='<?= App::$app->router()->UrlTo('js/formsimple/form.min.js'); ?>' type="text/javascript"></script>
