<?php if(isset($warning)){ ?>
    <div class="danger">
        <?php
            foreach($warning as $msg){
                echo $msg."\r\n";
            }
        ?>
    </div>
<?php } ?>

<div class="text-center">
    <a href="<?= _A_::$app->router()->UrlTo('categories/add');?>">
        <input type="submit" value="ADD NEW CATEGORY" class="button"/>
    </a><br><br><br>
</div>
<div>
    <table class="table table-striped table-bordered">
		<thead>
            <tr>
                <th>Category</th>
                <th>SEO Name</th>
                <th>Display Order</th>
                <th>List as Style</th>
                <th>List as New</th>
                <th>Actions</th>
            </tr>
		</thead>
		<tbody><?= $get_categories_list; ?></tbody>
    </table>
</div>
<br/>