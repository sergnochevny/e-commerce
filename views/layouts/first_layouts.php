<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo isset($meta['page_Name']) ? $meta['page_Name'] : ''; ?></title>
    <meta name="KeyWords" content="<?php echo isset($meta['page_KeyWords']) ? $meta['page_KeyWords'] : ''; ?>">
    <meta name="Description" content="<?php echo isset($meta['page_Description']) ? $meta['page_Description'] : ''; ?>">
    <link rel="icon" href="<?php echo $base_url; ?>/views/images/lf-logo.png"/>
    <link rel="shortcut icon" href="<?php echo $base_url; ?>/views/images/lf-logo.png"/>
    <link rel="apple-touch-icon" href="<?php echo $base_url; ?>/views/images/lf-logo.png"/>
    <link rel="apple-touch-icon-precomposed" href="<?php echo $base_url; ?>/views/images/lf-logo.png"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>

    <link rel="apple-touch-startup-image" href="<?php echo $base_url; ?>/views/images/lf-logo.png"/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/woocommerce-layout.css' type='text/css'
          media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/woocommerce-smallscreen.css' type='text/css'
          media='only screen and (max-width: 768px)'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/woocommerce.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/bootstrap.min.css' type='text/css' media='all'/>
    <link rel='stylesheet' id='toko-smartmenu-css'
          href='<?php echo $base_url; ?>/views/css/jquery.smartmenus.bootstrap.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/font-awesome.min.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/js_composer.min.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/simple-line-icons.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/webfont.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/style-theme.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/style-woocommerce.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/style-shortcodes.css' type='text/css' media='all'/>
    <link rel='stylesheet' href='<?php echo $base_url; ?>/views/css/prettyPhoto.min.css' type='text/css' media='all'/>

    <link rel='stylesheet' id='toko-style-css' href='<?php echo $base_url; ?>/views/css/style.css' type='text/css'
          media='all'/>
    <script type="text/javascript">
        WebFontConfig = {
            google: {families: ['Montserrat:400,700:latin', 'Playfair+Display:400,700:latin']}
        };
        (function () {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/jquery_11_3.js'></script>
    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/jquery-migrate.min.js'></script>

    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/jquery.smartmenus.min.js'></script>
    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/jquery.smartmenus.bootstrap.min.js'></script>

    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/jquery.prettyPhoto.js'></script>

    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/script.js'></script>
    <!--<script type='text/javascript' src='views/js/wp-embed.min.js'></script>-->
    <script type='text/javascript' src='<?php echo $base_url; ?>/views/js/js_composer_front.js'></script>
</head>

<?php
include($contentPage);
?>
<footer id="colophon" class="site-footer" role="contentinfo" itemscope="itemscope"
        itemtype="http://schema.org/WPFooter">
    <?php include('views/footer.php')?>
    <div class="footer-credit">
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="footer-credit-left col-md-6 col-xs-12">
                        <p>2016 Copyright &copy; ILuvFabrix</p>
                    </div>
                    <div class="footer-credit-right col-md-6 col-xs-12">
                        <p><img src="<?php echo $base_url; ?>/views/images/temp/payment.png" alt=""></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
if (isset($cart_enable)) {
    ?>
    <a href="<?php echo $base_url; ?>/cart" id="cart" rel="nofollow" class="cart-subtotal">
        <i class="simple-icon-handbag"></i>
    <span class="topnav-label">
        <span id="cart_amount" class="amount">
            $0.00
        </span>
    </span>
    </a>
    <script type="text/javascript">
        (function ($) {
            $('span#cart_amount').load('<?php echo $base_url;?>/cart_amount');
        })(jQuery);
    </script>
    <?php
}
?>

</body>
</html>