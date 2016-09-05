<script type="text/javascript">
    function publishComment(address, view_update){
        var title = jQuery("#comment_title").text();
        var data = jQuery("#comment_data").text();
        jQuery.post(address, {comment_data : data, comment_title : title, publish : "1"}, function(data){
            
            console.log(data);
        });
        jQuery.get(view_update, "", function(data){
            console.log(data);
        });
    }
</script>
<table class="table table-bordered table-comment">
    <tr>
        <th class="text-center text-warning table-comment title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 text-left table-comment-author" id="comment_user_name"><?= $comment['username'] ?>
                        <span class="table-comment-date" id="comment_date"><?= $comment['dt']; ?></span></div>
                    <span class="col-md-7 text-left table-comment-title" id="comment_title"><?= $comment['title'] ?></span>
                </div>
            </div>
        </th>
    </tr>
    <tr>
        <th class="text-center table-content table-content-comment">
            <div id="comment_data"><?= $comment['data'] ?></div>
        </th>
    </tr>
    <tr>
        <th><a class="comment-button btn" onclick='publishComment("<?= $update_url ?>", "<?= $update_view_url ?>")'>Publish</a> </th>
    </tr>
</table>