<div class="text-center">
    <img src="<?= $img; ?>"/>
    <input name="img" value="<?= $f_img; ?>" type="hidden"/>
</div>
    <?php
    if (isset($warning) || isset($error)) echo '<div class="danger"><br/><br/></div>';
    if (isset($warning)) {
        echo '<div class="col-xs-12 alert-success danger">';
        foreach ($warning as $msg) {
            echo $msg . "<br>";
        }
        echo '</div>';
    }
    ?>
    <?php
    if (isset($error)) {
        echo '<div class="col-xs-12 alert-danger danger">';
        foreach ($error as $msg) {
            echo $msg . "<br>";
        }
        echo '</div>';
    }
    ?>