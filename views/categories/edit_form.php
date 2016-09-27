<form id="category_edit_form" action="<?= _A_::$app->router()->UrlTo('categories/save_data',['category_id' => _A_::$app->get('category_id')]) ?>"  method="post">
    <p class="text-center">
        <small style="color: black; font-size: 13px;">
            Use this form to update the title and details of the offer.<br />
        </small>
    </p>
    <hr>
    <div class="col-md-12">
        <div class="row">

            <div class="form-row">
                <label class="required_field"><strong>Category:</strong></label>
                <input type="text" name="category" value="<?=$data['cname']?>"
                       class="input-text ">
                <small style="color: #999">NOTE: the title cannot be more than 28 characters.</small>
            </div>
            <div class="form-row">
                <label><strong>Display order:</strong></label>
                <select name="display_order">
                    <?= $display_order_categories; ?>
                </select>
            </div>
            <div class="form-row">
                <label><strong>Seo:</strong></label>
                <input type="text" name="seo" value="<?=$data['seo']?>" class="input-text ">
                <small><strong>NOTE:</strong> the seo name will be parsed to be url compatible if necessary.</small>
            </div>
            <div class="form-row">
                <label for="ListStyle">
                    <b>List as a Style:</b>
                    <?php
                    if($data['isStyle']=="1"){
                        echo '<input type="checkbox" id="ListStyle" name="ListStyle" checked="checked" value="1" class="input-checkbox">';
                    }
                    else{
                        echo '<input type="checkbox" id="ListStyle" name="ListStyle" value="1" class="input-checkbox">';
                    }
                    ?>
                </label>
            </div>
            <div class="form-row">
                <label for="ListNewItem">
                    <b>List as a New Item:</b>
                    <?php
                    if($data['isNew']=="1"){
                        echo '<input type="checkbox" id="ListNewItem" name="ListNewItem" checked="checked" value="1" class="input-checkbox">';
                    }
                    else{
                        echo '<input type="checkbox" id="ListNewItem" name="ListNewItem" value="1" class="input-checkbox">';
                    }
                    ?>
                </label>
            </div>
            <?php if(isset($warning)){ ?>
                <div class="col-xs-12 alert-success danger" style="display: none;"><?php
                    foreach($warning as $msg){
                        echo $msg."\r\n";
                    }
                ?></div>
            <?php }?>
            <?php if(isset($error)){ ?>
                <div class="col-xs-12 alert-danger danger" style="display: none;"><?php
                        foreach($error as $msg){
                            echo $msg."\r\n";
                        }
                ?></div>
            <?php }?>
        </div>
    </div>
    <div class="col-1">





        <!--col-2-->

        <br/>
        <br/>
        <div class="text-center"><input type="submit" value="Update" class="button" /></div>

</form>
<script src='<?= _A_::$app->router()->UrlTo('views/js/categories/edit_form.js'); ?>' type="text/javascript"></script>