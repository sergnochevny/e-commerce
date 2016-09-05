<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link type='text/css' href='modal_windows/modal_windows/css/confirm.css' rel='stylesheet' media='screen'/>
<script type='text/javascript' src='modal_windows/modal_windows/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='modal_windows/modal_windows/js/modal_windows.js'></script>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?php include('views/index/user/users_list.php') ?>
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

                $(document).on('click', 'a#del_user',
                    function (event) {
                        event.preventDefault();
                        var href = $(this).attr('href');

                        $("#confirm_action").on('click.confirm_action',
                            function (event) {
                                event.preventDefault();
                                $('#content').load(href);
                                $("#confirm_dialog").removeClass('overlay_display');
                                $("#confirm_action").off('click.confirm_action');
                            }
                        );

                        $("#confirm_dialog").addClass('overlay_display');

                    }
                );
            })(jQuery);
        </script>