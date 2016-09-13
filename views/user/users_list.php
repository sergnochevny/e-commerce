<center>
    <a href="<?php _A_::$app->router()->UrlTo('user/new',['page'=>$page])?>"><input type="submit" value="ADD NEW USER" class="button"/></a><br><br><br>
</center>
<div class="">
    <table class="table table-striped table-bordered">
	<thead>
        <tr>
            <th>
                Id
            </th>
            <th>
                Email
            </th>
            <th>
                Name
            </th>
            <th>
                Date Registered
            </th>
            <th>

            </th>
        </tr>
	</thead>
	<tbody>
        <?php echo $main_users_list; ?>
	</tbody>
    </table>
</div>
<br/>
<nav role="navigation" class="paging-navigation">
    <h4 class="sr-only">Products navigation</h4>
    <ul class='pagination'>
        <?php echo isset($paginator) ? $paginator : ''; ?>
    </ul>
</nav>
