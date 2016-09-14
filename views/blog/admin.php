<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link type='text/css' href='modal_windows/modal_windows/css/confirm.css' rel='stylesheet' media='screen'/>

<div class="site-container">
    <?php include "views/header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?php include('views/blog/blog_admin_content.php')?>
            </div>
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
    (function ($) {
        $(document).on('click.confirm_action', ".popup a.close",function (e) {
            $("#confirm_action").off('click.confirm_action');
            $("#confirm_dialog").removeClass('overlay_display');
        });

        $(document).on('click.confirm_action', "#confirm_no", function (e) {
            $(".popup a.close").trigger('click');
        });

        $(document).on('click', "#del_post",
            function (event) {
                event.preventDefault();

                var href = $(this).attr('href');

                $("#confirm_action").on('click.confirm_action',
                    function (event) {
                        event.preventDefault();
                        $.get(
                            href,
                            {},
                            function(data){
                                $('#content').html(data);
                                $("#confirm_dialog").removeClass('overlay_display');
                                $("#confirm_action").off('click.confirm_action');
                                $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                                setTimeout(function(){
                                    $('.danger').remove();
                                },8000);
                            }
                        );
//                        window.location.href = href;
                    }
                );

                $("#confirm_dialog").addClass('overlay_display');
            }
        );
    })(jQuery);
</script>


 