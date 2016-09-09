<body class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link type='text/css' href='modal_windows/modal_windows/css/confirm.css' rel='stylesheet' media='screen'/>
<script type='text/javascript' src='modal_windows/modal_windows/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='modal_windows/modal_windows/js/modal_windows.js'></script>

<div class="site-container">
    <?php include "views/header.php"; ?>
    <div class="main-content main-content-shop">
        <center><h1>COMMENTS</h1></center>
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <?php include('views/comments/admin_comments_list.php') ?>
            </div>
        </div>
        <div id="confirm_dialog" class="overlay"></div>
        <div class="popup">
            <div class="fcheck"></div>
            <a class="close" title="close"></a>

            <div class="b_cap_cod_main">
                <p style="color: black;" id="dialog-text"></p>
                <br/>
                <center>
                    <a id="confirm_action">
                        <input type="button" value="Yes confirm" class="button"/></a>
                    <a id="confirm_no">
                        <input type="button" value="No" class="button"/></a>
                </center>
            </div>
        </div>

        <div id="comment-view-dialog" class="overlay"></div>
        <div class="popup-view popup">
            <div class="fcheck"></div>
            <a class="close" title="close"></a>

            <div class="" id="comment-view-dialog-data">
                <p style="color: black;" id="dialog-text"></p>
                <br/>
                <center>

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
                        $("#dialog-text").html("You confirm the removal?");

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
                $(document).on('click', 'a#public_comment',
                    function (event) {
                        event.preventDefault();
                        var href = $(this).attr('href');
                        var mode = "";
                        var a1 = $(this).attr("value");

                        if(a1 == "1") $("#dialog-text").html("Hide comment?");
                        else $("#dialog-text").html("Show comment?");
                        
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
                $(document).on('click', 'a#view-comment',
                    function (event) {
                        event.preventDefault();
                        var href = $(this).attr('href');


                        $.get(href, function(data){
                           $("#comment-view-dialog-data").html(data);
                        });

                        $(".close").on('click.close',
                            function (event){
                                event.preventDefault();
                                $("#comment-view-dialog").removeClass('overlay_display');
                            });

                        $("#comment-view-dialog").addClass('overlay_display');
                    }
                );
                $(document).on('click', 'a#edit-comment',
                    function (event) {
                        event.preventDefault();
                        var href = $(this).attr('href');
                        var href_update = "<?= BASE_URL ?>" + "/update_comment_list";

                        $.get(href, function(data){
                            $("#comment-view-dialog-data").html(data);
                            $("#add-form-send").bind("click", function(){
                                $('#content').load(href_update);
                                //$("#comment-view-dialog").removeClass('overlay_display');
                            });
                        });

                        $(".close").on('click.close',
                            function (event){
                                event.preventDefault();
                                $('#content').load(href_update);
                                $("#comment-view-dialog").removeClass('overlay_display');
                            });

                        $("#comment-view-dialog").addClass('overlay_display');
                    }
                );
            })(jQuery);
        </script>