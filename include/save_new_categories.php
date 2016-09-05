<?php
    $userInfo = $model->validData(isset($_POST['seo'])?$_POST['seo']:'');
    $post_category_seo=mysql_real_escape_string($userInfo['data']);
    $userInfo = $model->validData(isset($_POST['ListStyle'])?$_POST['ListStyle']:0);
    $post_category_ListStyle=$userInfo['data']; 
    $userInfo = $model->validData(isset($_POST['ListNewItem'])?$_POST['ListNewItem']:0);
    $post_category_ListNewItem=$userInfo['data'];        
    if ($post_category_ListStyle=="1"){$post_category_ListStyle="1";}else{$post_category_ListStyle="0";}
    if ($post_category_ListNewItem=="1"){$post_category_ListNewItem="1";}else{$post_category_ListNewItem="0";}
?>