<?php

class Controller_Image extends Controller_Base
{

    protected $main;

    function __construct($main)
    {

        $this->main = $main;
        $this->registry = $main->registry;
        $this->template = $main->template;

    }

    function del_pic()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        $userInfo = $model->validData($_GET['produkt_id']);
        $pid_id = $userInfo['data'];
        $userInfo = $model->validData($_GET['idx']);
        $im_id = $userInfo['data'];
        if (!empty($pid_id)) {
            if (!empty($im_id)) {
                $db_g = "image$im_id";
                $images = $model->getImage($pid_id);
                $filename = $images[$db_g];
                $userInfo = $model->dbUpdate($db_g, $pid_id);
                if (file_exists("upload/upload/" . $filename)) {
                    unlink("upload/upload/$filename");
                }
                if (file_exists("upload/upload/b_" . $filename)) {
                    unlink("upload/upload/b_" . $filename);
                }
                if (file_exists("upload/upload/v_" . $filename)) {
                    unlink("upload/upload/v_" . $filename);
                }

            }
        }
        $this->modify_images();
    }

    function modify_images()
    {
        $this->main->test_access_rights();
        if (!empty($_GET['produkt_id'])) {
            $produkt_id = $_GET['produkt_id'];
            $model = new Model_Users();
            $userInfo = $model->validData($produkt_id);
            $produkt_id = $userInfo['data'];
            $userInfo = $model->getImage($produkt_id);
            $image1 = $userInfo['image1'];
            $image2 = $userInfo['image2'];
            $image3 = $userInfo['image3'];
            $image4 = $userInfo['image4'];
            $image5 = $userInfo['image5'];

            $base_url = BASE_URL;

            $not_image = $base_url . '/upload/upload/not_image.jpg';
            if (empty($image1{0}) || !is_file('upload/upload/' . $image1)) {
                $image1 = '';
            } else {
                $image1 = $base_url . '/upload/upload/v_' . $image1;
            }
            if (empty($image2{0}) || !is_file('upload/upload/' . $image2)) {
                $image2 = '';
            } else {
                $image2 = $base_url . '/upload/upload/' . $image2;
            }
            if (empty($image3{0}) || !is_file('upload/upload/' . $image3)) {
                $image3 = '';
            } else {
                $image3 = $base_url . '/upload/upload/' . $image3;
            }
            if (empty($image4{0}) || !is_file('upload/upload/' . $image4)) {
                $image4 = '';
            } else {
                $image4 = $base_url . 'upload/upload/' . $image4;
            }
            if (empty($image5{0}) || !is_file('upload/upload/' . $image5)) {
                $image5 = '';
            } else {
                $image5 = $base_url . '/upload/upload/' . $image5;
            }

            include('views/index/product/product_m_images.php');

        }

    }

    function modify_images_from_form($userInfo)
    {
        $image1 = $userInfo['image1'];
        $image2 = $userInfo['image2'];
        $image3 = $userInfo['image3'];
        $image4 = $userInfo['image4'];
        $image5 = $userInfo['image5'];
        $filename1 = 'upload/upload/v_' . $image1;
        if (!file_exists($filename1)) {
            $image1 = "not_image.jpg";
        }
        $filename2 = 'upload/upload/' . $image2;
        if (!file_exists($filename2)) {
            $image2 = "not_image.jpg";
        }
        $filename3 = 'upload/upload/' . $image3;
        if (!file_exists($filename3)) {
            $image3 = "not_image.jpg";
        }
        $filename4 = 'upload/upload/' . $image4;
        if (!file_exists($filename4)) {
            $image4 = "not_image.jpg";
        }
        $filename5 = 'upload/upload/' . $image5;
        if (!file_exists($filename5)) {
            $image5 = "not_image.jpg";
        }
        include('views/index/product/product_m_images.php');

    }

    function  save_img_link()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        if (!empty($_GET['produkt_id'])) {
            if (!empty($_GET['idx'])) {
                $userInfo = $model->validData($_GET['produkt_id']);
                $produkt_id = $userInfo['data'];
                $userInfo = $model->validData($_GET['idx']);
                $produkt_photo = $userInfo['data'];
                $db_g = "image$produkt_photo";
                $userInfo = $model->getImage($produkt_id);
                $image1 = $userInfo['image1'];
                $image2 = $userInfo[$db_g];
                $userInfo = $model->dbUpdateMainNew($image2, $db_g, $image1, $produkt_id);

            }
        }

        $this->modify_images();
    }

    private function prepare_product_img($imagename){

        $size = getimagesize("upload/upload/".$imagename);
        $imgWidth=$size[0];
        $imgHeight=$size[1];

        $imagefrom = imagecreatefromjpeg("upload/upload/".$imagename);

        $imagetovbig = imagecreatetruecolor(760, 569);
        imagecopyresampled($imagetovbig, $imagefrom, 0, 0, 0, 0, 760, 569, $imgWidth, $imgHeight);
        imagejpeg( $imagetovbig,"upload/upload/v_".$imagename, 85);
        imagedestroy($imagetovbig);

        $imagetobig = imagecreatetruecolor(230,170);
        imagecopyresampled($imagetobig, $imagefrom, 0, 0, 0, 0, 230, 170, $imgWidth, $imgHeight);
        imagejpeg( $imagetobig, "upload/upload/b_".$imagename, 85);
        imagedestroy($imagetobig);

        $imagetosmall = imagecreatetruecolor(100,70);
        imagecopyresampled($imagetosmall, $imagefrom, 0, 0, 0, 0, 100, 70, $imgWidth, $imgHeight);
        imagejpeg( $imagetosmall,"upload/upload/".$imagename, 85);
        imagedestroy($imagefrom);
    }

    function upload_product_img()
    {
        $this->main->test_access_rights();
        $model = new Model_Users();
        if (!empty($_GET['pid'])) {
            $produkt_photo = isset($_GET['idx']) ? $_GET['idx'] : 1;
            $userInfo = $model->validData($_GET['pid']);
            $produkt_id = $userInfo['data'];
            $ts = uniqid();
            $uploaddir = 'upload/upload/';
            $file = "p".$produkt_id . "t" . $ts . '.jpg';
            $ext = substr($_FILES['uploadfile']['name'], strpos($_FILES['uploadfile']['name'], '.'), strlen($_FILES['uploadfile']['name']) - 1);
            $filetypes = array('.jpg', '.gif', '.bmp', '.png', '.JPG', '.BMP', '.GIF', '.PNG', '.jpeg', '.JPEG');

            if (!in_array($ext, $filetypes)) {
                echo "<p>Error format</p>";
            } else {
                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $file)) {
                    $db_g = "image$produkt_photo";
                    $this->prepare_product_img($file);
                    // delete img;
                    $model->dbUpdateMainPhoto($db_g, $file, $produkt_id);
                    echo "success";
                } else {
                    echo "error";
                }
            }
        }

    }

}