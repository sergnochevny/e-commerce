
<form method="POST" id="blog_post" action="<?php echo $action_url;?>" class="enquiry-form ">
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
            <label class="required_field"><strong>Title:</strong></label>
            <input type="text" name="title" value="<?php echo $data['title']; ?>" class="input-text ">
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Description:</strong></label>
            <textarea class="input-text" cols="5" rows="2" name="description"><?php echo $data['description'];?></textarea>
        </p>

        <p class="form-row">
            <label class="required_field"><strong>Keywords:</strong></label>
            <input type="text" name="keywords" value="<?php echo $data['keywords']; ?>" class="input-text ">
        </p>
        <hr/>

        <p class="form-row">
            <label class="required_field"><strong>Post Categories:</strong></label>
            <select multiple="" name="categories[]" style="height:85px;"><?php echo $data['categories'];?></select>
        </p>
        <small>
            <strong>NOTE</strong>: Hold Ctrl to select multiple categories.
        </small>

        <hr/>

    </div>
    <div class="col-2">


        <div class="form-row">
            <label class="required_field"><strong> Image:</strong></label>
            <center>
                <div id="modify_image">
                    <div class="b_modify_image_pic">
                        <?php echo $data['img'];?>
                    </div>
                    <br/>

                    <div class="clear"></div>
                </div>

            </center>
            <div class="clear"></div>
        </div>

        <div style="margin-top: 15px; width: 200px; height: 70px; margin-left: 125px;" class="s" style="display: block;">
            <div id="upload" class="apd" style="cursor: pointer;"><span>Upload file</span></div>
        </div>
        <hr/>

    </div><!--col-2-->
    <div class="col-xs-12">
        <p class="form-row">
            <label  class="required_field"><strong>Content:</strong></label>
            <textarea id="editable" class="input-text" style="height: auto;" cols="12" rows="25" name="content"><?php echo $data['content'];?></textarea>
        </p>
    </div>
    <div class="col-xs-12">
        <p class="form-row">
            <label><strong>Publish:</strong></label>
            <?php
            if ( isset($data['status']) && ($data['status'] == "publish")) {
                echo '<input id="chkML" type="checkbox" checked="checked" name="status" value="publish" class="input-checkbox regular-checkbox big-checkbox"><label for="chkML"></label>';
            } else {
                echo '<input id="chkML" type="checkbox" name="status" value="publish" class="input-checkbox regular-checkbox big-checkbox"><label for="chkML"></label>';
            }
            ?>
        </p>
    </div>
    <div class="col-xs-12">
        <center>
            <br/>
            <input type="submit" value="Save" class="button" style="width: 150px;">
            <br/>
        </center>
    </div>
</form>