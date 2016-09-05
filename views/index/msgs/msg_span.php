<div id="customer_details" style="padding-top: 20px; margin: auto; width: 600px;">
    <div id="message">
        <p>
            <span>
                <?php echo isset($message) ? $message : ''; ?>
            </span>

        <p>
    </div>
</div>
<script>
    (
        function ($) {
            $('html, body').animate({scrollTop: 0 }, 1000);
        }
    )(jQuery);
</script>