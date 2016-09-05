<?php
        $userInfo = $model->validData($_GET['category_id']);
        $category_id = $userInfo['data'];
        $userInfo = $model->validData($_POST['category']);
        $post_category_name=mysql_real_escape_string($userInfo['data']);
        $userInfo = $model->validData($_POST['display_order']);
        $post_display_order=$userInfo['data'];
        $userInfo = $model->validData($_POST['seo']);
        $post_category_seo=mysql_real_escape_string($userInfo['data']);
        $userInfo = $model->validData(isset($_POST['ListStyle'])?$_POST['ListStyle']:0);
        $post_category_ListStyle=$userInfo['data'];
        $userInfo = $model->validData(isset($_POST['ListNewItem'])?$_POST['ListNewItem']:0);
        $post_category_ListNewItem=$userInfo['data'];
?>