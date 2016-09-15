<?php
$opt = null;
$opt['orders_search_query'] = !is_null(_A_::$app->get('orders_search_query')) ? _A_::$app->get('orders_search_query') : '';
?>
<li>
    <?php
    if ($prev_page > 0) {
        $opt['page'] = $prev_page;
        $opt['cat'] = isset($cat_id) ? $cat_id : '';
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->urlTo('orders/history', $opt) . '" >Prev</a>';

    } else echo '<span class="page-numbers noclicable"> Prev </span>';
    ?>
</li>
<li>
    <?php
    if ($page > 1) {
        $opt['page'] = 1;
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->urlTo('orders_history', $opt) . '" >First</a>';
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
            <a class="prev page-numbers" <?= 'href="' . _A_::$app->router()->urlTo('orders_history', $opt); ?>>
                <?= $i ?>
            </a>
        </li>
        <?php
    }
}
?>
<li>
    <? if ($page < $last_page) {
        $opt['page'] = $last_page;
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->urlTo('orders_history', $opt) . '" >Last</a>';
    } else echo '<span class="page-numbers noclicable"> Last </span>';
    ?>
</li>
<li>
    <?php if ($next_page <= $last_page) {
        echo '<a class="prev page-numbers" href="' . _A_::$app->router()->urlTo('orders_', $opt) . '" >Next</a>';
    } else echo '<span class="page-numbers noclicable"> Next </span>';
    ?>
</li>
<input type="hidden" id="current_page" value="<?php echo $page; ?>">