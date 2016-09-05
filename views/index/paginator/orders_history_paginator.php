<?php
$sq = '';
if (isset($_GET['orders_search_query'])) {
    $sq = '&orders_search_query=' . $_GET['orders_search_query'] . '';
}

?>
<li>
    <?php
    if ($prev_page > 0) {
        echo '<a class="prev page-numbers" href="' . $base_url . '/orders_history?page=' . $prev_page . $sq;
        if (isset($cat_id)) {
            echo '&cat=' . $cat_id;
        }
        echo '" >Prev</a>';
    } else echo '<span class="page-numbers noclicable"> Prev </span>';
    ?>
</li>
<li>
    <?php
    if ($page > 1) {
        echo '<a class="prev page-numbers" href="' . $base_url . '/orders_history?page=1' . $sq;
        echo '" >First</a>';
    } else echo '<span class="page-numbers noclicable"> First </span>';
    ?>
</li>

<?php

for ($i = $nav_start; $i <= $nav_end; $i++) {
    if ($i == $page) {
        echo "<li class='active'><span class='page-numbers current'>$i</span></li>";
    } else {
        ?>
        <li>
            <a class="prev page-numbers"
                <?php
                echo 'href="' . $base_url . '/orders_history?page=' . $i . $sq . '"';
                ?>><?php echo $i ?></a>
        </li>
        <?php
    }
}
?>
<li>
    <?php
    if ($page < $last_page) {
        echo '<a class="prev page-numbers" href="' . $base_url . '/orders_history?page=' . $last_page . $sq;
        echo '" >Last</a>';
    } else echo '<span class="page-numbers noclicable"> Last </span>';
    ?>
</li>
<li>
    <?php
    if ($next_page <= $last_page) {
        echo '<a class="prev page-numbers" href="' . $base_url . '/orders_history?page=' . $next_page . $sq;
        echo '" >Next</a>';
    } else echo '<span class="page-numbers noclicable"> Next </span>';
    ?>
</li>
<input type="hidden" id="current_page" value="<?php echo $page; ?>">