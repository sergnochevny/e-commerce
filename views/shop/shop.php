<body
    class="archive paged post-type-archive post-type-archive-product paged-2 post-type-paged-2 woocommerce woocommerce-page header-large ltr wpb-js-composer js-comp-ver-4.8.1 vc_responsive columns-3">

<link rel='stylesheet' href='<?= _A_::$app->router()->UrlTo('views/css/jquery-ui.min.css'); ?>' type='text/css' media='all'/>
<script type='text/javascript' src='<?= _A_::$app->router()->UrlTo('views/js/jquery-ui.min.js'); ?>'></script>

<div class="site-container">
    <?php include "views/shop_header.php"; ?>

    <div class="main-content main-content-shop">
        <div class="container">
            <?= isset($list_categories)?$list_categories:'';?>
            <div id="content" class="main-content-inner" role="main">
                <div class="block-search">
                    <form id="f_search_1" role="search" method="post" class="woocommerce-product-search"
                          action="<?= _A_::$app->router()->UrlTo('shop'); ?>">
                        <!--<label class="screen-reader-text" for="s">Search for:</label>-->
                        <input id="search" type="search" class="search-field"
                               placeholder="Search Products&hellip;" value="<?= isset($search) ? $search : '' ?>"
                               name="s"
                               title="Search for:"/>
                        <input id="b_search_1" class="button-search" type="button" value="Search"/>
                    </form>

                </div>
                <?php
                if (isset($page_title)) {
                    ?>
                    <p class="woocommerce-page-title">
                    <h3 class="just-section-title">
                        <?= $page_title; ?>
                    </h3>
                    </p>
                    <?php
                }
                ?>
                <?= isset($search) ? '<p class="">Search query: <b>' . $search . '</b></p>' : '' ?>
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
<input type="hidden" id="base_url" value="<?php _A_::$app->router()->UrlTo('/');?>">
<script src='<?= _A_::$app->router()->UrlTo('views/js/shop/shop.js'); ?>' type="text/javascript"></script>
	
    

