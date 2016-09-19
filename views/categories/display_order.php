<?php
    if ($row[3] == $displayorder) {
        echo '<option value="' . $row[3] . '" selected>' . $row[3] . '</option>';
    } else {
        echo '<option value="' . $row[3] . '" >' . $row[3] . '</option>';
    }
?>