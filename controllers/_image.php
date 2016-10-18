<?php

  class Controller_Image extends Controller_Controller {

    private function convert($imagename) {

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

    public function upload() {
      if(!is_null(_A_::$app->get('pid'))) {
        $product_photo = !is_null(_A_::$app->get('idx')) ? _A_::$app->get('idx') : 1;
        $pid = _A_::$app->get('pid');
        $ts = uniqid();
        $uploaddir = 'upload/upload/';
        $file = "p" . $pid . "t" . $ts . '.jpg';
        $ext = substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1);
        $filetypes = ['.jpg', '.gif', '.bmp', '.png', '.JPG', '.BMP', '.GIF', '.PNG', '.jpeg', '.JPEG'];

        if(!in_array($ext, $filetypes)) {
          echo "<p>Error format</p>";
        } else {
          if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
            $db_g = "image$product_photo";
            $this->convert($file);
            // delete img;
            Model_Product::dbUpdateMainPhoto($db_g, $file, $pid);
            echo "success";
          } else {
            echo "error";
          }
        }
      }
    }

//    public function modify_products($imagename) {
//
//      if(file_exists("upload/upload/" . $imagename)) {
//        try {
//
//          $size = getimagesize("upload/upload/" . $imagename);
//          $imgWidth = $size[0];
//          $imgHeight = $size[1];
//
//          $imagefrom = imagecreatefromjpeg("upload/upload/" . $imagename);
//
//          if(!file_exists("upload/upload/v_" . $imagename)) {
//            $imagetovbig = imagecreatetruecolor(760, 569);
//            imagecopyresampled($imagetovbig, $imagefrom, 0, 0, 0, 0, 760, 569, $imgWidth, $imgHeight);
//            imagejpeg($imagetovbig, "upload/upload/v_" . $imagename, 85);
//            imagedestroy($imagetovbig);
//          }
//
//          if(!file_exists("upload/upload/b_" . $imagename)) {
//            $imagetobig = imagecreatetruecolor(230, 170);
//            imagecopyresampled($imagetobig, $imagefrom, 0, 0, 0, 0, 230, 170, $imgWidth, $imgHeight);
//            imagejpeg($imagetobig, "upload/upload/b_" . $imagename, 85);
//            imagedestroy($imagetobig);
//          }
//          $imagetosmall = imagecreatetruecolor(100, 70);
//          imagecopyresampled($imagetosmall, $imagefrom, 0, 0, 0, 0, 100, 70, $imgWidth, $imgHeight);
//          imagejpeg($imagetosmall, "upload/upload/" . $imagename, 85);
//          imagedestroy($imagefrom);
//        } catch(Exception $e) {
//          echo $e->getMessage();
//        }
//      }
//    }

  }