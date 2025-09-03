<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item'); ?>>
    <header class="entry-header">

        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                    <?php 
                    // Hiển thị ảnh đại diện của bài viết
                    the_post_thumbnail('medium_large'); 
                    ?>
                <?php else : ?>
                    <?php 
                    // Nếu không có ảnh, hiển thị ảnh mặc định từ thư mục theme
                    // Bạn cần tạo ảnh này và đặt vào đường dẫn bên dưới
                    ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-image.svg" alt="Blog">
                <?php endif; ?>
            </a>
        </div>
        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

        <div class="entry-meta">
            <span class="meta-date">Đăng ngày: <?php echo get_the_date(); ?></span>
            <span class="meta-author">bởi <?php the_author_posts_link(); ?></span>
            <span class="meta-category"><?php the_category(', '); ?></span>
        </div>
    </header>

    <div class="entry-summary">
        <?php the_excerpt(); // Hiển thị đoạn trích ?>
    </div>

    <footer class="entry-footer">
        <a href="<?php the_permalink(); ?>" class="read-more-link">Đọc thêm &rarr;</a>
    </footer>
</article>