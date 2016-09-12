<?php
if(isset($warning)){
?>
<div class="danger">
    <?php
    foreach($warning as $msg){
        echo $msg."\r\n";
    }
    ?>

</div>
    <?php
}
?>

<center>
    <a href="<?php echo _A_::$app->router()->UrlTo('categories/new');?>">
        <input type="submit" value="ADD NEW CATEGORY" class="button"/>
    </a><br><br><br>
</center>
<div class="">
    <table class="table table-striped table-bordered">
		<thead>
        <tr>
            <th>
                Category
            </th>
            <th>
                SEO Name
            </th>
            <th>
                Display Order
            </th>
            <th>
                List as Style
            </th>
            <th>
                List as New
            </th>
            <th>
                Actions
            </th>
        </tr>
		</thead>
		<tbody>
        <?php echo $get_categories_list; ?>
		</tbody>
    </table>
</div>
<br/>