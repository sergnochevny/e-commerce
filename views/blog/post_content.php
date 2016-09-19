<section class="toko-posts-grid">
    <div class="toko-post-row row">
        <div class="toko-post col-xs-12" id="blog-page">
            <a href="<?= $back_url; ?>" class="button back_button">Back</a>

            <br/>

            <h1 class="page-title"><?= $post_title; ?></h1>

            <?php if (isset($post_img)) { ?>
                <div class="toko-post-image"
                     style="background-image: url('<?= $post_img; ?>');">
                </div>
            <?php } ?>
            <div class="toko-post-detail">
                <div
                    class="toko-divider text-center line-yes icon-hide">
                    <div class="divider-inner"
                         style="background-color: #fff">
                        <span class="post-date"><?= $post_date; ?></span>
                    </div>
                </div>
                <div><?= $post_content; ?></div>
            </div>

        </div>
    </div>
</section>
