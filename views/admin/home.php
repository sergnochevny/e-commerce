<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<div class="site-container">
    <?php include "views/header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <div id="content" class="main-content-inner" role="main">
                <div class="text-center header-to-action">
                    <a href="<?= $add_product_href; ?>">
                        <input type="submit" value="ADD NEW PRODUCT" class="button"/>
                    </a>
                </div>
                <p class="woocommerce-result-count">Showing <?= $count_rows; ?> results</p>
                <form class="woocommerce-ordering" method="get">
                    <?php $rows = $ProductFilterList['category_in_select']; ?>
                    <select
                        onChange="if(this.options[this.selectedIndex].value!=''){window.location=this.options[this.selectedIndex].value}else{this.options[selectedIndex=0];}"
                        class="orderby" style="min-width: 210px">
                        <option value="admin_home">--FILTER BY CATEGORY--</option>
                        <?php foreach ($rows as $row) { ?>
                            <option value="<?= _A_::$app->router()->UrlTo('admin/home', ['cat' => $row[0]]) ?>"
                                <?= (!is_null(_A_::$app->get('cat')) && ($row[0] == _A_::$app->get('cat'))) ? 'selected' : ''; ?>><?= $row[1]; ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
                <ul class="products">
                    <?= $list; ?>
                </ul>
                <nav role="navigation" class="paging-navigation">
                    <h4 class="sr-only">Products navigation</h4>
                    <ul class='pagination'>
                        <?= isset($paginator) ? $paginator : '';?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<div id="confirm_dialog" class="overlay"></div>
<div class="popup">
    <div class="fcheck"></div>
    <a class="close" title="close">&times;</a>

    <div class="b_cap_cod_main">
        <p style="color: black;" class="text-center"><b>You confirm the removal?</b></p>
        <br/>
        <div class="text-center" style="width: 100%">
            <a id="confirm_action">
                <input type="button" value="Yes confirm" class="button"/></a>
            <a id="confirm_no">
                <input type="button" value="No" class="button"/></a>
        </div>
    </div>
</div>
<script src='<?= _A_::$app->router()->UrlTo('views/js/admin/home.js'); ?>' type="text/javascript"></script>