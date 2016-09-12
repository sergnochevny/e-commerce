<div class="admin-comments-table">
    <table class="table table-striped table-bordered text-center">
        <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Email</th>
            <th class="text-center">Title</th>
            <th class="text-center">Date</th>
            <th class="text-center">Action</th>
            <th class="text-center">Show on site</th>
        </tr>
        </thead>
        <tbody>
        <?php echo $comments_list; ?>
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
