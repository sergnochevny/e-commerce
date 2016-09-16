<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link rel='stylesheet' href='<?php _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' type='text/css' media='all'/>
<script type='text/javascript' src='<?php _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

<div class="site-container">
    <?php include "views/shop_header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <?php echo isset($list_categories)?$list_categories:'';?>
            <div id="content" class="main-content-inner" role="main">
                <div class="block-search">
                    <form id="f_search_1" role="search" method="post" class="woocommerce-product-search"
                          action="<?php echo _A_::$app->router()->UrlTo('shop'); ?>">
                        <!--<label class="screen-reader-text" for="s">Search for:</label>-->
                        <input id="search" type="search" class="search-field"
                               placeholder="Search Products&hellip;" value="<?php echo isset($search) ? $search : '' ?>"
                               name="s"
                               title="Search for:"/>
                        <input id="b_search_1" class="button-search" type="button" value="Search"/>
                    </form>

                </div>
                <?php
                if (isset($page_title)) {
                    ?>
                    <p class="woocommerce-page-title">
                    <h3 class="toko-section-title">
                        <?php echo $page_title; ?>
                    </h3>
                    </p>
                    <?php
                }
                ?>
                <?php echo isset($search) ? '<p class="">Search: ' . $search . '</p>' : '' ?>
                <p class="woocommerce-result-count">
                    <?php
                        if (!empty(_A_::$app->get('cat'))) {
                            echo 'CATEGORY: ' . $category_name . '<br/>';
                        }
                        if (!empty(_A_::$app->get('mnf'))) {
                            echo 'MANUFACTURER: ' . $mnf_name . '<br/>';
                        }
                        if (!empty(_A_::$app->get('ptrn'))) {
                            echo 'PATTERN: ' . $ptrn_name . '<br/>';
                        }
                        echo isset($count_rows) ? "Showing " . $count_rows . " results" : "Showing ... results";
                    ?>

                </p>
                <?php
                echo isset($annotation) ? '<p class="annotation">' . $annotation . '</p>' : '';
                ?>
                <ul class="products">
                    <?php
                    echo $list;
                    ?>
                </ul>
                <nav role="navigation" class="paging-navigation">
                    <h4 class="sr-only">Products navigation</h4>
                    <ul class='pagination'>
                        <?php
                        echo isset($paginator) ? $paginator : '';
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = "<?php _A_::$app->router()->UrlTo('/');?>";

    (function ($) {
        $(document)
            .off('.basket')
            .on('click.basket', 'a#to_basket',
                function (event) {
                    event.preventDefault();
                    var url = $(this).attr('href');
                    var container = $(this).parent('figcaption');
                    $('#content').waitloader('show');
                    $.get(
                        url,
                        {},
                        function (answer) {
                            data = JSON.parse(answer);
                            $.when(
                                $('span#cart_amount').html(data.sum),
                                $(data.msg).appendTo('#content')
                            ).done(
                                function () {
                                    if (data.button) {
                                        $(container).html(data.button)
                                    }

                                    $('#content').waitloader('remove');

                                    buttons = {
                                        "Basket": function () {
                                            $(this).remove();
                                            $('#content').waitloader('show');
                                            window.location = base_url + '/cart';
                                        }
                                    };

                                    $('#msg').dialog({
                                        draggable: false,
                                        dialogClass: 'msg',
                                        title: 'Add to Basket',
                                        modal: true,
                                        zIndex: 10000,
                                        autoOpen: true,
                                        width: '500',
                                        resizable: false,
                                        buttons: buttons,
                                        close: function (event, ui) {
                                            $(this).remove();
                                        }
                                    });
                                    $('.msg').css('z-index', '10001');
                                    $('.ui-widget-overlay').css('z-index', '10000');

                                }
                            );
                        }
                    );
                }
            );
        $(document).on('click', '.page-number-s',
            function (event) {

                event.preventDefault();
                var href = $(this).attr('href');
                $('#f_search_1').attr('action', href).trigger('submit');
            }
        );

        $('#b_search_1').on('click',
            function (event) {
                $('#f_search_1').trigger('submit');
            }
        );

        $(document).on('click', '.a_search',
            function (event) {

                event.preventDefault();
                var href = $(this).attr('href');
                $('#f_search_1').attr('action', href).trigger('submit');
            }
        );

    })(jQuery);
</script>

	
    

