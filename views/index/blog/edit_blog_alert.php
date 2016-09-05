<?php
if (isset($warning)) {
    echo '<div class="col-xs-12 alert-success danger" style="display: none;">';
    foreach ($warning as $msg) {
        echo $msg . "<br>";
    }
    echo '</div>';
}
?>
<?php
if (isset($error)) {
    echo '<div class="col-xs-12 alert-danger danger" style="display: none;">';
    foreach ($error as $msg) {
        echo $msg . "<br>";
    }
    echo '</div>';
}
?>
