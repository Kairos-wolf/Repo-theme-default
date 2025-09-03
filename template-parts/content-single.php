<div class="single-post-container">

    <article id="post-<?php the_ID(); ?>" <?php post_class('newspaper-article-full'); ?>>
        
        <header class="entry-header">
            <div class="header-content">
                <div class="meta-category">
                    <?php the_category(' '); ?>
                </div>
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                <?php if (has_excerpt()) : ?>
                    <p class="entry-excerpt"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                <div class="entry-meta-details">
                    <span class="meta-author">
                        bởi <?php the_author_posts_link(); ?>
                    </span>
                    <span class="separator">|</span>
                    <span class="meta-date">
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="separator">|</span>
                    <span class="meta-reading-time">
                        <?php echo get_post_reading_time(); ?>
                    </span>
                </div>
            </div>
        </header>

        <div class="social-share">
            <span>Chia sẻ:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="social-icon facebook">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title_attribute(); ?>" target="_blank" class="social-icon twitter">Twitter</a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" target="_blank" class="social-icon linkedin">LinkedIn</a>
        </div>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php
            the_content();
            wp_link_pages(array(
                'before' => '<div class="page-links">' . __('Pages:', 'ht'),
                'after'  => '</div>',
            ));
            ?>
        </div>

        <footer class="entry-footer">
            <?php the_tags('<div class="post-tags"><span class="tag-label">Tags:</span> ', '', '</div>'); ?>
        </footer>

        <?php if (get_the_author_meta('description')) : ?>
            <div class="author-box">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('user_email'), 90); ?>
                </div>
                <div class="author-info">
                    <h4 class="author-name"><?php the_author(); ?></h4>
                    <div class="author-rating">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star half">&#9733;</span>
                    </div>
                    <p class="author-description"><?php the_author_meta('description'); ?></p>
                </div>
            </div>
        <?php endif; ?>

    </article>

    

    <section class="related-posts-section">
        <h3 class="section-title">Bài viết liên quan</h3>
        <div class="swiper" id="related-posts-slider">
            <div class="swiper-wrapper">
                <?php echo get_related_posts_slides(get_the_ID()); ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Chỉ khởi tạo slider nếu phần tử tồn tại
    if (document.querySelector('#related-posts-slider')) {
        const swiper = new Swiper('#related-posts-slider', {
            // Tùy chọn
            direction: 'horizontal',
            loop: true, // Lặp lại khi hết slide
            slidesPerView: 1, // Mặc định hiển thị 1 slide
            spaceBetween: 30, // Khoảng cách giữa các slide

            // Cấu hình cho các kích thước màn hình khác nhau
            breakpoints: {
                // Khi chiều rộng màn hình >= 768px
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // Khi chiều rộng màn hình >= 1024px
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40
                }
            },

            // Kích hoạt nút điều hướng
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
});
</script>