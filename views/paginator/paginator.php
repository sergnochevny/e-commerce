<?php
  if(isset($cat_id)) {
    $prms['cat'] = $cat_id;
  }
  if(isset($mnf_id)) {
    $prms['mnf'] = $mnf_id;
  }
  if(isset($ptrn_id)) {
    $prms['ptrn'] = $ptrn_id;
  }
  if(isset($clr_id)) {
    $prms['clr'] = $clr_id;
  }
?>
  <li>
    <?php
      if($prev_page > 0) {
        $prms['page'] = $prev_page;
        echo '<a data-to_page class="prev page-numbers" href="' . _A_::$app->router()->UrlTo($url, $prms) . '" >Prev</a>';
      } else echo '<span class="page-numbers noclicable"> Prev </span>';
    ?>
  </li>
  <li>
    <?php
      if($page > 1) {
        $prms['page'] = 1;
        echo '<a data-to_page class="prev page-numbers" href="' . _A_::$app->router()->UrlTo($url, $prms) . '" >First</a>';
      } else echo '<span class="page-numbers noclicable"> First </span>';
    ?>
  </li>

<?php
  for($i = $nav_start; $i <= $nav_end; $i++) {
    if($i == $page) {
      echo "<li class='active'><span class='page-numbers current'>$i</span></li>";
    } else {
      $prms['page'] = $i;
      ?>
      <li>
        <?= '<a data-to_page class="prev page-numbers" href="' . _A_::$app->router()->UrlTo($url, $prms) . '">' . $i . '</a>'; ?>
      </li>
      <?php
    }
  }
?>
  <li>
    <?php
      if($page < $last_page) {
        $prms['page'] = $last_page;
        echo '<a data-to_page class="prev page-numbers" href="' . _A_::$app->router()->UrlTo($url, $prms) . '" >Last</a>';
      } else echo '<span class="page-numbers noclicable"> Last </span>';
    ?>
  </li>
  <li>
    <?php
      if($next_page <= $last_page) {
        $prms['page'] = $next_page;
        echo '<a data-to_page class="prev page-numbers" href="' . _A_::$app->router()->UrlTo($url, $prms) . '" >Next</a>';
      } else echo '<span class="page-numbers noclicable"> Next </span>';
    ?>
  </li>
  <input type="hidden" id="current_page" value="<?= $page; ?>">
<?php if(isset($cat_id)) { ?>
  <input type="hidden" id="current_cat" value="<?= $cat_id; ?>">
<?php } ?>