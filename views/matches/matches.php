<body
    class="home page page-template page-template-page_visual_composer page-template-page_visual_composer-php header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive">

<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/simple-line-icons.css'); ?>' type='text/css' media='all'/>
<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/matches.css'); ?>' type='text/css' media='all'/>

<link rel='stylesheet' charset="UTF-8" href='<?php echo _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' type='text/css' media='all'/>
<script type='text/javascript' charset="UTF-8" src='<?php echo _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

<div class="site-container">
    <?php
    include "views/shop_header.php";

    //    include('views/index/main_gallery.php');
    ?>

    <style>
        .toko-posts-grid .toko-post {
            margin: 0 0 20px;
        }

        .toko-posts-grid .toko-post-image {
            background-position: center center;
            background-size: cover;
            height: 200px;
            margin: 0 0 20px;
            overflow: hidden;
        }

        .toko-posts-grid .toko-post-image a {
            display: block;
            height: 200px;
        }

        .toko-posts-grid .toko-post-detail .post-title {
            margin: 0;
            font-size: 20px;
            font-weight: lighter;
            text-transform: uppercase;
            padding: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .toko-posts-grid .toko-post-detail .post-title a {
            color: #222222;
        }

        .toko-posts-grid .toko-post-detail .post-date {
            font-size: 14px !important;
            color: #5f5f5f !important;
            text-transform: uppercase;
            font-weight: normal;
            padding: 0;
        }

        .toko-posts-grid .toko-post-detail > p {
            display: block;
            font-size: 12px;
            font-weight: normal;
            height: 100px;
            margin: 0;
            overflow: hidden;
            padding: 0;
            position: relative;
        }

        .toko-posts-grid .toko-post-detail > p > span.opa {
            background-image: url("<?php echo _A_::$app->router()->UrlTo('views/images/bg-opa.png');?>");
            bottom: 0;
            display: block;
            height: 80px;
            position: absolute;
            width: 100%;
        }

    </style>

    <div class="main-content" id="matches-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <article class="page type-page status-publish entry">
                        <br/><br/>

                        <h1 class="entry-title">I Luv Fabrix Matches</h1>

                        <div class="entry-content">
                            <div class="vc_row wpb_row vc_row-fluid">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="wpb_wrapper">
                                        <div class="vc_row wpb_row vc_inner vc_row-fluid">
                                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                                <div class="wpb_wrapper">
                                                    <section class="toko-posts-grid">
                                                        <div class="note">
                                                            <div class="matches-note">
                                                                NOTE:
                                                            </div>
                                                            <div class="matches-note-text">
                                                                <p align="left">
                                                                    <b>In
                                                                        &apos;Matches&apos; you can mix and match your
                                                                        fabric samples by dragging them into the work area
                                                                        below.
                                                                        Experiment with possible combinations and have fun.
                                                                        <br/>
                                                                        If you want to purchase a fabric in matches area
                                                                        press
                                                                        to "Add All to Basket".
                                                                        <br/>
                                                                        If you want to remove a fabric &nbsp;from
                                                                        your &apos;Matches&apos; drag it to the trash
                                                                        can.
                                                                        <br/>
                                                                        If you want to remove all fabric &nbsp;from
                                                                        your &apos;Matches&apos; press to "Clear Matches".
                                                                        Before experiment with other fabrics you need to clear the area by clicking "Clear Matches".
                                                                    </b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div id="dragZone">
                                                            <div class="dragZoneTitle">Matches Area</div>
                                                            <div id="dragZoneArea">
                                                                <div class="deleteDragImg icon-delete"></div>
                                                                <div class="detailsDragImg"></div>
                                                                <?php echo isset($matches_items) ? $matches_items : '' ?>
                                                            </div>
                                                        </div>
                                                        <b id="b_in_product">
                                                            <a id="all_to_basket"
                                                               href="<?php echo _A_::$app->router()->UrlTo('matches/all_to_cart'); ?>">
                                                                Add
                                                                    All to Basket
                                                                
                                                            </a>
                                                            <a id="clear_matches"
                                                               href="<?php echo _A_::$app->router()->UrlTo('matches/clear'); ?>">
                                                                
                                                                    Clear Matches
                                                                
                                                            </a>
                                                        </b>

                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        (function ($) {
            $(document).ready(
                function (event) {

                    setTimeout(function () {
                        $('html,body').stop().animate({
                            scrollTop: $('#matches-page').offset().top
                        }, 2000);
                    }, 300);
                }
            );

            var a = 1;
            var base_url = '<?= _A_::$app->router()->UrlTo('/'); ?>';

            $('#dragZoneArea > img').mousedown(function (eventObject) {
                $(this).css("z-index", a++);
            });

            $('#dragZoneArea > img').draggable({
                containment: "#dragZoneArea",
                start: function (event, ui) {
                    $(this).css("z-index", a++);
                }

            });

            $(document).on('dblclick', "img#product_img_holder",
                function (event) {
                    var p_id = $(this).attr('data-id');

                    window.location = base_url + 'product?p_id=' + p_id;

                }
            );

            $('.deleteDragImg').droppable({
                hoverClass: "ui-state-hover",
                drop: function (event, ui) {
                    var p_id = $(ui.draggable).attr('data-id');
                    var url = base_url + 'matches/del';
                    $('#content').waitloader('show');
                    $.post(
                        url,
                        {p_id: p_id},
                        function (data) {
                            $(ui.draggable).remove();
                            $('#content').waitloader('remove');
                        }
                    )
                }
            });

            $('.detailsDragImg').droppable({
                hoverClass: "ui-state-hover",
                drop: function (event, ui) {
                    $('#matches-page').waitloader('show');
                    var p_id = $(ui.draggable).attr('data-id');
                    window.location = base_url + 'product?p_id=' + p_id+'&back=matches';
                }
            });

            $('#clear_matches').on('click',
                function (ev) {
                    ev.preventDefault();
                    var url = $(this).attr('href');
                    $('#matches-page').waitloader('show');
                    $.post(url, {},
                        function (data) {
                            $('img#product_img_holder').each(
                                function () {
                                    $(this).remove();
                                }
                            );
                            $('#matches-page').waitloader('remove');

                        }
                    );
                }
            );

            $('#all_to_basket').on('click',
                function (ev) {
                    ev.preventDefault();
                    var products = [];
                    $('#dragZoneArea').children('img').each(
                        function (idx, element) {
                            products.push($(this).attr('data-id'));
                        }
                    );

                    var data = JSON.stringify(products);
                    var url = $(this).attr('href');
                    var load_url = base_url + 'cart/amount';
                    $('#matches-page').waitloader('show');
                    $.post(url, {data: data},
                        function (data) {
                            $.when(
                                $('#matches-page').waitloader('remove'),
                                $(data).appendTo('#matches-page'),
                                $('span#cart_amount').load(load_url)
                            ).done(
                                function () {
                                    debugger;
//                                    if($('span#cart_amount').length>0){
                                        $('#clear_matches').trigger('click');
                                        buttons = {
                                            "Basket": function () {
                                                $(this).remove();
                                                $('#matches-page').waitloader('show');
                                                window.location = base_url + 'cart';
                                            }
                                        };
                                        $('#msg').dialog({
                                            draggable: false,
                                            dialogClass: 'msg',
                                            title: 'Add All to Basket',
                                            modal: true,
                                            zIndex: 10000,
                                            autoOpen: true,
                                            width: '700',
                                            resizable: false,
                                            buttons: buttons,
                                            close: function (event, ui) {
                                                $(this).remove();
                                            }
                                        });
                                        $('.msg').css('z-index', '10001');
                                        $('.ui-widget-overlay').css('z-index', '10000');
//                                    }
                                }
                            );

                        }
                    );
                }
            );

        })(jQuery);

    </script>

<?php
include('views/product/block_footer.php');
?>