<?php foreach($items as $item):?>
<?php $selected = (isset($select) && ($select == $item['id']));?>
<option <?= (isset($selected) && $selected)?'selected':''?> value="<?=$item['id']?>"><?=$item['name']?></option>
<?php endforeach;?>