<div class="col-xs-12 table-list-header hidden-xs">
    <div class="row">
        <div class="col-sm-4 col">
            Email <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
        </div>
        <div class="col-sm-3 col">
            Title <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
        </div>
        <div class="col-sm-3 col">
            Date <a href="#"><small><i class="fa fa-chevron-down"></i></small></a>
        </div>
    </div>
</div>

<?= $comments_list; ?>

<nav role="navigation" class="paging-navigation">
    <h4 class="sr-only">Navigation</h4>
    <ul class='pagination'>
        <?= isset($paginator) ? $paginator : ''; ?>
    </ul>
</nav>
