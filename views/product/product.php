<body
    class="single single-product woocommerce woocommerce-page header-large ltr sticky-header-yes wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3 small-sticky">
<div class="site-container">

    <link rel='stylesheet' href='<?php echo _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>'
          type='text/css' media='all'/>
    <script type='text/javascript'
            src='<?php echo _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

    <?php include "views/header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <form id="f_search_1" role="search" method="post" class="woocommerce-product-search"
                  action="#">
                <input id="search" type="hidden" value="<?php echo isset($search) ? $search : '' ?>" name="s"/>
            </form>

            <a id="back_url" href="<?php echo $back_url; ?>"
               class="<?php echo isset($search) ? 'a_search' : '' ?> button back_button">Back</a><br><br>
            <br/>

            <div id="content" class="main-content-inner" role="main">
                <div
                    class="product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">

                    <div class="images">
                        <?php
                        $img1_exists = true;
                        $filename = 'upload/upload/' . $userInfo['image1'];
                        $filename1 = 'upload/upload/' . 'v_' . $userInfo['image1'];
                        if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                            $filename = "upload/upload/not_image.jpg";
                            $filename1 = null;
                            $img1_exists = false;
                        }
                        $filename = $base_url . '/' . $filename;
                        $filename1 = isset($filename1) ? $base_url . '/' . $filename1 : null;
                        ?>
                        <a <?php echo isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                            itemprop="image"
                            class="woocommerce-main-image zoom"
                            title=""
                            <?php echo isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                            <?php echo isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                            <img width="499" height="499"
                                 src="<?php echo isset($filename1) ? $filename1 : $filename; ?>"
                                 class="attachment-shop_single size-shop_single wp-post-image" alt="" title=""/>
                        </a>

                        <div class="thumbnails columns-4">
                            <?php
                            if (!empty($userInfo['image2']) || !empty($userInfo['image3']) ||
                                !empty($userInfo['image4']) || !empty($userInfo['image5'])
                            ) {
                                ?>
                                <p><b>MORE IMAGES OF THIS FABRIC</b></p>
                                <?php
                            }
                            if (!empty($userInfo['image2'])) {
                                $filename = 'upload/upload/' . $userInfo['image2'];
                                $filename1 = 'upload/upload/' . 'v_' . $userInfo['image2'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = $base_url . '/' . $filename;
                                $filename1 = isset($filename1) ? $base_url . '/' . $filename1 : null;
                                ?>
                                <a <?php echo isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?php echo isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?php echo isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?php echo $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }

                            if (!empty($userInfo['image3'])) {
                                $filename = 'upload/upload/' . $userInfo['image3'];
                                $filename1 = 'upload/upload/' . 'v_' . $userInfo['image3'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = $base_url . '/' . $filename;
                                $filename1 = isset($filename1) ? $base_url . '/' . $filename1 : null;
                                ?>
                                <a <?php echo isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?php echo isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?php echo isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?php echo $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }
                            if (!empty($userInfo['image4'])) {
                                $filename = 'upload/upload/' . $userInfo['image4'];
                                $filename1 = 'upload/upload/' . 'v_' . $userInfo['image4'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = $base_url . '/' . $filename;
                                $filename1 = isset($filename1) ? $base_url . '/' . $filename1 : null;
                                ?>
                                <a <?php echo isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?php echo isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?php echo isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?php echo $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }
                            if (!empty($userInfo['image5'])) {
                                $filename = 'upload/upload/' . $userInfo['image5'];
                                $filename1 = 'upload/upload/' . 'v_' . $userInfo['image5'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = $base_url . '/' . $filename;
                                $filename1 = isset($filename1) ? $base_url . '/' . $filename1 : null;
                                ?>
                                <a <?php echo isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?php echo isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?php echo isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?php echo $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div class="summary entry-summary">
                        <h1 class="product_title product_title_style entry-title"><?= $userInfo['pname']; ?></h1>

                        <div class="product_title_desc">
                            <p><?= $userInfo['ldesc']; ?></p>
                        </div>
                        <div class="product_title_price">
                            <?php if ($sys_hide_price == 0 && $hide_price == 0) { ?>
                                <p class="price">Price:
                                    <ins>
                                    <span class="amount">
                                    <?php echo $format_price; ?>
                                    </span>
                                    </ins>
                                </p>
                            <?php } ?>
                        </div>
                        <table class="table table-bordered table-striped red">
                            <tbody>
                            <?php echo isset($discount_info) ? $discount_info : '' ?>
                            </tbody>
                        </table>
                        <div class="quantity"></div>

                        <b id="b_in_product">
                            <?php
                            $pid = _A_::$app->get('p_id');
                            if ($userInfo['inventory'] > 0) {
                                ?>
                                <a id="add_cart"
                                   href="<?php echo _A_::$app->router()->UrlTo('cart/add', ['p_id' => $pid]) ?>" <?php echo !isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add to cart
                                    </button>
                                </a>
                                <a id="view_cart"
                                   href="<?php echo _A_::$app->router()->UrlTo('cart') ?>" <?php echo isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Basket
                                    </button>
                                </a>
                            <?php } ?>
                        </b>

                        <b id="b_in_product">
                            <?php
                            if ($userInfo['inventory'] > 0 && $allowed_samples) {
                                ?>
                                <a id="add_samples_cart"
                                   href="<?php echo _A_::$app->router()->UrlTo('cart/add_samples', ['p_id' => $pid]) ?>" <?php echo !isset($in_samples_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add Samples
                                    </button>
                                </a>
                            <?php } ?>
                        </b>

                        <b id="b_in_product">
                            <?php
                            $ahref = 'mailto:info@iluvfabrix.com?subject=' . rawurlencode($userInfo['sdesc'] . ' ' . $userInfo['pnumber']);
                            $mhref = _A_::$app->router()->UrlTo('matches/add',['p_id' => $pid]);
                            ?>
                            <a href="<?php echo $ahref; ?>">
                                <button type="button" class="single_add_to_cart_button button alt">Ask a Question
                                </button>
                            </a>
                            <?php if ($img1_exists) { ?>
                                <a id="add_matches"
                                   href="<?php echo $mhref; ?>" <?php echo !isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add to Matches
                                    </button>
                                </a>
                                <a id="view_matches"
                                   href="<?php echo _A_::$app->router()->UrlTo('matches'); ?>" <?php echo isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">View Matches
                                    </button>
                                </a>
                            <?php } ?>
                        </b>

                        <div class="product_meta">
                            <h3>DETAILS</h3>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td class="row_title"><b>Name</b>:</td>
                                    <td><?= $userInfo['pname']; ?></td>
                                </tr>
                                <tr>
                                    <td class="row_title"><b>Product #</b>:</td>
                                    <td><?= $userInfo['pnumber']; ?></td>
                                </tr>
                                <?php if (($userInfo['piece'] == 1) && ($userInfo['inventory'] > 0)) { ?>
                                    <tr>
                                        <td class="row_title"><b>Dimensions</b>:</td>
                                        <td><?php echo $userInfo['dimensions']; ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td class="row_title"><b>Width</b>:</td>
                                        <td><?php echo $userInfo['width']; ?></td>
                                    </tr>
                                    <tr style="<?php echo ($userInfo['inventory'] > 0) ? '' : 'color: red;'; ?>">
                                        <td class="row_title"><b>Avail. yardage</b>:</td>
                                        <td><?php echo $userInfo['inventory'];
                                            ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        (function ($) {
            var base_url = '<?php echo _A_::$app->router()->UrlTo('/');?>';
            var back_url = '<?php echo $back_url;?>';

            $('a#add_cart').on('click',
                function (event) {
                    event.preventDefault();
                    var url = $(this).attr('href');
                    $('#content').waitloader('show');
                    $.get(
                        url,
                        {},
                        function (answer) {
                            data = JSON.parse(answer);
                            $.when(
                                $('span#cart_amount').html(data.sum),
                                $(data.msg).appendTo('#content'),
                                $('#add_cart').fadeOut(),
                                $('#view_cart').fadeIn()
                            ).done(
                                function () {
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

            $('a#add_samples_cart').on('click',
                function (event) {
                    event.preventDefault();
                    var url = $(this).attr('href');
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

            $(document).ready(
                function (event) {
                    $('a#add_matches').on('click',
                        function (ev) {
                            ev.preventDefault();
                            $('#content').waitloader('show');
                            var url = $(this).attr('href');
                            $.post(url,
                                {},
                                function (data) {
                                    var answer = JSON.parse(data);
                                    $.when(
                                        $('#content').waitloader('remove'),
                                        $(answer.data).appendTo('#content')
                                    ).done(
                                        function () {
                                            buttons = {
                                                "Continue shopping": function () {
                                                    $('#content').waitloader('show');
                                                    if ($('.a_search').length > 0) {
                                                        $('.a_search').trigger('click');
                                                    } else
                                                        window.location = back_url;
                                                }
                                            };

                                            if (answer.added == 1) {
                                                $('#add_matches').fadeOut();
                                                $('#view_matches').fadeIn();
                                                $.extend(buttons, {
                                                    "Matches": function () {
                                                        $(this).remove();
                                                        $('#content').waitloader('show');
                                                        window.location = base_url + '/matches';
                                                    }
                                                });
                                            }

                                            $('#msg').dialog({
                                                draggable: false,
                                                dialogClass: 'msg',
                                                title: 'Add to Matches',
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
                }
            );

            $('.a_search').on('click',
                function (event) {
                    event.preventDefault();
                    $('#f_search_1').attr('action', back_url);
                    $('#f_search_1').trigger('submit');
                }
            );
        })(jQuery);

    </script>



	
  
    
    