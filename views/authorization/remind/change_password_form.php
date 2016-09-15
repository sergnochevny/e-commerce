<h1 class="entry-title">Change Password</h1>
<?php
if (isset($warning) || isset($error)) {
    ?>
    <div class="entry-content danger" style="padding-bottom: 20px;">
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
        <form method="POST" id="psw_form" action="<?php echo $action; ?>" class="login">
            <input type="hidden" name="remind" value="<?php echo isset($remind) ? $remind : ''; ?>"/>

            <p class="form-row form-row-wide">
                <label for="password">Password <span class="required">*</span></label>
                <input class="input-text" type="password" name="password" id="password"/>
            </p>

            <p class="form-row form-row-wide">
                <label for="confirm">Confirm Password<span class="required">*</span></label>
                <input type="password" class="input-text" name="confirm" id="confirm"/>
            </p>

            <p class="form-row">
                <input id="bchange" type="button" class="button" value="Change"/>
            </p>
        </form>
    </div>
</div>
<script type="text/javascript">
    (function ($) {

        $('#psw_form').on('submit',
            function (event) {
                event.preventDefault();
                var msg = $(this).serialize();
                var url = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: msg,
                    success: function (data) {
                        $.when($('#chng_pass').html(data)).done(
                            function () {
                                if ($('.danger').length > 0) {
                                    setTimeout(
                                        function () {
                                            $('.danger').remove();
                                        }
                                        , 8000
                                    );
                                }
                            }
                        );
                    },
                    error: function (xhr, str) {
                        alert('Error: ' + xhr.responseCode);
                    }
                });
            }
        );

        $('#bchange').on('click',
            function (event) {
                event.preventDefault();
                $('#psw_form').trigger('submit');
            }
        );


    })(jQuery);
</script>