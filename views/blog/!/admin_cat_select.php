<option value="<?= $href;?>" <?= (!is_null(_A_::$app->get('cat')) && ($group_id == _A_::$app->get('cat')))?'selected':'';?>>
    <?= $name;?>
</option>
