<table class="table table-bordered table-comment">
    <tr>
        <th class="text-center table-comment title">
            <div class="container-fluid">
                <div class="row" style="font-weight: normal">
                    <div class="col-xs-12 text-center table-comment-title" id="comment_title"><b><?= $comment['title'] ?></b></div>
                    <div class="col-xs-5 text-left" id="comment_user_name">
                        <div class="row"><?= $comment['username'] ?></div>
                        <div class="row"><span id="comment_date"><?= $comment['dt']; ?></span></div>
                    </div>
                </div>
            </div>
        </th>
    </tr>
    <tr>
        <th class="text-justify table-content table-content-comment">
            <div id="comment_data" style="font-weight: normal"><?= $comment['data'] ?></div>
        </th>
    </tr>
    <tr>
        <th>
            <a class="comment-button button publ-comment"
               data-id="<?= $comment['id'] ?>"
               data-address="<?= $update_url ?>"
               data-view-update="<?= $update_url ?>"
               data-title="<?= $comment['title'] ?>"
               data-data="<?= $comment['data']; ?>">
                <b>Publish</b>
            </a>
        </th>
    </tr>
</table>