<div style="padding-top: 20px; margin: auto; width: 600px;">
    <div id="message"><p><span><?= isset($message) ? $message : ''; ?></span><p></div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/authorization/msg_span.js'); ?>' type="text/javascript"></script>