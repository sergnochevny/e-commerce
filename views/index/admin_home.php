<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link type='text/css' href='modal_windows/modal_windows/css/confirm.css' rel='stylesheet' media='screen'/>

<div class="site-container">
    <?php include "views/header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <center>
                    <a href="<?php echo $add_product_href; ?>">
                        <input type="submit" value="ADD NEW PRODUCT" class="button"/>
                    </a><br>
                </center>
                <h1 class="page-title">
                    <?php
                    //                            echo $object->catigori_name();
                    ?>
                </h1>
                <p class="woocommerce-result-count">Showing <?php echo $count_rows; ?> results</p>
                <form class="woocommerce-ordering" method="get">
                    <?php
                    $rows = $ProductFiltrList['catigori_in_select'];
                    ?>
                    <select
                        onChange="if(this.options[this.selectedIndex].value!=''){window.location=this.options[this.selectedIndex].value}else{this.options[selectedIndex=0];}"
                        class="orderby">
                        <option value="admin_home">--FILTER BY CATEGORY--</option>

                        <?php
                        foreach ($rows as $row) {
                            ?>

                            <option
                                value="admin_home?cat=<?php echo $row[0]; ?>" <?php echo (isset($_GET['cat']) && ($row[0] == $_GET['cat'])) ? 'selected' : ''; ?>><?php echo $row[1]; ?></option>

                        <?php } ?>

                    </select>
                </form>
                <ul class="products">
                    <div class="product-inner">
                        <?php
                        echo $produkt_list;
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

        $(document).on('click', "#del_product",
            function (event) {
                event.preventDefault();

                var href = $(this).attr('href');

                $("#confirm_action").on('click.confirm_action',
                    function (event) {
                        event.preventDefault();
                        $("#confirm_dialog").removeClass('overlay_display');
                        window.location.href = href;
                    }
                );

                $("#confirm_dialog").addClass('overlay_display');
            }
        );
    })(jQuery);
</script>


 