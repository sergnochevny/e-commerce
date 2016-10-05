<style>
  input[type='radio'].images:checked + div.b_modify_images_pic {
    border: 1px dotted;
    margin: 5px;
  }

  input[type='radio'].images:checked + div.b_modify_images_main_pic {
    border: 1px dotted;
    margin: 5px;
  }
</style>
<div class="col-sm-12 col-md-12 b_modify_images_main">
  <div class="row">
    <div class="col-md-12 b_modify_images_1" style="margin-bottom: 30px">
      <label>
        <input type="radio" name="images" class="images" value="1" style="display:none;"/>
        <div class="b_modify_images_main_pic"
             style='background:no-repeat; background-image: url(<?= !empty($image1{0}) ? $image1 : $not_image; ?>); background-size: 300px; width: 300px; height:226px;'>
          <?php if(!empty($image1{0})) { ?>
            <div class='b_modify_images_pic_del'>
              <a href='<?= $p_id ?>' data-img_idx='1' class='pic_del_images'>
                <span>&times;</span>
              </a>
            </div>
          <?php } ?>
        </div>
      </label>
    </div>
    <div class="col-sm-12 col-md-12 b_modify_images_2">
      <div class="row">
        <div class="col-sm-6 col-md-6" style="margin-bottom: 30px">
          <label>

            <input type="radio" name="images" class="images" value="2" style="display:none;"/>
            <div class='b_modify_images_pic'
                 style='background-image: url(<?= !empty($image2{0}) ? $image2 : $not_image; ?>)'>
              <?php if(!empty($image2{0})) { ?>
                <div class='b_modify_images_pic_del'>
                  <a href='<?= $p_id ?>' data-img_idx='2' class='pic_del_images'>
                    <span>&times;</span>
                  </a>
                </div>
                <div class='b_modify_images_pic_make_main'>
                  <div data-p_id='<?= $p_id ?>' data-img_idx='2'
                       class='b_modify_images_pic_main_icon'>
                    <i class="fa fa-desktop" title="Set as main image"></i>
                  </div>
                </div>
              <?php } ?>
            </div>
          </label>

        </div>
        <div class="col-sm-6 col-md-6" style="margin-bottom: 30px">
          <label>
            <input type="radio" name="images" class="images" value="3" style="display:none;"/>

            <div class='b_modify_images_pic'
                 style='background-image: url(<?= !empty($image3{0}) ? $image3 : $not_image; ?>); background-size: 100px 100px;'>
              <?php if(!empty($image3{0})) { ?>
                <div class='b_modify_images_pic_del'>
                  <a href='<?= $p_id ?>' data-img_idx='3' class='pic_del_images'>
                    <span>&times;</span>
                  </a>
                </div>
                <div class='b_modify_images_pic_make_main'>
                  <div data-p_id='<?= $p_id ?>' data-img_idx='3'
                       class='b_modify_images_pic_main_icon'>
                    <i class="fa fa-desktop" title="Set as main image"></i>
                  </div>
                </div>
              <?php } ?>
            </div>
          </label>
        </div>
        <div class="col-sm-6 col-md-6"  style="margin-bottom: 30px">
          <label>
            <input type="radio" name="images" class="images" value="4" style="display:none;"/>
            <div class='b_modify_images_pic'
                 style='background-image: url(<?= !empty($image4{0}) ? $image4 : $not_image; ?>); background-size: 100px 100px;'>
              <?php if(!empty($image4{0})) { ?>
                <div class='b_modify_images_pic_del'>
                  <a href='<?= $p_id ?>' data-img_idx='4' class='pic_del_images'>
                    <span>&times;</span>
                  </a>
                </div>
                <div class='b_modify_images_pic_make_main'>
                  <div data-p_id='<?= $p_id ?>' data-img_idx='4'
                       class='b_modify_images_pic_main_icon'>
                    <i class="fa fa-desktop" title="Set as main image"></i>
                  </div>
                </div>
              <?php } ?>
            </div>
          </label>
        </div>
        <div class="col-sm-6 col-md-6" style="margin-bottom: 30px">
          <label>
            <input type="radio" name="images" class="images" value="5" style="display:none;"/>
            <div class='b_modify_images_pic'
                 style='background-image: url(<?= !empty($image5{0}) ? $image5 : $not_image; ?>); background-size: 100px 100px;'>
              <?php if(!empty($image5{0})) { ?>
                <div class='b_modify_images_pic_del'>
                  <a href='<?= $p_id ?>' data-img_idx='5' class='pic_del_images'>
                    <span>&times;</span>
                  </a>
                </div>
                <div class='b_modify_images_pic_make_main'>
                  <div data-p_id='<?= $p_id ?>' data-img_idx='5'
                       class='b_modify_images_pic_main_icon'>
                    <i class="fa fa-desktop" title="Set as main image"></i>
                  </div>
                </div>
              <?php } ?>
            </div>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="status" class="col-sm-12 col-md-12 text-center red">
</div>