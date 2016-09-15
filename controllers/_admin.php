<?php

Class Controller_Admin Extends Controller_Controller
{

    function home()
    {
//        session_destroy();
//        unset($_SESSION);
        $this->main->test_access_rights();
        $shop = new Controller_Shop($this->main);
        $shop->all_products();
        $shop->product_filtr_list();

        $this->main->view_admin('home');
    }

}
