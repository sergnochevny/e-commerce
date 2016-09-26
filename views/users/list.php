<div class="text-center"><a href="<?= _A_::$app->router()->UrlTo('users/add',['page'=>$page])?>"><input type="submit" value="ADD NEW USER" class="button"/></a><br><br><br></div>
<div class="">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Email</th>
                <th class="text-center">Name</th>
                <th class="text-center">Date Registered</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?= $main_users_list; ?>
        </tbody>
    </table>
</div>
<br/>
<nav role="navigation" class="paging-navigation">
    <h4 class="sr-only">Products navigation</h4>
    <ul class='pagination'>
        <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
</nav>
