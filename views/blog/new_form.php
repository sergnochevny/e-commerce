<form method="POST" id="blog_post" action="<?= $action_url;?>" class="enquiry-form ">
    <div>
        <p class="form-row">
            <?php
            if (isset($warning)) {
                echo '<div class="col-xs-12 alert-success danger" style="display: none;">';
                foreach ($warning as $msg) {
                    echo $msg . "<br>";
                }
                echo '</div>';
            }
            ?>
            <?php
            if (isset($error)) {
                echo '<div class="col-xs-12 alert-danger danger" style="display: none;">';
                foreach ($error as $msg) {
                    echo $msg . "<br>";
                }
                echo '</div>';
            }
            ?>

        </p>
    </div>
    <div class="col-1">
        <p class="form-row">
            <label class="required_field" for="nw_f_title"><strong>Title:</strong></label>
            <input type="text" id="nw_f_title" name="title" value="<?= $data['title']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field" for="nw_f_desc"><strong>Description:</strong></label>
            <textarea class="input-text" id="nw_f_desc" cols="5" rows="2" name="description"><?= $data['description'];?></textarea>
        </p>

        <p class="form-row">
            <label class="required_field" for="nw_f_keyword"><strong>Keywords:</strong></label>
            <input type="text" name="keywords" id="nw_f_keyword" value="<?= $data['keywords']; ?>" class="input-text ">
        </p>
        <hr/>

        <p class="form-row">
            <label class="required_field" for="nw_f_post_cat"><strong>Post Categories:</strong></label>
            <select multiple="" name="categories[]" id="nw_f_post_cat" style="height:85px;"><?= $data['categories'];?></select>
        </p>
        <small>
            <strong>NOTE</strong>: Hold Ctrl to select multiple categories.
        </small>

        <hr/>

    </div>
    <div class="col-2">


        <div class="form-row">
            <label class="required_field"><strong> Image:</strong></label>
            <div class="text-center">
                <div id="modify_image">
                    <div class="b_modify_image_pic">
                        <?= $data['img'];?>
                    </div>
                    <br/>

                    <div class="clear"></div>
                </div>

            </div>
            <div class="clear"></div>
        </div>

        <div style="margin-top: 15px; width: 200px; height: 70px; margin-left: 125px; display: block;" class="s">
            <div id="upload" class="apd" style="cursor: pointer;"><span>Upload file</span></div>
        </div>
        <hr/>

    </div><!--col-2-->
    <div class="col-xs-12">
        <p class="form-row">
            <label class="required_field" for="editable"><strong>Content:</strong></label>
            <textarea id="editable" class="input-text" style="height: auto;" cols="12" rows="25" name="content"><?= $data['content'];?></textarea>
        </p>
    </div>
    <div class="col-xs-12">
        <p class="form-row">
            <label><strong>Publish:</strong></label>
            <?= ( isset($data['status']) && $data['status'] === "publish") ? '<input id="chkML" type="checkbox" checked="checked" name="status" value="publish" class="input-checkbox regular-checkbox big-checkbox"><label for="chkML"></label>' : '<input id="chkML" type="checkbox" name="status" value="publish" class="input-checkbox regular-checkbox big-checkbox"><label for="chkML"></label>'; ?>
        </p>
    </div>
    <div class="col-xs-12">
        <div class="text-center"> <br/> <input type="submit" value="Save" class="button" style="width: 150px;"> <br/> </div>
    </div>
</form>