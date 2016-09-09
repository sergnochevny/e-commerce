<div class="toko-post col-xs-12 col-sm-6 col-md-4">
    <div class="toko-post-image"
         style="background-image: url('<?php echo isset($post_img)?$post_img:'';?>');">
        <a href="<?php echo $post_href;?>"></a>
    </div>
    <div class="toko-post-detail">
        <h3 class="post-title"><a href="<?php echo $post_href;?>"><?php echo isset($post_title)?$post_title:'';?></a></h3>

        <div
            class="toko-divider text-center line-yes icon-hide">
            <div class="divider-inner"
                 style="background-color: #fff">
                <span class="post-date"><?php echo $post_date;?></span>
            </div>
        </div>
        <p><span class="opa"></span><?php echo $post_content;?></p>
        <a href="<?php echo $post_href;?>" rel="bookmark" class="more-link"><i
                class="fa fa-arrow-circle-right"></i> Read
            more</a>
    </div>
</div>
