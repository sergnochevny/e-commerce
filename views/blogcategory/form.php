<?php

use app\core\App;

?>
<form id="edit_form" action="<?=$action?>" data-title="<?=$form_title?>">
    <div class="form-row">
        <label for="color">Category Name</label>
        <input type="text" class="input-text" name="name" value="<?=$data['name'];?>">
    </div>
</form>
<?php $this->registerJSFile(App::$app->router()->UrlTo('js/simple/form.min.js'), 5, true); ?>
