<li>
<?php
    $opt = null;
    if ($prev_page > 0) {
        $opt['page'] = $prev_page;
        if (isset($cat_id)) {
            $opt['cat'] = $cat_id;
        }
        if (isset($mnf_id)) {
            $opt['mnf'] = $mnf_id;
        }
        if (isset($ptrn_id)) {
            $opt['ptrn'] = $ptrn_id;
        }
        echo '<a class="prev page-number-s" href="' . _A_::$app->router()->UrlTo($url, $opt) . '" >Prev</a>';
    } else echo '<span class="page-number-s noclicable"> Prev </span>';
?>
</li>
<li>
    <?php
    if ($page > 1) {
        $opt['page'] = 1;
        if (isset($cat_id)) {
            $opt['cat'] = $cat_id;
        }
        if (isset($mnf_id)) {
            $opt['mnf'] = $mnf_id;
        }
        if (isset($ptrn_id)) {
            $opt['ptrn'] = $ptrn_id;
        }
        echo '<a class="prev page-number-s" href="' . _A_::$app->router()->UrlTo($url, $opt) . '" >First</a>';
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
                $opt['page'] = $i;
                if (isset($cat_id)) {
                    $opt['cat'] = $cat_id;
                }
                if (isset($mnf_id)) {
                    $opt['mnf'] = $mnf_id;
                }
                if (isset($ptrn_id)) {
                    $opt['ptrn'] = $ptrn_id;
                }
                echo 'href="' . _A_::$app->router()->UrlTo($url, $opt) . '" ' ;
                ?>
            >= $i ?></a>
        </li>
        <?php
    }
}
?>


<li>
    <?php
    if ($page < $last_page) {
        $opt['page'] = $last_page;
        if (isset($cat_id)) {
            $opt['cat'] = $cat_id;
        }
        if (isset($mnf_id)) {
            $opt['mnf'] = $mnf_id;
        }
        if (isset($ptrn_id)) {
            $opt['ptrn'] = $ptrn_id;
        }
        echo '<a class="prev page-number-s" href="' .  _A_::$app->router()->UrlTo($url, $opt) . '" >Last</a>';
    } else {
        echo '<span class="page-number-s noclicable"> Last </span>';
    }
    ?>
</li>
<li>
    <?php
        if ($next_page <= $last_page) {
            $opt['page'] = $next_page;
            if (isset($cat_id)) {
                $opt['cat'] = $cat_id;
            }
            if (isset($mnf_id)) {
                $opt['mnf'] = $mnf_id;
            }
            if (isset($ptrn_id)) {
                $opt['ptrn'] = $ptrn_id;
            }
            echo '<a class="prev page-number-s" href="' . _A_::$app->router()->UrlTo($url, $opt) . '" >Next</a>';
        } else{
            echo '<span class="page-number-s noclicable"> Next </span>';
        }
    ?>
</li>
<input type="hidden" id="current_page" value="<?= $page; ?>">
<?php if (isset($cat_id)) { ?>
    <input type="hidden" id="current_cat" value="<?= $cat_id; ?>">
<?php } ?>