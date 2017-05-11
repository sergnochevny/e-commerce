<?php
/**
 * iluvfarix.
 * User: Serg
 * Date: 14.02.2017
 * Time: 12:51
 */
if (!empty($per_page_items)): ?>
  <div class="page-limit-selector pull-right outer-offset-left">
    <select id="per_page" data-limit class="showby">
      <?php foreach ($per_page_items as $item): ?>
        <option value="<?= $item ?>" <?= ($per_page == $item ? 'selected' : '') ?>><?= $item ?></option>
      <?php endforeach; ?>
    </select>
  </div>
<?php endif; ?>
