<div class="comment-view container-fluid attr-name">
    <div class="row">
        <div class="col-md-5 table-comment-author text-left">
            <?= $comment['username'] ?>
            <span class="table-comment-date"><?= $comment['dt']; ?></span>
        </div>
        <div class="col-md-7 table-comment-title"><?= $comment['title'] ?></div>

    </div>
    <div class="row"><div class="col-md-12 table-comment-data text-left"><?= $comment['data'] ?></div></div>
</div>
