<div class="toko-post col-xs-12 col-sm-6 col-md-4">
    <div class="toko-post-image"
         style="background-image: url('<?= isset($post_img)?$post_img:'';?>');">
        <a href="<?= $post_href;?>"></a>
    </div>
    <div class="toko-post-detail">
        <h3 class="post-title"><a href="<?= $post_href;?>"><?= isset($post_title)?$post_title:'';?></a></h3>

        <div
            class="toko-divider text-center line-yes icon-hide">
            <div class="divider-inner"
                 style="background-color: #fff">
                <span class="post-date"><?= $post_date;?></span>
            </div>
        </div>
        <p><span class="opa"></span><?= $post_content;?></p>
        <a href="<?= $post_href;?>" rel="bookmark" class="more-link"><i
                class="fa fa-arrow-circle-right"></i> Read
            more</a>
    </div>
</div>
