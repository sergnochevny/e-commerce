<?php
    $opt = null;
    if (isset($cat_id)) {
        $opt['cat'] = $cat_id;
    }
?>
<li>
    <?php
    if ($prev_page > 0) {
        $opt['page'] = $prev_page;
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->UrlTo('/comments', $opt) . '" >Prev</a>';
    } else echo '<span class="page-numbers noclicable"> Prev </span>';
    ?>
</li>
<li>
    <?php
    if ($page > 1) {
        $opt['page'] = 1;
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->UrlTo('/comments', $opt) . '" >First</a>';
    } else echo '<span class="page-numbers noclicable"> First </span>';
    ?>
</li>

<?php

for ($i = $nav_start; $i <= $nav_end; $i++) {
    if ($i == $page) {
        echo "<li class='active'><span class='page-numbers current'>$i</span></li>";
    } else {
        $opt['page'] = $i;
        ?>
        <li>
            <a class="prev page-numbers" <?= 'href="' . _A_::$app->router()->UrlTo('/comments', $opt) .'"'?>>
                = $i ?>
            </a>
        </li>
        <?php
    }
}
?>
<li>
    <?php
    if ($page < $last_page) {
        $opt['page'] = $last_page;
        echo '<a class="prev page-numbers" href="' .  _A_::$app->router()->UrlTo('/comments', $opt) . '" >Last</a>';
    } else echo '<span class="page-numbers noclicable"> Last </span>';
    ?>
</li>
<li>
    <?php
    if ($next_page <= $last_page) {
        $opt['page'] = $next_page;
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->UrlTo('/comments', $opt) . '" >Next</a>';
    } else echo '<span class="page-numbers noclicable"> Next </span>';
    ?>
</li>
<input type="hidden" id="current_page" value="= $page; ?>">