<?php

  class Controller_Image extends Controller_Controller {

    private function prepare($imagename) {

      $size = getimagesize("upload/upload/" . $imagename);
      $imgWidth = $size[0];
      $imgHeight = $size[1];

      $imagefrom = imagecreatefromjpeg("upload/upload/" . $imagename);

      $imagetovbig = imagecreatetruecolor(760, 569);
      imagecopyresampled($imagetovbig, $imagefrom, 0, 0, 0, 0, 760, 569, $imgWidth, $imgHeight);
      imagejpeg($imagetovbig, "upload/upload/v_" . $imagename, 85);
      imagedestroy($imagetovbig);

      $imagetobig = imagecreatetruecolor(230, 170);
      imagecopyresampled($imagetobig, $imagefrom, 0, 0, 0, 0, 230, 170, $imgWidth, $imgHeight);
      imagejpeg($imagetobig, "upload/upload/b_" . $imagename, 85);
      imagedestroy($imagetobig);

      $imagetosmall = imagecreatetruecolor(100, 70);
      imagecopyresampled($imagetosmall, $imagefrom, 0, 0, 0, 0, 100, 70, $imgWidth, $imgHeight);
      imagejpeg($imagetosmall, "upload/upload/" . $imagename, 85);
      imagedestroy($imagefrom);
    }

    public function del() {
      $this->main->test_access_rights();
      $pid_id = Model_Product::validData(_A_::$app->get('p_id'));
      $im_id = Model_Product::validData(_A_::$app->get('idx'));
      if(!empty($pid_id)) {
        if(!empty($im_id)) {
          $db_g = "image$im_id";
          $images = Model_Product::getImage($pid_id);
          $filename = $images[$db_g];
          $data = Model_Product::update_field($db_g, $pid_id);
          if(file_exists("upload/upload/" . $filename)) {
            unlink("upload/upload/$filename");
          }
          if(file_exists("upload/upload/b_" . $filename)) {
            unlink("upload/upload/b_" . $filename);
          }
          if(file_exists("upload/upload/v_" . $filename)) {
            unlink("upload/upload/v_" . $filename);
          }
        }
      }
      $this->modify();
    }

    /**
     * @export
     */
    public function modify() {
      $this->main->test_access_rights();
      if(!is_null(_A_::$app->get('p_id'))) {
        $p_id = _A_::$app->get('p_id');
        $p_id = Model_Product::validData($p_id);
        $data = Model_Product::getImage($p_id);
        $image1 = $data['image1'];
        $image2 = $data['image2'];
        $image3 = $data['image3'];
        $image4 = $data['image4'];
        $image5 = $data['image5'];

        $base_url = _A_::$app->router()->UrlTo('/');

        $not_image = _A_::$app->router()->UrlTo('upload/upload/not_image.jpg');
        $image1 = empty($image1{0}) || !is_file('upload/upload/' . $image1) ? '' : _A_::$app->router()->UrlTo('upload/upload/v_' . $image1);
        $image2 = empty($image2{0}) || !is_file('upload/upload/' . $image2) ? '' : _A_::$app->router()->UrlTo('upload/upload/' . $image2);
        $image3 = empty($image3{0}) || !is_file('upload/upload/' . $image3) ? '' : _A_::$app->router()->UrlTo('upload/upload/' . $image3);
        $image4 = empty($image4{0}) || !is_file('upload/upload/' . $image4) ? '' : _A_::$app->router()->UrlTo('upload/upload/' . $image4);
        $image5 = empty($image5{0}) || !is_file('upload/upload/' . $image5) ? '' : _A_::$app->router()->UrlTo('upload/upload/' . $image5);

        $this->template->vars('not_image', $not_image);
        $this->template->vars('image1', $image1);
        $this->template->vars('image2', $image2);
        $this->template->vars('image3', $image3);
        $this->template->vars('image4', $image4);
        $this->template->vars('image5', $image5);
        $this->template->vars('p_id', $p_id);
        $this->template->view_layout('m_images');
      }
    }

    public function modify_from_form($data) {
      $image1 = $data['image1'];
      $image2 = $data['image2'];
      $image3 = $data['image3'];
      $image4 = $data['image4'];
      $image5 = $data['image5'];
      $filename1 = 'upload/upload/v_' . $image1;
      if(!file_exists($filename1)) {
        $image1 = "not_image.jpg";
      }
      $filename2 = 'upload/upload/' . $image2;
      if(!file_exists($filename2)) {
        $image2 = "not_image.jpg";
      }
      $filename3 = 'upload/upload/' . $image3;
      if(!file_exists($filename3)) {
        $image3 = "not_image.jpg";
      }
      $filename4 = 'upload/upload/' . $image4;
      if(!file_exists($filename4)) {
        $image4 = "not_image.jpg";
      }
      $filename5 = 'upload/upload/' . $image5;
      if(!file_exists($filename5)) {
        $image5 = "not_image.jpg";
      }
      $this->template->vars('image1', $image1);
      $this->template->vars('image2', $image2);
      $this->template->vars('image3', $image3);
      $this->template->vars('image4', $image4);
      $this->template->vars('image5', $image5);
      $this->template->view_layout('m_images');
    }

    public function save() {
      $this->main->test_access_rights();
      if(!is_null(_A_::$app->get('p_id'))) {
        if(!is_null(_A_::$app->get('idx'))) {
          $p_id = Model_Product::validData(_A_::$app->get('p_id'));
          $product_photo = Model_Product::validData(_A_::$app->get('idx'));
          $db_g = "image$product_photo";
          $data = Model_Product::getImage($p_id);
          $image1 = $data['image1'];
          $image2 = $data[$db_g];
          $data = Model_Product::dbUpdateMainNew($image2, $db_g, $image1, $p_id);
        }
      }

      $this->modify();
    }

    public function upload() {
      $this->main->test_access_rights();
      if(!is_null(_A_::$app->get('p_id'))) {
        $product_photo = !is_null(_A_::$app->get('idx')) ? _A_::$app->get('idx') : 1;
        $p_id = _A_::$app->get('p_id');
        $ts = uniqid();
        $uploaddir = 'upload/upload/';
        $file = "p" . $p_id . "t" . $ts . '.jpg';
        $ext = substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1);
        $filetypes = ['.jpg', '.gif', '.bmp', '.png', '.JPG', '.BMP', '.GIF', '.PNG', '.jpeg', '.JPEG'];

        if(!in_array($ext, $filetypes)) {
          echo "<p>Error format</p>";
        } else {
          if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
            $db_g = "image$product_photo";
            $this->prepare($file);
            // delete img;
            Model_Product::dbUpdateMainPhoto($db_g, $file, $p_id);
            echo "success";
          } else {
            echo "error";
          }
        }
      }
    }

    public function modify_products($imagename) {

      if(file_exists("upload/upload/" . $imagename)) {
        try {

          $size = getimagesize("upload/upload/" . $imagename);
          $imgWidth = $size[0];
          $imgHeight = $size[1];

          $imagefrom = imagecreatefromjpeg("upload/upload/" . $imagename);

          if(!file_exists("upload/upload/v_" . $imagename)) {
            $imagetovbig = imagecreatetruecolor(760, 569);
            imagecopyresampled($imagetovbig, $imagefrom, 0, 0, 0, 0, 760, 569, $imgWidth, $imgHeight);
            imagejpeg($imagetovbig, "upload/upload/v_" . $imagename, 85);
            imagedestroy($imagetovbig);
          }

          if(!file_exists("upload/upload/b_" . $imagename)) {
            $imagetobig = imagecreatetruecolor(230, 170);
            imagecopyresampled($imagetobig, $imagefrom, 0, 0, 0, 0, 230, 170, $imgWidth, $imgHeight);
            imagejpeg($imagetobig, "upload/upload/b_" . $imagename, 85);
            imagedestroy($imagetobig);
          }
          $imagetosmall = imagecreatetruecolor(100, 70);
          imagecopyresampled($imagetosmall, $imagefrom, 0, 0, 0, 0, 100, 70, $imgWidth, $imgHeight);
          imagejpeg($imagetosmall, "upload/upload/" . $imagename, 85);
          imagedestroy($imagefrom);
        } catch(Exception $e) {
          echo $e->getMessage();
        }
      }
    }

  }