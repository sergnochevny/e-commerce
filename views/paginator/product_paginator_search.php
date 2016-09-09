<li>
    <?php
    if ($prev_page > 0) {
        echo '<a class="prev page-number-s" href="' . $base_url . '/'.$url.'?page=' . $prev_page;
        if (isset($cat_id)) {
            echo '&cat=' . $cat_id;
        }
        if (isset($mnf_id)) {
            echo '&mnf=' . $mnf_id;
        }
        if (isset($ptrn_id)) {
            echo '&ptrn=' . $ptrn_id;
        }
        echo '" >Prev</a>';
    } else echo '<span class="page-number-s noclicable"> Prev </span>';
    ?>
</li>
<li>
    <?php
    if ($page > 1) {
        echo '<a class="prev page-number-s" href="' . $base_url . '/'.$url.'?page=1';
        if (isset($cat_id)) {
            echo '&cat=' . $cat_id;
        }
        if (isset($mnf_id)) {
            echo '&mnf=' . $mnf_id;
        }
        if (isset($ptrn_id)) {
            echo '&ptrn=' . $ptrn_id;
        }
        echo '" >First</a>';
    } else echo '<span class="page-number-s noclicable"> First </span>';
    ?>
</li>

<?php

for ($i = $nav_start; $i <= $nav_end; $i++) {
    if ($i == $page) {
        echo "<li class='active'><span class='page-number-s current'>$i</span></li>";
    } else {
        ?>
        <li>
            <a class="prev page-number-s"
                <?php
                echo 'href="' . $base_url . '/'.$url.'?page=' . $i;
                if (isset($cat_id)) {
                    echo '&cat=' . $cat_id;
                }
                if (isset($mnf_id)) {
                    echo '&mnf=' . $mnf_id;
                }
                if (isset($ptrn_id)) {
                    echo '&ptrn=' . $ptrn_id;
                }
                echo '" ';
                ?>
                ><?php echo $i ?></a>
        </li>
        <?php
    }
}
?>


<li>
    <?php
    if ($page < $last_page) {
        echo '<a class="prev page-number-s" href="' . $base_url . '/'.$url.'?page=' . $last_page;
        if (isset($cat_id)) {
            echo '&cat=' . $cat_id;
        }
        if (isset($mnf_id)) {
            echo '&mnf=' . $mnf_id;
        }
        if (isset($ptrn_id)) {
            echo '&ptrn=' . $ptrn_id;
        }
        echo '" >Last</a>';
    } else echo '<span class="page-number-s noclicable"> Last </span>';
    ?>
</li>
<li>
    <?php
    if ($next_page <= $last_page) {
        echo '<a class="prev page-number-s" href="' . $base_url . '/'.$url.'?page=' . $next_page;
        if (isset($cat_id)) {
            echo '&cat=' . $cat_id;
        }
        if (isset($mnf_id)) {
            echo '&mnf=' . $mnf_id;
        }
        if (isset($ptrn_id)) {
            echo '&ptrn=' . $ptrn_id;
        }
        echo '" >Next</a>';
    } else echo '<span class="page-number-s noclicable"> Next </span>';
    ?>
</li>
<input type="hidden" id="current_page" value="<?php echo $page;?>">
<?php
if (isset($cat_id)) {
    ?>
    <input type="hidden" id="current_cat" value="<?php echo $cat_id;?>">
<?php } ?>