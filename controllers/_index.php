<?php

Class Controller_Index Extends Controller_Controller
{

    function index()
    {
        $this->main->view('index');
    }

    function service()
    {
        $this->main->view('static/service');
    }

    function newsletter()
    {
        $this->main->view('static/newsletter');
    }

    function privacy()
    {
        $this->main->view('static/privacy');
    }

    function contact()
    {
        $this->main->view('static/contact');
    }

    function about()
    {
        $this->main->view('static/about');
    }
//////////////////////////////////////////////////////////// STATIC

//    function show_break_img_count()
//    {
//        set_time_limit(14400);
//        $q_total = "SELECT COUNT(*) FROM `fabrix_products` a" .
//            " WHERE  a.pnumber is not null and a.pvisible = '1'";
//        $res = mysql_query($q_total);
//        $total = mysql_fetch_row($res);
//        $total = $total[0];
//
//        $q = "SELECT pid FROM `fabrix_products` a" .
//            " WHERE  a.pnumber is not null and a.pvisible = '1'";
//        $res = mysql_query($q);
//        $model = new Model_Users();
//        $f = [1, 2, 3, 4, 5];
//        $total_break = 0;
//        $total_break_p = 0;
//        $total_break_v = 0;
//        while ($row = mysql_fetch_assoc($res)) {
//            $pid = $row['pid'];
//            $images = $model->getImage($pid);
//            foreach ($f as $idx) {
//                $img = $images['image' . $idx];
//                if (!empty($img)) {
//                    $filename = 'upload/upload/' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break++;
//                            }
//                        } else {
//                            $total_break++;
//                        }
//                    } else {
//                        $total_break++;
//                    }
//                    $filename = 'upload/upload/p_' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break_p++;
//                            }
//                        } else {
//                            $total_break_p++;
//                        }
//                    } else {
//                        $total_break_p++;
//                    }
//                    $filename = 'upload/upload/v_' . $img;
//                    if (file_exists($filename) && is_readable($filename)) {
//                        $size_img = getimagesize($filename);
//                        if ($size_img) {
//                            $h = $size_img[0];
//                            $w = $size_img[1];
//                            if ($w == 0 || $h == 0) {
//                                $total_break_v++;
//                            }
//                        } else {
//                            $total_break_v++;
//                        }
//                    } else {
//                        $total_break_v++;
//                    }
//                }
//            }
//        }
//        echo $total . ' | ' . $total_break . ' | ' . $total_break_p . ' | ' . $total_break_v;
//    }

//////////////////////////////////////////////////////////// IMAGE
    function search()
    {
        $search_qv = Model_Tools::validData(_A_::$app->get('s'));
        $this->template->vars('userInfo', $search_qv);
        $this->main->view('search');
    }

    function message()
    {
        $this->main->message();
    }

    public function error404()
    {
        $this->main->error404();
    }
}
