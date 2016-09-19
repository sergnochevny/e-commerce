<body
    class="single single-product woocommerce woocommerce-page header-large ltr sticky-header-yes wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3 small-sticky">
<div class="site-container">

    <link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>'
          type='text/css' media='all'/>
    <script type='text/javascript'
            src='<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

    <?php include "views/header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <form id="f_search_1" role="search" method="post" class="woocommerce-product-search"
                  action="#">
                <input id="search" type="hidden" value="<?= isset($search) ? $search : '' ?>" name="s"/>
            </form>

            <a id="back_url" href="<?= $back_url; ?>"
               class="<?= isset($search) ? 'a_search' : '' ?> button back_button">Back</a><br><br>
            <br/>

            <div id="content" class="main-content-inner" role="main">
                <div
                    class="product type-product status-publish has-post-thumbnail product_cat-brooches product_tag-fashion product_tag-jewelry sale featured shipping-taxable purchasable product-type-simple product-cat-brooches product-tag-fashion product-tag-jewelry instock">

                    <div class="images">
                        <?php
                        $img1_exists = true;
                        $filename = 'upload/upload/' . $data['image1'];
                        $filename1 = 'upload/upload/' . 'v_' . $data['image1'];
                        if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                            $filename = "upload/upload/not_image.jpg";
                            $filename1 = null;
                            $img1_exists = false;
                        }
                        $filename = _A_::$app->router()->UrlTo($filename);
                        $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1): null;
                        ?>
                        <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                            itemprop="image"
                            class="woocommerce-main-image zoom"
                            title=""
                            <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                            <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                            <img width="499" height="499"
                                 src="<?= isset($filename1) ? $filename1 : $filename; ?>"
                                 class="attachment-shop_single size-shop_single wp-post-image" alt="" title=""/>
                        </a>

                        <div class="thumbnails columns-4">
                            <?php
                            if (!empty($data['image2']) || !empty($data['image3']) ||
                                !empty($data['image4']) || !empty($data['image5'])
                            ) {
                                ?>
                                <p><b>MORE IMAGES OF THIS FABRIC</b></p>
                                <?php
                            }
                            if (!empty($data['image2'])) {
                                $filename = 'upload/upload/' . $data['image2'];
                                $filename1 = 'upload/upload/' . 'v_' . $data['image2'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = _A_::$app->router()->UrlTo($filename);
                                $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1): null;
                                ?>
                                <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?= $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }

                            if (!empty($data['image3'])) {
                                $filename = 'upload/upload/' . $data['image3'];
                                $filename1 = 'upload/upload/' . 'v_' . $data['image3'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = _A_::$app->router()->UrlTo($filename);
                                $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1): null;
                                ?>
                                <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?= $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }
                            if (!empty($data['image4'])) {
                                $filename = 'upload/upload/' . $data['image4'];
                                $filename1 = 'upload/upload/' . 'v_' . $data['image4'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = _A_::$app->router()->UrlTo($filename);
                                $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1): null;
                                ?>
                                <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?= $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }
                            if (!empty($data['image5'])) {
                                $filename = 'upload/upload/' . $data['image5'];
                                $filename1 = 'upload/upload/' . 'v_' . $data['image5'];
                                if (!(file_exists($filename) && is_file($filename) && is_readable($filename))) {
                                    $filename = "upload/upload/not_image.jpg";
                                    $filename1 = null;
                                }
                                $filename = _A_::$app->router()->UrlTo($filename);
                                $filename1 = isset($filename1) ? _A_::$app->router()->UrlTo($filename1): null;
                                ?>
                                <a <?= isset($filename1) ? 'href="' . $filename1 . '"' : ''; ?>
                                    class="zoom"
                                    title=""
                                    <?= isset($filename1) ? 'data-rel="prettyPhoto[product-gallery]"' : ''; ?>
                                    <?= isset($filename1) ? 'data-img = "' . $filename1 . '"' : '' ?>>
                                    <img width="110" height="110" src="<?= $filename; ?>"
                                         class="attachment-shop_thumbnail size-shop_thumbnail" alt="" title=""/>
                                </a>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div class="summary entry-summary">
                        <h1 class="product_title product_title_style entry-title"><?= $data['pname']; ?></h1>

                        <div class="product_title_desc">
                            <p><?= $data['ldesc']; ?></p>
                        </div>
                        <div class="product_title_price">
                            <?php if ($sys_hide_price == 0 && $hide_price == 0) { ?>
                                <p class="price">Price:
                                    <ins>
                                    <span class="amount">
                                    <?= $format_price; ?>
                                    </span>
                                    </ins>
                                </p>
                            <?php } ?>
                        </div>
                        <table class="table table-bordered table-striped red">
                            <tbody>
                            <?= isset($discount_info) ? $discount_info : '' ?>
                            </tbody>
                        </table>
                        <div class="quantity"></div>

                        <b id="b_in_product">
                            <?php
                            $pid = _A_::$app->get('p_id');
                            if ($data['inventory'] > 0) {
                                ?>
                                <a id="add_cart"
                                   href="<?= _A_::$app->router()->UrlTo('cart/add', ['p_id' => $pid]) ?>" <?= !isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add to cart
                                    </button>
                                </a>
                                <a id="view_cart"
                                   href="<?= _A_::$app->router()->UrlTo('cart') ?>" <?= isset($in_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Basket
                                    </button>
                                </a>
                            <?php } ?>
                        </b>

                        <b id="b_in_product">
                            <?php
                            if ($data['inventory'] > 0 && $allowed_samples) {
                                ?>
                                <a id="add_samples_cart"
                                   href="<?= _A_::$app->router()->UrlTo('cart/add_samples', ['p_id' => $pid]) ?>" <?= !isset($in_samples_cart) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add Samples
                                    </button>
                                </a>
                            <?php } ?>
                        </b>

                        <b id="b_in_product">
                            <?php
                            $ahref = 'mailto:info@iluvfabrix.com?subject=' . rawurlencode($data['sdesc'] . ' ' . $data['pnumber']);
                            $mhref = _A_::$app->router()->UrlTo('matches/add',['p_id' => $pid]);
                            ?>
                            <a href="<?= $ahref; ?>">
                                <button type="button" class="single_add_to_cart_button button alt">Ask a Question
                                </button>
                            </a>
                            <?php if ($img1_exists) { ?>
                                <a id="add_matches"
                                   href="<?= $mhref; ?>" <?= !isset($in_matches) ? '' : 'style="display: none;"'; ?>>
                                    <button type="button" class="single_add_to_cart_button button alt">Add to Matches
                                    </button>
                                </a>
                                <a id="view_matches"
                                   href="<?= _A_::$app->router()->UrlTo('matches'); ?>" <?= isset($in_matches) ? '' : 'style="display: none;"'; ?>>
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
                                    <td><?= $data['pname']; ?></td>
                                </tr>
                                <tr>
                                    <td class="row_title"><b>Product #</b>:</td>
                                    <td><?= $data['pnumber']; ?></td>
                                </tr>
                                <?php if (($data['piece'] == 1) && ($data['inventory'] > 0)) { ?>
                                    <tr>
                                        <td class="row_title"><b>Dimensions</b>:</td>
                                        <td><?= $data['dimensions']; ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td class="row_title"><b>Width</b>:</td>
                                        <td><?= $data['width']; ?></td>
                                    </tr>
                                    <tr style="<?= ($data['inventory'] > 0) ? '' : 'color: red;'; ?>">
                                        <td class="row_title"><b>Avail. yardage</b>:</td>
                                        <td><?= $data['inventory'];
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
            var base_url = '<?= _A_::$app->router()->UrlTo('/');?>',
                back_url = '<?= $back_url;?>';

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
                                            window.location = base_url + 'cart';
                                        }
                                    };

                                    $('#msg').dialog({
                                        draggable: false,
                                        dialogClass: 'msg',
                                        title: 'Added to Basket',
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
                                            window.location = base_url + 'cart';
                                        }
                                    };

                                    $('#msg').dialog({
                                        draggable: false,
                                        dialogClass: 'msg',
                                        title: 'Added to Basket',
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
                                                        window.location = base_url + 'matches';
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
                    $('#f_search_1').attr('action', back_url)
                                    .trigger('submit');
                }
            );
        })(jQuery);

    </script>



	
  
    
    