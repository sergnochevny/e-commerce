<div class="col-xs-12 b_modify_images_main">
  <div class="row">
    <div class="col-xs-12 b_modify_images_1">
      <div class="row">
        <label class="col-xs-12 no-offset-left no-offset-right">
          <input type="radio" name="images" class="images" value="1" style="display:none;"/>
          <div data-img_main class="b_modify_images_main_pic"
               style="background:no-repeat; background-image: url(<?= !empty($data['u_image1']) ? $data['u_image1'] : $not_image; ?>); background-size: 300px; width: 300px;">
            <?php if(!empty($data['u_image1'])) { ?>
              <div data-role="pic_del" class='b_modify_images_pic_del'>
                <a href='<?= $data['pid'] ?>' title="Remove Image" data-img_idx='1' data-img_del class='pic_del_images'>
                  <span><i class="fa fa-times" aria-hidden="true"></i></span>
                </a>
              </div>
            <?php } ?>
            <input type="hidden" value="<?= !empty($data['u_image1']) ? $data['image1'] : '' ?>" name="image1">
          </div>
        </label>
      </div>
    </div>
    <div class="col-xs-12 b_modify_images_2">
      <div class="row">
        <div class="col-xs-6 col-md-6">
          <div class="row">
            <label class="col-xs-12 no-offset-left no-offset-right">
              <input type="radio" name="images" class="images" value="2" style="display:none;"/>
              <div data-img class='b_modify_images_pic'
                   style='background-image: url(<?= !empty($data['u_image2']) ? $data['u_image2'] : $not_image; ?>)'>
                <?php if(!empty($data['u_image2'])) { ?>
                  <div class='b_modify_images_pic_del'>
                    <a href='<?= $data['pid'] ?>' title="Remove Image" data-img_idx='2' data-img_del class='pic_del_images'>
                      <span><i class="fa fa-times" aria-hidden="true"></i></span>
                    </a>
                  </div>
                  <div class='b_modify_images_pic_make_main'>
                    <div data-pid='<?= $data['pid'] ?>' data-img_idx='2'
                         data-img_set_main
                         class='b_modify_images_pic_main_icon'>
                      <i class="fa fa-desktop" title="Set as main image"></i>
                    </div>
                  </div>
                <?php } ?>
                <input type="hidden" value="<?= isset($data['u_image2']) ? $data['image2'] : '' ?>" name="image2">
              </div>
            </label>
          </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="row">
            <label class="col-xs-12 no-offset-left no-offset-right">
              <input type="radio" name="images" class="images" value="3" style="display:none;"/>
              <div data-img class='b_modify_images_pic'
                   style='background-image: url(<?= !empty($data['u_image3']) ? $data['u_image3'] : $not_image; ?>); background-size: 100px 100px;'>
                <?php if(!empty($data['u_image3'])) { ?>
                  <div class='b_modify_images_pic_del'>
                    <a href='<?= $data['pid'] ?>' title="Remove Image" data-img_idx='3' data-img_del class='pic_del_images'>
                      <span><i class="fa fa-times" aria-hidden="true"></i></span>
                    </a>
                  </div>
                  <div class='b_modify_images_pic_make_main'>
                    <div data-pid='<?= $data['pid'] ?>' data-img_idx='3'
                         data-img_set_main
                         class='b_modify_images_pic_main_icon'>
                      <i class="fa fa-desktop" title="Set as main image"></i>
                    </div>
                  </div>
                <?php } ?>
                <input type="hidden" value="<?= isset($data['u_image3']) ? $data['image3'] : '' ?>" name="image3">
              </div>
            </label>
          </div>
        </div>
        <div class="col-xs-6 col-md-6">
          <div class="row">
            <label class="col-xs-12 no-offset-left no-offset-right">
              <input type="radio" name="images" class="images" value="4" style="display:none;"/>
              <div data-img class='b_modify_images_pic'
                   style='background-image: url(<?= !empty($data['u_image4']) ? $data['u_image4'] : $not_image; ?>); background-size: 100px 100px;'>
                <?php if(!empty($data['u_image4'])) { ?>
                  <div class='b_modify_images_pic_del'>
                    <a href='<?= $data['pid'] ?>' title="Remove Image" data-img_idx='4' data-img_del class='pic_del_images'>
                      <span><i class="fa fa-times" aria-hidden="true"></i></span>
                    </a>
                  </div>
                  <div class='b_modify_images_pic_make_main'>
                    <div data-pid='<?= $data['pid'] ?>' data-img_idx='4'
                         data-img_set_main
                         class='b_modify_images_pic_main_icon'>
                      <i class="fa fa-desktop" title="Set as main image"></i>
                    </div>
                  </div>
                <?php } ?>
                <input type="hidden" value="<?= isset($data['u_image4']) ? $data['image4'] : '' ?>" name="image4">
              </div>
            </label>
          </div>
        </div>
        <div class="col-xs-6 col-md-6">
          <div class="row">
            <label class="col-xs-12 no-offset-left no-offset-right">
              <input type="radio" name="images" class="images" value="5" style="display:none;"/>
              <div data-img class='b_modify_images_pic'
                   style='background-image: url(<?= !empty($data['u_image5']) ? $data['u_image5'] : $not_image; ?>); background-size: 100px 100px;'>
                <?php if(!empty($data['u_image5'])) { ?>
                  <div class='b_modify_images_pic_del'>
                    <a href='<?= $data['pid'] ?>' title="Remove Image" data-img_idx='5' data-img_del class='pic_del_images'>
                      <span><i class="fa fa-times" aria-hidden="true"></i></span>
                    </a>
                  </div>
                  <div class='b_modify_images_pic_make_main'>
                    <div data-pid='<?= $data['pid'] ?>' data-img_idx='5'
                         data-img_set_main
                         class='b_modify_images_pic_main_icon'>
                      <i class="fa fa-desktop" title="Set as main image"></i>
                    </div>
                  </div>
                <?php } ?>
                <input type="hidden" value="<?= isset($data['u_image5']) ? $data['image5'] : '' ?>" name="image5">
              </div>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="status" class="col-xs-12 text-center red">
  <?= isset($img_error) ? $img_error : '' ?>
</div>
<input type="file"  data-img_uploadfile id="uploadfile" name="uploadfile" class="img-uploadfile">
