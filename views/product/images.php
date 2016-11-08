<div class="row">
  <div class="col-sm-12 col-md-12 b_modify_images_main">
    <div class="row">
      <div class="col-md-12 b_modify_images_1">
        <div class="row">
          <label class="col-xs-12 no-offset-left no-offset-right">
            <input type="radio" name="images" class="images" value="1" style="display:none;"/>
            <div class="b_modify_images_main_pic"
                 style='background:no-repeat; background-image: url(<?= !empty($data['u_image1']) ? $data['u_image1'] : $not_image; ?>); background-size: 300px; width: 300px;'>
              <?php if(!empty($data['u_image1'])) { ?>
                <div class='b_modify_images_pic_del'>
                  <a href='<?= $data['pid'] ?>' data-img_idx='1' class='pic_del_images'>
                    <span>&times;</span>
                  </a>
                </div>
              <?php } ?>
              <input type="hidden" value="<?= !empty($data['u_image1']) ? $data['image1'] : '' ?>" name="image1">
            </div>
          </label>
        </div>
      </div>
      <div class="col-sm-12 col-md-12 b_modify_images_2">
        <div class="row">
          <div class="col-xs-6 col-md-6">
            <div class="row">
              <label class="col-xs-12 no-offset-left no-offset-right">
                <input type="radio" name="images" class="images" value="2" style="display:none;"/>
                <div class='b_modify_images_pic'
                     style='background-image: url(<?= !empty($data['u_image2']) ? $data['u_image2'] : $not_image; ?>)'>
                  <?php if(!empty($data['u_image2'])) { ?>
                    <div class='b_modify_images_pic_del'>
                      <a href='<?= $data['pid'] ?>' data-img_idx='2' class='pic_del_images'>
                        <span>&times;</span>
                      </a>
                    </div>
                    <div class='b_modify_images_pic_make_main'>
                      <div data-pid='<?= $data['pid'] ?>' data-img_idx='2'
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
                <div class='b_modify_images_pic'
                     style='background-image: url(<?= !empty($data['u_image3']) ? $data['u_image3'] : $not_image; ?>); background-size: 100px 100px;'>
                  <?php if(!empty($data['u_image3'])) { ?>
                    <div class='b_modify_images_pic_del'>
                      <a href='<?= $data['pid'] ?>' data-img_idx='3' class='pic_del_images'>
                        <span>&times;</span>
                      </a>
                    </div>
                    <div class='b_modify_images_pic_make_main'>
                      <div data-pid='<?= $data['pid'] ?>' data-img_idx='3'
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
                <div class='b_modify_images_pic'
                     style='background-image: url(<?= !empty($data['u_image4']) ? $data['u_image4'] : $not_image; ?>); background-size: 100px 100px;'>
                  <?php if(!empty($data['u_image4'])) { ?>
                    <div class='b_modify_images_pic_del'>
                      <a href='<?= $data['pid'] ?>' data-img_idx='4' class='pic_del_images'>
                        <span>&times;</span>
                      </a>
                    </div>
                    <div class='b_modify_images_pic_make_main'>
                      <div data-pid='<?= $data['pid'] ?>' data-img_idx='4'
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
                <div class='b_modify_images_pic'
                     style='background-image: url(<?= !empty($data['u_image5']) ? $data['u_image5'] : $not_image; ?>); background-size: 100px 100px;'>
                  <?php if(!empty($data['u_image5'])) { ?>
                    <div class='b_modify_images_pic_del'>
                      <a href='<?= $data['pid'] ?>' data-img_idx='5' class='pic_del_images'>
                        <span>&times;</span>
                      </a>
                    </div>
                    <div class='b_modify_images_pic_make_main'>
                      <div data-pid='<?= $data['pid'] ?>' data-img_idx='5'
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
</div>
<div id="status" class="col-sm-12 col-md-12 text-center red">
  <?= isset($img_error) ? $img_error : '' ?>
</div>
<input type="file" id="uploadfile" name="uploadfile" style="position: absolute; margin: -5px 0px 0px -175px; padding: 0px; width: 220px; height: 30px; font-size: 14px; opacity: 0; cursor: pointer; display: block; z-index: 2147483583; top: 3165px; left: 380px;">
