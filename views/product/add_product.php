<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<script type="text/javascript" src="<?php echo $base_url;?>/upload/js/ajaxupload.3.5.js"></script>
<link rel='stylesheet' id='toko-style-css' href='<?php echo $base_url;?>/views/css/style.css' type='text/css' media='all'/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/upload/styles.css">

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">

                <a href="<?php echo $back_url;?>" class="back_button"><input type="submit" value="Back" class="button"></a>

                <h1 class="page-title">ADD FABRIC</h1>

                <div id="customer_details" class="col2-set">
                    <div class="woocommerce">
                        <div  id="form_product">
                        <?php include('views/product/edit_form.php'); ?>
                        </div>
                    </div>
                </div>
                <b id="tests"></b>
            </div>
        </div>
    </div>

    <div id="confirm_dialog" class="overlay"></div>
    <div class="popup">
        <div class="fcheck"></div>
        <a class="close" title="close"></a>

        <div class="b_cap_cod_main">
            <p style="color: black;">You confirm the removal ?</p>
            <br/>
            <center>
                <a id="confirm_action">
                    <input type="button" value="Yes confirm" class="button"/></a>
                <a id="confirm_no">
                    <input type="button" value="No" class="button"/></a>
            </center>
        </div>
    </div>

    <script type="text/javascript">
        (function($){
            $(document).on('click', 'a.pic_del_images',
                function (event) {
                    event.preventDefault();
                    var produkt_id = $(this).attr('href');
                    var i_idx = $(this).attr('data-img_idx');

                    $("#confirm_action").on('click.confirm_action',
                        function (event) {
                            event.preventDefault();
                            $.get(
                                'del_pic?produkt_id=' + produkt_id + '&idx=' + i_idx,
                                {},
                                function(data){
                                    $('#modify_images2').html(data);
                                    $("#confirm_dialog").removeClass('overlay_display');
                                    $("#confirm_action").off('click.confirm_action');
                                }
                            );
                        }
                    );

                    $("#confirm_dialog").addClass('overlay_display');

                }
            );

            $(document).on('click', '.b_modify_images_pic_main_icon',
                function (event) {
                    event.preventDefault();
                    var produkt_id = $(this).attr('data-produkt_id');
                    var i_idx = $(this).attr('data-img_idx');
                    $.get(
                        'save_img_link?produkt_id=' + produkt_id + '&idx=' + i_idx,
                        {},
                        function(data){
                            $('#modify_images2').html(data);
                        }
                    )
                }
            );

            $(document).on('click.confirm_action', ".popup a.close",
                function (event) {
                    $("#confirm_action").off('click.confirm_action');
                    $("#confirm_dialog").removeClass('overlay_display');
                }
            );

            $(document).on('click.confirm_action', "#confirm_no",
                function (event) {

                    $(".popup a.close").trigger('click');
                }
            );
        })(jQuery);
    </script>