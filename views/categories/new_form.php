<form id="new_category_form" action="<?= _A_::$app->router()->UrlTo('categories/save_new') ?>" method="post">
    <p class="text-center">
        <small style="color: black; font-size: 13px;">
            Use this form to update the title and details of the offer.<br/>
        </small>
    </p>
    <hr>
    <div class="col-1">
        <p class="form-row">
            <label class="required_field"><strong>Category:</strong></label>
            <input type="text" name="category"  <?= isset($category)?  'value="'.$category.'"':''; ?> class="input-text ">
            <small style="color: #999">NOTE: the title cannot be more than 28 characters.</small>
        </p>

        <p class="form-row">
            <label><strong>Display order:</strong>&nbsp;<?= $curr_order; ?></label>
            <select name="display_order" value="<?= $curr_order; ?>" style="display: none;">
                <?= $display_order_categories; ?>
                <option value="<?= $curr_order; ?>" selected><?= $curr_order; ?></option>
            </select>
        </p>
        <p class="form-row">
            <label><strong>Seo:</strong></label>
            <input type="text" name="seo"  <?= isset($seo)?  'value="'.$seo.'"':''; ?> class="input-text ">
            <small><strong>NOTE:</strong> the seo name will be parsed to be url compatible if necessary.</small>
        </p>
        <p class="form-row">
            <label>
                <strong>List as a Style:</strong>
                <input type="checkbox" name="ListStyle" <?= isset($ListStyle)?  'checked':''; ?> value="1" class="input-checkbox">
            </label>
        </p>

        <p class="form-row">
            <label>
                <strong>List as a New Item:</strong>
                <input type="checkbox" name="ListNewItem" <?= isset($ListNewItem)?  'checked':''; ?> value="1" class="input-checkbox">
            </label>
        </p>
        <br/>

        <div class="col-xs-12 alert-success danger" style="display: none;">
            <?php
                if (isset($warning)) {
                    foreach ($warning as $msg) {
                        echo '<span>' . $msg . '</span>';
                    }
                }
            ?>
        </div>
        <div class="col-xs-12 alert-danger danger" style="display: none;">
            <?php
                if (isset($error)) {
                    foreach ($error as $msg) {
                        echo '<span>' . $msg . '</span><br/>';
                    }
                }
            ?>
        </div>
        <br/>
        <br/>
        <div class="text-center"><input type="submit" value=" Add " class="button"/></div>
    </div>
</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/categories/new_form.js'); ?>' type="text/javascript"></script>